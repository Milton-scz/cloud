<script setup>
import { computed, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';
const qrImage = ref('');
const numeroTransaccion = ref('');
const modalMessage = ref('');
const isModalVisible = ref(false);
const props = defineProps({
    users: Array,
    qrImage: String,
    numeroTransaccion: String
});
qrImage.value = props.qrImage;
const form = useForm({
  name: '',
  cedula: '',
  tnTelefono: '',
  tcRazonSocial: '',
  tcCorreo: '',
  tcCiNit: '',
  tnMonto: 0.01,
  taPedidoDetalle: [],
  tnTipoServicio: '',
});
const roles = computed(() => window.Laravel?.roles || []);
const permissions = computed(() => window.Laravel?.permissions || []);
const userData = computed(() => window.Laravel?.user || {});

const selectedCliente = ref(null);

// Función para validar los campos
const validateForm = () => {
  const errors = {};

  if (!form.name) {
    errors.name = 'El nombre es obligatorio.';
  }

  if (!form.cedula) {
    errors.cedula = 'La cédula es obligatoria.';
  }

  if (!form.tcCorreo) {
    errors.tcCorreo = 'El correo es obligatorio.';
  } else if (!/\S+@\S+\.\S+/.test(form.tcCorreo)) {
    errors.tcCorreo = 'Por favor ingresa un correo válido.';
  }

  if (!form.tnTelefono) {
    errors.tnTelefono = 'El teléfono es obligatorio.';
  }

  if (!form.tcCiNit) {
    errors.tcCiNit = 'El CI/NIT es obligatorio.';
  }

  if (!form.tcRazonSocial) {
    errors.tcRazonSocial = 'La razón social es obligatoria.';
  }

  if (!form.tnMonto || form.tnMonto <= 0) {
    errors.tnMonto = 'El monto total debe ser mayor a 0.';
  }

  if (!form.tnTipoServicio) {
    errors.tnTipoServicio = 'Selecciona un tipo de servicio.';
  }

  return errors;
};

// Función para manejar el envío del formulario
const submitForm = (event) => {
  event.preventDefault();  // Esto previene que el formulario se envíe y recargue la página

  form.errors = {};
  const errors = validateForm();

  // Si hay errores, los mostramos
  if (Object.keys(errors).length > 0) {
    for (const [key, value] of Object.entries(errors)) {
      form.errors[key] = value;
    }
    return;
  }

  const pedidoDetalle = localStorage.getItem('carrito');
  if (pedidoDetalle) {
    try {
      form.taPedidoDetalle = JSON.parse(pedidoDetalle);
    } catch (error) {
      console.error('Error al parsear los datos de pedidoDetalle:', error);
    }
  }
  console.log("form:", form);
  console.log('URL:', route('admin.pagos.generarCobro'));

  axios.post(route('admin.pagos.generarCobro'), form)
    .then(response => {
      console.log(response.data.qrImage);
      qrImage.value = response.data.qrImage;
      numeroTransaccion.value = response.data.nroTransaccion;
      console.log('Número transacción:', numeroTransaccion.value);
      consultarTransaccion(numeroTransaccion.value);
    })
    .catch(error => {
      console.log('Hubo un error al crear la venta', error);
    });
};


// Función para consultar la transacción
const consultarTransaccion = (nroTransaccion) => {
  const intervalID = setInterval(async () => {
    try {
      console.log('Entrando en la consulta de transacción:', nroTransaccion);

      const response = await axios.get(route('landing.pagos.consultar'), {
        params: { venta_id: nroTransaccion },
      });


      if (response.data.trim() === "COMPLETADO-PROCESADO") {
        clearInterval(intervalID);
        showModal("Su pedido fue pagado con éxito!!!!");
      }
    } catch (error) {
      console.error('Error al consultar la transacción:', error);
    }
  }, 10000);

};
function showModal(mensaje) {
  modalMessage.value = mensaje;
  isModalVisible.value = true;
}

function closeModal() {
  isModalVisible.value = false;
}
const actualizarDatos = () => {
  if (selectedCliente.value) {
    form.name = selectedCliente.value.name;
    form.cedula = selectedCliente.value.cedula;
    form.tcCorreo = selectedCliente.value.email;
    form.tnTelefono = selectedCliente.value.celular;
    form.tcCiNit = selectedCliente.value.cedula || '';
    form.tcRazonSocial = 'GRUPO-01';
    form.tnMonto = 0.01;
  }
};
</script>

<template>
  <Head title="Crear Venta" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Crear Venta</h2>
    </template>
  <!-- Modal de éxito -->
  <div v-if="isModalVisible" class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50">
  <div class="bg-white p-6 rounded-lg shadow-lg">
    <p class="text-lg font-bold text-center">{{ modalMessage }}</p>
    <!-- Contenedor del botón de cerrar centrado -->
    <div class="mt-4 flex justify-center">
      <button @click="closeModal" class="bg-blue-500 text-white p-2 rounded">Cerrar</button>
    </div>
  </div>
</div>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <!-- Contenedor Principal -->
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <!-- Bloque superior centrado -->
            <div class="mb-6 text-center">
              <h3 class="text-3xl font-bold">PagoFacil QR y Tigo Money</h3>
              <p class="text-blue-500">Integración de servicios PagoFacil</p>
            </div>

            <!-- División en dos columnas -->
            <div class="flex flex-col md:flex-row space-y-6 md:space-y-0 md:space-x-6">
              <!-- Primera Parte: Formulario -->
              <div class="md:w-1/2 space-y-4">
                <h3 class="text-2xl font-bold">Datos para la factura</h3>
                <form @submit="submitForm" target="QrImage">
                  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Columna de datos del cliente -->
                    <div class="space-y-6">
                      <div>
                        <label for="cliente" class="block text-sm font-medium text-gray-700">Cliente</label>
                        <select v-model="selectedCliente" @change="actualizarDatos" id="cliente" name="cliente" class="mt-1 block w-full border-2 border-gray-400 text-gray-800 bg-white rounded-md shadow-sm">
                          <option value="" disabled>Seleccionar Cliente</option>
                          <option v-for="user in props.users" :key="user.id" :value="user">
                            {{ user.name }}
                          </option>
                        </select>
                      </div>

                      <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input v-model="form.name" type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                        <p v-if="form.errors.name" class="text-sm text-red-500 mt-2">{{ form.errors.name }}</p>
                      </div>

                      <div>
                        <label for="cedula" class="block text-sm font-medium text-gray-700">Cédula</label>
                        <input v-model="form.cedula" type="text" id="cedula" name="cedula" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                        <p v-if="form.errors.cedula" class="text-sm text-red-500 mt-2">{{ form.errors.cedula }}</p>
                      </div>

                      <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo</label>
                        <input v-model="form.tcCorreo" type="email" id="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                        <p v-if="form.errors.tcCorreo" class="text-sm text-red-500 mt-2">{{ form.errors.tcCorreo }}</p>
                      </div>

                      <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input v-model="form.tnTelefono" type="text" id="telefono" name="telefono" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                        <p v-if="form.errors.tnTelefono" class="text-sm text-red-500 mt-2">{{ form.errors.tnTelefono }}</p>
                      </div>
                    </div>

                    <!-- Columna de otros datos -->
                    <div class="space-y-6">
                      <div>
                        <label for="ciNit" class="block text-sm font-medium text-gray-700">CI/NIT</label>
                        <input v-model="form.tcCiNit" type="text" id="ciNit" name="ciNit" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                        <p v-if="form.errors.tcCiNit" class="text-sm text-red-500 mt-2">{{ form.errors.tcCiNit }}</p>
                      </div>

                      <div>
                        <label for="tcRazonSocial" class="block text-sm font-medium text-gray-700">Razón Social</label>
                        <input v-model="form.tcRazonSocial" type="text" id="tcRazonSocial" name="tcRazonSocial" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                        <p v-if="form.errors.tcRazonSocial" class="text-sm text-red-500 mt-2">{{ form.errors.tcRazonSocial }}</p>

                    </div>

                      <div>
                        <label for="tnMonto" class="block text-sm font-medium text-gray-700">Monto Total</label>
                        <input v-model="form.tnMonto" type="decimal" id="tnMonto" name="tnMonto" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                        <p v-if="form.errors.tnMonto" class="text-sm text-red-500 mt-2">{{ form.errors.tnMonto }}</p>
                      </div>

                      <div>
        <label for="tipoServicio" class="block text-sm font-medium text-gray-700">Tipo de Servicio</label>
        <select
          v-model="form.tnTipoServicio"
          id="tipoServicio"
          class="mt-1 block w-full border p-2 rounded-md shadow-sm"
        >
          <option value="1">Servicio QR</option>
          <option value="2">Tigo Money</option>
        </select>
        <p v-if="form.errors.tnTipoServicio" class="text-sm text-red-500 mt-2">{{ form.errors.tnTipoServicio }}</p>
      </div>

                    </div>
                  </div>
                  <div class="mt-6 text-right">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md">Generar Cobro</button>
                  </div>
                </form>
              </div>
              <!-- Segunda Parte: Imagen QR -->
              <div class="md:w-1/2 flex justify-center items-center">
                <div v-if="qrImage" class="w-full max-w-md">
                  <img :src="qrImage" alt="QR Code" class="w-full h-auto" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
