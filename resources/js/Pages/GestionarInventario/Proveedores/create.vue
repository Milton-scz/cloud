<script setup>

import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const form = useForm({
  nit: '',
    razonsocial: '',
    celular: '',
  email: '',


});

const submitForm = () => {
  form.post(route('admin.proveedores.store'), {
    onSuccess: () => {
      // Redirigir o mostrar un mensaje de éxito
      console.log('creado exitosamente');
    },
    onError: () => {
      console.log('Hubo un error al crear');
    },
  });
};
</script>

<template>
  <Head title="Crear Proveedor" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Crear Proveedor</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <form @submit.prevent="submitForm">
              <div class="space-y-4">
                <div>
                  <label for="nit" class="block text-sm font-medium text-gray-700">NIT</label>
                  <input v-model="form.nit" type="text" id="nit" name="nit" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"  />
                  <p v-if="form.errors.nit" class="text-sm text-red-500 mt-2">{{ form.errors.nit }}</p>
                </div>

                <div>
                  <label for="razonsocial" class="block text-sm font-medium text-gray-700">Rzon Social</label>
                  <input v-model="form.razonsocial" type="text" id="razonsocial" name="razonsocial" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"  />
                  <p v-if="form.errors.razonsocial" class="text-sm text-red-500 mt-2">{{ form.errors.razonsocial }}</p>
                </div>

                <div>
                  <label for="celular" class="block text-sm font-medium text-gray-700">Celular</label>
                  <input v-model="form.celular" type="text" id="celular" name="celular" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"  />
                  <p v-if="form.errors.celular" class="text-sm text-red-500 mt-2">{{ form.errors.celular }}</p>
                </div>


                <div>
                  <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                  <input v-model="form.email" type="text" id="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"  />
                  <p v-if="form.errors.email" class="text-sm text-red-500 mt-2">{{ form.errors.email }}</p>
                </div>

              <div class="mt-6 flex items-center justify-end">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Agregar</button>
              </div>
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
