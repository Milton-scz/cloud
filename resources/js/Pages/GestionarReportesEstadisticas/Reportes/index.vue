<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from 'vue';
import Graficos from '@/Components/Graficos.vue';
import { Inertia } from '@inertiajs/inertia';
import moment from 'moment';
const modalVisible = ref(false); // Para controlar la visibilidad del modal
const destinatario = ref('');
const asunto = ref('');
const mensaje = ref('');
const modalType = ref(''); // Controlar el tipo de modal a mostrar

const message = ref('');
const page = usePage();
const ventapormes = ref(page.props.ventasPorMes);
// Datos de los productos vendidos
const productosVendidos = ref(page.props.productosVendidos);
const monthNames = [
  'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
  'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
];
const roles = computed(() => window.Laravel?.roles || []);
const permissions = computed(() => window.Laravel?.permissions || []);
const userData = computed(() => window.Laravel?.user || {});

const hasRole = (role) => {
  return roles.value.includes(role);
};

const hasPermission = (permission) => {
  return permissions.value[permission] === true;
};

const ventasPorMes = new Array(12).fill(0);

ventapormes.value.forEach(venta => {
  const monthIndex = venta.mes - 1;
  ventasPorMes[monthIndex] = venta.monto_total;
});

const barChartData = ref({
  labels: monthNames,
  datasets: [
    {
      label: 'Ventas por mes',
      data: ventasPorMes,
      backgroundColor: '#42A5F5',
      borderColor: '#1E88E5',
      borderWidth: 1
    }
  ]
});


const nombresProductosVendidos = ref([]);
const cantidadesProductosVendidos = ref([]);



  productosVendidos.value.forEach(producto => {
      nombresProductosVendidos.value.push(producto.nombre);
      console.log("IDs: " + producto.id);
      console.log("nombres: "+nombresProductosVendidos.value);

      cantidadesProductosVendidos.value.push(producto.cantidad);
      console.log("cantidades: "+cantidadesProductosVendidos.value);
  });

  const selectedProduct = ref(null);
// Función que actualiza el gráfico de torta cuando se selecciona un producto
watch(selectedProduct, (newProduct) => {
  if (newProduct) {
    const productoSeleccionado = productosVendidos.value.find(p => p.nombre === newProduct);
    pieChartData.value = {
      labels: [productoSeleccionado.nombre],
      datasets: [
        {
          label: 'Cantidad Vendida',
          data: [productoSeleccionado.cantidad],
          backgroundColor: ['#FF6384'],
          borderColor: '#1E88E5',
          borderWidth: 1
        }
      ]
    };
  }
});


const pieChartData = ref({
  labels: productosVendidos.value.map(producto => producto.nombre),
  datasets: [
    {
      label: 'Productos más vendidos',
      data: productosVendidos.value.map(producto => producto.cantidad),
      backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40'], // Colores para los segmentos
      borderColor: '#1E88E5',
      borderWidth: 1
    }
  ]
});

const chartOptions = ref({
  responsive: true,
  plugins: {
    legend: {
      position: 'top',
    },
    tooltip: {
      callbacks: {
        label: function (tooltipItem) {
          return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
        }
      }
    }
  }
});

// Parámetros para las fechas
const startDate = ref('');
const endDate = ref('');


