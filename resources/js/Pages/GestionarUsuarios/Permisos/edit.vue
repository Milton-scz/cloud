<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

const page = usePage();
const permission = ref(page.props.permission); // Se obtiene el permiso a editar
const form = useForm({
  name: permission.value.name, // El nombre del permiso
  guard_name: permission.value.guard_name, // El guard_name del permiso
});

// Enviar el formulario con la información actualizada del permiso
const submitForm = () => {
  form.post(route('admin.permisos.update', { permission: permission.value.id }), {
    data: form, // Asegúrate de que los datos se envíen correctamente
    onSuccess: () => {
      console.log('Permiso actualizado exitosamente');
    },
    onError: () => {
      console.log('Hubo un error al actualizar el permiso');
    },
  });
};
</script>

<template>
  <Head title="Editar Permiso" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Editar Permiso</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <form @submit.prevent="submitForm">
              <div class="space-y-4">
                <div>
                  <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Permiso</label>
                  <input v-model="form.name" type="text" id="name" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>

                <div>
                  <label for="guard_name" class="block text-sm font-medium text-gray-700">Guard Name</label>
                  <input v-model="form.guard_name" type="text" id="guard_name" name="guard_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>
              </div>

              <div class="mt-6 flex items-center justify-end">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Editar Permiso</button>
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
