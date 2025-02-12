<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

const page = usePage();
const categoria = ref(page.props.categoria); // Se obtiene el permiso a editar
const form = useForm({
  nombre: categoria.value.nombre,
    descripcion: categoria.value.descripcion,

});

// Enviar el formulario con la información actualizada del permiso
const submitForm = () => {
  form.post(route('admin.categorias.update', { categoria: categoria.value.id }), {
    data: form, // Asegúrate de que los datos se envíen correctamente
    onSuccess: () => {
      console.log('actualizado exitosamente');
    },
    onError: (errors) => {
        console.error('Error al crear:', errors); // Muestra todos los errores en consola
      console.log('Hubo un error al actualizar el permiso');
    },
  });
};
</script>

<template>
  <Head title="Editar categoria" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Editar categoria</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <form @submit.prevent="submitForm">
              <div class="space-y-4">
                <div>
                  <label for="nombre" class="block text-sm font-medium text-gray-700">nombre</label>
                  <input v-model="form.nombre" type="text" id="nombre" name="nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>

                <div>
                  <label for="descripcion" class="block text-sm font-medium text-gray-700">descripcion</label>
                  <input v-model="form.descripcion" type="text" id="descripcion" name="descripcion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>

              </div>

              <div class="mt-6 flex items-center justify-end">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Editar Categoria</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
/* Estilos adicionales si los necesitas */
</style>