// Función para enviar el reporte parametrizado
const enviarCorreo = async () => {
  // Construir el cuerpo del mensaje con las ventas filtradas
  let mensajeTabla = '<table border="1"><tr><th>Mes-Año</th><th>Total</th></tr>';
  filteredSalesByMonth.value.forEach(venta => {
    mensajeTabla += `<tr><td>${venta.monthYear}</td><td>${venta.total}</td></tr>`;
  });
  mensajeTabla += '</table>';

  // Asegurarse de que los campos de destinatario y asunto estén completos
  if (!destinatario.value || !asunto.value) {
    message.value = 'Por favor complete los campos de destinatario y asunto.';
    return;
  }

  try {
    // Enviar el correo (o lo que sea el backend que maneja el reporte)
    await Inertia.post('/send-report', {
      destinatario: destinatario.value,
      asunto: asunto.value,
      mensaje: mensajeTabla
    }).then(response => {
      message.value = 'Reporte enviado exitosamente.';
      modalVisible.value = false;  // Cerrar el modal después de enviar
    }).catch(() => {
      message.value = 'Hubo un problema al enviar el reporte.';
    });
  } catch (error) {
    message.value = 'Error al enviar el reporte.';
  }
};
const enviarCorreoProducto = async () => {
  if (!selectedProduct.value) {
    message.value = 'Por favor seleccione un producto.';
    return;
  }

  // Encontrar el producto seleccionado
  const productoSeleccionado = productosVendidos.value.find(p => p.nombre === selectedProduct.value);

  if (!productoSeleccionado) {
    message.value = 'Producto no encontrado.';
    return;
  }

  // Construir la tabla con el producto seleccionado
  let mensajeTabla = `<h3>Reporte de Producto: ${productoSeleccionado.nombre}</h3>`;
  mensajeTabla += '<table border="1"><tr><th>Producto</th><th>Cantidad Vendida</th></tr>';
  mensajeTabla += `<tr><td>${productoSeleccionado.nombre}</td><td>${productoSeleccionado.cantidad}</td></tr>`;
  mensajeTabla += '</table>';

  // Asegurarse de que los campos de destinatario y asunto estén completos
  if (!destinatario.value || !asunto.value) {
    message.value = 'Por favor complete los campos de destinatario y asunto.';
    return;
  }

  try {
    // Enviar el correo (o lo que sea el backend que maneja el reporte)
    await Inertia.post('/send-report', {
      destinatario: destinatario.value,
      asunto: asunto.value,
      mensaje: mensajeTabla
    }).then(response => {
      message.value = 'Reporte enviado exitosamente.';
      modalVisible.value = false;  // Cerrar el modal después de enviar
    }).catch(() => {
      message.value = 'Hubo un problema al enviar el reporte.';
    });
  } catch (error) {
    message.value = 'Error al enviar el reporte.';
  }
};


// metodo para obtener data del parametro de fechas
const filteredSalesByMonth = ref([]);

// Función para filtrar las ventas basadas en las fechas seleccionadas

watch([startDate, endDate], () => {
  if (startDate.value && endDate.value) {
    const start = moment(startDate.value);
    const end = moment(endDate.value);

    // Filtrar las ventas que estén dentro del rango de fechas
    filteredSalesByMonth.value = ventapormes.value.filter((venta) => {
      const ventaDate = moment(venta.fecha);

      // Si la fecha no es válida, omitirla
      if (!ventaDate.isValid()) {
        console.error(`Invalid date format: ${venta.fecha}`);
        return false;
      }

      return ventaDate.isBetween(start, end, null, '[]'); // '[]' incluye ambos extremos
    });

    // Agrupar las ventas por mes y año
    const ventasAgrupadas = [];
    filteredSalesByMonth.value.forEach((venta) => {
      const mes = monthNames[venta.mes - 1];  // Obtener el nombre del mes
      const year = moment(venta.fecha).year();  // Obtener el año de la venta
      const key = `${mes} ${year}`;

      // Si ya existe una entrada para ese mes, se suma el total
      if (ventasAgrupadas[key]) {
        ventasAgrupadas[key] += venta.monto_total;
      } else {
        ventasAgrupadas[key] = venta.monto_total;
      }
    });

    // Convertir el objeto agrupado en un array para la tabla
    filteredSalesByMonth.value = Object.keys(ventasAgrupadas).map((key) => {
      return {
        monthYear: key,
        total: ventasAgrupadas[key]
      };
    });
  }
}, { immediate: true });

</script>

