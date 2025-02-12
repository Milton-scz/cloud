<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  productos: Array,
});

const form = useForm({
  producto_id: '',
  porcentaje: 0, // Nuevo campo para el porcentaje
});

const submitForm = () => {
  axios.post(route('admin.ofertas.update', { producto_id: form.producto_id }), {
    porcentaje: form.porcentaje, // Incluir el porcentaje en la solicitud
    onSuccess: () => {
      Inertia.visit(route('admin.ofertas'));
      console.log('Actualizado exitosamente');
    },
    onError: () => {
      console.log('Hubo un error al actualizar');
    },
  });
};
</script>

<template>
  <Head title="Crear Oferta" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Crear Oferta</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <form @submit.prevent="submitForm">
              <div>
                <label for="producto_id" class="block text-sm font-medium text-gray-700">Producto</label>
                <select v-model="form.producto_id" id="producto_id" name="producto_id" class="mt-1 block w-full border-2 border-gray-400 text-gray-800 bg-white rounded-md shadow-sm">
                  <option value="">Seleccionar Producto</option>
                  <option v-for="producto in props.productos" :key="producto.id" :value="producto.id">{{ producto.nombre }}</option>
                </select>
                <p v-if="form.errors.producto_id" class="text-sm text-red-500 mt-2">{{ form.errors.producto_id }}</p>
              </div>

              <div class="mt-4">
                <label for="porcentaje" class="block text-sm font-medium text-gray-700">Porcentaje de Descuento</label>
                <input
                  type="number"
                  v-model="form.porcentaje"
                  id="porcentaje"
                  name="porcentaje"
                  min="0"
                  max="100"
                  class="mt-1 block w-full border-2 border-gray-400 text-gray-800 bg-white rounded-md shadow-sm"
                />
                <p v-if="form.errors.porcentaje" class="text-sm text-red-500 mt-2">{{ form.errors.porcentaje }}</p>
              </div>

              <div class="mt-6 flex items-center justify-end">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Crear Oferta</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
/* Puedes agregar algunos estilos adicionales si lo deseas */
</style>
