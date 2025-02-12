<script setup>
import { ref } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

// Formulario inicial
const form = useForm({
  proveedor_id: '',
  fecha: '',
  glosa: '',
  productos: [],
});

// Referencias y variables
const selectedProducts = ref([]);
const stock = ref(1);
const price = ref(0);
const selectedProductId = ref(null);

// Obtener los datos de proveedores y productos desde el backend
const { proveedores, productos } = usePage().props;

// Función para agregar o actualizar un producto en el detalle de compra
const addProductToTable = () => {
  if (selectedProductId.value && stock.value > 0 && price.value > 0) {
    // Encontrar el producto seleccionado por ID
    const selectedProduct = productos.find(product => product.id === selectedProductId.value);

    if (selectedProduct) {
      // Buscar si el producto ya existe en la lista
      const existingProductIndex = selectedProducts.value.findIndex(
        product => product.producto_id === selectedProduct.id
      );

      if (existingProductIndex !== -1) {
        // Si ya existe, actualizar la cantidad y el precio
        const existingProduct = selectedProducts.value[existingProductIndex];
        existingProduct.cantidad += stock.value;
        existingProduct.precio = price.value; // Sobrescribir el precio (puedes cambiar esta lógica si deseas promediarlo)
        form.productos[existingProductIndex].cantidad = existingProduct.cantidad;
        form.productos[existingProductIndex].precio = existingProduct.precio;
      } else {
        // Si no existe, agregar el producto a la tabla y al formulario
        const productData = {
          producto_id: selectedProduct.id,
          nombre: selectedProduct.nombre,
          cantidad: stock.value,
          precio: price.value,
        };

        selectedProducts.value.push(productData);
        form.productos.push(productData);
      }

      // Resetear valores
      stock.value = 1;
      price.value = 0;
    }
  } else {
    console.log("Datos inválidos. Verifica los campos antes de agregar el producto.");
  }
};

// Función para eliminar un producto de la tabla
const removeProductFromTable = (index) => {
  selectedProducts.value.splice(index, 1);
  form.productos.splice(index, 1);
};
</script>

<template>
  <Head title="Crear Nota de Compra" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Crear Nota de Compra</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <section id="contenido_principal">
              <div class="col-md-12" style="margin-top: 10px;">
                <div class="col-md-12 mb-4">
                  <h3 class="text-lg font-semibold">Datos de la Nota de Compra</h3>
                </div>
              </div>

              <div class="col-md-12">
                <form @submit.prevent="form.post(route('admin.notascompras.store'))">
                  <!-- Selección de Proveedor -->
                  <div class="mb-4">
                    <label for="proveedor_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Proveedor</label>
                    <select v-model="form.proveedor_id" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                      <option value="">Seleccione un proveedor</option>
                      <option v-for="proveedor in proveedores" :key="proveedor.id" :value="proveedor.id">
                        {{ proveedor.razonsocial }}
                      </option>
                    </select>
                  </div>

                  <!-- Selección de Producto -->
                  <div class="mb-4">
                    <label for="producto_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Producto</label>
                    <select v-model="selectedProductId" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                      <option value="">Seleccione un producto</option>
                      <option v-for="producto in productos" :key="producto.id" :value="producto.id">
                        {{ producto.nombre }}
                      </option>
                    </select>
                  </div>

                  <!-- Fecha -->
                  <div class="mb-4">
                    <label for="fecha" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha</label>
                    <input v-model="form.fecha" type="date" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required />
                  </div>

                  <!-- Stock -->
                  <div class="mb-4">
                    <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cantidad</label>
                    <input v-model="stock" type="number" min="1" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required />
                  </div>

                  <!-- Precio -->
                  <div class="mb-4">
                    <label for="precio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio</label>
                    <input v-model="price" type="number" min="0" step="0.01" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required />
                  </div>

                  <!-- Glosa -->
                  <div class="mb-4">
                    <label for="glosa" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Glosa</label>
                    <textarea v-model="form.glosa" rows="4" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></textarea>
                  </div>

                  <!-- Botón para agregar producto -->
                  <button type="button" @click="addProductToTable" class="w-full py-2 px-4 bg-green-600 text-white rounded-md shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">
                    Agregar Producto
                  </button>

                  <!-- Tabla de Productos -->
                  <div class="mt-6">
                    <h4 class="text-lg font-semibold">Productos Agregados</h4>
                    <table class="min-w-full table-auto mt-4">
                      <thead>
                        <tr>
                          <th style="text-align: center;">Producto</th>
                          <th style="text-align: center;">Cantidad</th>
                          <th style="text-align: center;">Precio</th>
                          <th style="text-align: center;">Acción</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(producto, index) in selectedProducts" :key="index">
                          <td style="text-align: center;">{{ producto.nombre }}</td>
                          <td style="text-align: center;">{{ producto.cantidad }}</td>
                          <td style="text-align: center;">{{ producto.precio }}</td>
                          <td style="text-align: center;">
                            <button @click="removeProductFromTable(index)" class="bg-red-500 text-white px-4 py-2 rounded-md">Eliminar</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <!-- Botón para guardar -->
                  <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" :disabled="form.processing">
                    Guardar Nota de Compra
                  </button>
                </form>
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
