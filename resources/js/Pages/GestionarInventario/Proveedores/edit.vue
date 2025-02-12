<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

const page = usePage();
const proveedor = ref(page.props.proveedor); // Se obtiene el permiso a editar
const form = useForm({
  nit: proveedor.value.nit,
    razonsocial: proveedor.value.razonsocial,
    celular: proveedor.value.celular,
    email: proveedor.value.email,
});

// Enviar el formulario con la información actualizada del permiso
const submitForm = () => {
  form.post(route('admin.proveedores.update', { proveedor: proveedor.value.id }), {
    data: form, // Asegúrate de que los datos se envíen correctamente
    onSuccess: () => {
      console.log('Permiso actualizado exitosamente');
    },
    onError: (errors) => {
        console.error('Error al crear:', errors); // Muestra todos los errores en consola
      console.log('Hubo un error al actualizar el permiso');
    },
  });
};
</script>

<template>
  <Head title="Editar proveedor" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Editar proveedor</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <form @submit.prevent="submitForm">
              <div class="space-y-4">
                <div>
                  <label for="nit" class="block text-sm font-medium text-gray-700">NIT</label>
                  <input v-model="form.nit" type="text" id="nit" name="nit" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>

                <div>
                  <label for="razonsocial" class="block text-sm font-medium text-gray-700">Razon social</label>
                  <input v-model="form.razonsocial" type="text" id="razonsocial" name="razonsocial" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>
                <div>
                  <label for="celular" class="block text-sm font-medium text-gray-700">Celular</label>
                  <input v-model="form.celular" type="text" id="celular" name="celular" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>
                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                  <input v-model="form.email" type="email" id="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>
              </div>

              <div class="mt-6 flex items-center justify-end">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Editar Proveedor</button>
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