<template>
    <Head title="Graficos" />

    <AuthenticatedLayout>
      <template #header>
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
          Graficos
        </h2>
      </template>
      <div>
        <div class="py-12">

          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900 dark:text-gray-100">
                <div class="mt-4">
                  <label for="startDate">Fecha Inicial:</label>
                  <input
                    id="startDate"
                    type="date"
                    v-model="startDate"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                  />

                  <label for="endDate" class="ml-4">Fecha Final:</label>
                  <input
                    id="endDate"
                    type="date"
                    v-model="endDate"
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                  />
                </div>

                <div  v-if="hasPermission('enviar-reportes')" class="mt-4">
                    <button
                        @click="modalVisible = true; modalType = 'reporte1'"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        >
                        Enviar Reporte 1
                        </button>


                </div>
                <section id="contenido_principal">
                  <div class="grafico-container">
                    <Graficos :type="'bar'" :chartData="barChartData" :chartOptions="chartOptions" />
                  </div>
                  <div v-if="startDate && endDate" class="mt-4">
  <h3 class="text-lg font-semibold">Ventas por Meses</h3>
  <table class="min-w-full mt-2 border-collapse table-auto">
    <thead>
      <tr>
        <th style="text-align: center;">MONTH</th>
        <th style="text-align: center;">TOTAL</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(venta, index) in filteredSalesByMonth" :key="index">
        <td style="text-align: center;">{{ venta.monthYear }}</td>
        <td style="text-align: center;">{{ venta.total}}</td>
      </tr>
    </tbody>
  </table>
</div>

                </section>


  <!-- Selector de Producto para Gráfico de Torta -->
  <!-- Selector de Producto para Reporte 2 -->
<div class="mt-4">
  <label for="productoSelector">Seleccionar Producto:</label>
  <select v-model="selectedProduct" id="productoSelector">
    <option value="">-- Selecciona un producto --</option>
    <option v-for="(producto, index) in productosVendidos" :key="index" :value="producto.nombre">
      {{ producto.nombre }}
    </option>
  </select>
</div>

<!-- Botón para Enviar Reporte 2 -->
<div  v-if="hasPermission('enviar-reportes')" class="mt-4">
    <button
  @click="modalVisible = true; modalType = 'reporte2'"
  class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
>
  Enviar Reporte 2
</button>
</div>


              <section id="contenido_principal">
                <div class="grafico-container">
                  <Graficos :type="'pie'" :chartData="pieChartData" :chartOptions="chartOptions" />
                </div>
              </section>
                <!-- Modal para enviar el correo -->
              <!-- Modal -->
<div v-if="modalVisible" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
  <div class="bg-white p-6 rounded-md shadow-lg w-96">
    <h3 class="text-xl font-semibold mb-4">
      {{ modalType === 'reporte1' ? 'Enviar Reporte 1' : 'Enviar Reporte 2' }}
    </h3>

    <label for="destinatario" class="block">Destinatario:</label>
    <input
      id="destinatario"
      type="email"
      v-model="destinatario"
      class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mb-4"
      placeholder="Ingrese el destinatario"
    />

    <label for="asunto" class="block">Asunto:</label>
    <input
      id="asunto"
      type="text"
      v-model="asunto"
      class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mb-4"
      placeholder="Ingrese el asunto"
    />

    <!-- Mostrar mensaje específico según el tipo de reporte -->
    <div v-if="modalType === 'reporte1'">
      <p>Este es el reporte 1, basado en las ventas por mes.</p>
    </div>
    <div v-if="modalType === 'reporte2'">
      <p>Este es el reporte 2, basado en las ventas de productos seleccionados.</p>
    </div>

    <div class="flex justify-between">
      <button
        @click="modalType === 'reporte1' ? enviarCorreo() : enviarCorreoProducto()"
        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
      >
        Enviar
      </button>
      <button
        @click="modalVisible = false"
        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
      >
        Cancelar
      </button>
    </div>
  </div>
</div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>

<style scoped>
.grafico-container {
  width: 100%;
  max-width: 600px;
  height: auto;
  margin: 0 auto;
}
</style>
