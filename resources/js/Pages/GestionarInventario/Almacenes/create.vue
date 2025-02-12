<script setup>
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

// Inicialización del formulario con los campos necesarios para el almacén
const form = useForm({
  nombre: '',
  direccion: '',
    capacidad: '',
    descripcion: '',
});

// Función para manejar el envío del formulario
const submitForm = () => {
  form.post(route('admin.almacenes.store'), {
    onSuccess: () => {
      console.log('Almacén creado exitosamente');
    },
    onError: () => {
      console.log('Hubo un error al crear el almacén');
    },
  });
};
</script>

<template>
  <Head title="Crear Almacén" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Crear Almacén</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <!-- Formulario para crear almacén -->
            <form @submit.prevent="submitForm">
              <div class="space-y-4">
                <!-- Campo: Nombre -->
                <div>
                  <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                  <input
                    v-model="form.nombre"
                    type="text"
                    id="nombre"
                    name="nombre"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                  />
                  <p v-if="form.errors.nombre" class="text-sm text-red-500 mt-2">{{ form.errors.nombre }}</p>
                </div>

                <!-- Campo: Dirección -->
                <div>
                  <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                  <input
                    v-model="form.direccion"
                    type="text"
                    id="direccion"
                    name="direccion"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                  />
                  <p v-if="form.errors.direccion" class="text-sm text-red-500 mt-2">{{ form.errors.direccion }}</p>
                </div>

                <!-- Campo: Capacidad -->
                <div>
                  <label for="capacidad" class="block text-sm font-medium text-gray-700">Capacidad</label>
                  <input
                    v-model="form.capacidad"
                    type="number"
                    id="capacidad"
                    name="capacidad"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                  />
                  <p v-if="form.errors.capacidad" class="text-sm text-red-500 mt-2">{{ form.errors.capacidad }}</p>
                </div>
 <!-- Campo: descripcion -->
 <div>
                  <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripcion</label>
                  <input
                    v-model="form.descripcion"
                    type="text"
                    id="descripcion"
                    name="descripcion"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                  />
                  <p v-if="form.errors.descripcion" class="text-sm text-red-500 mt-2">{{ form.errors.descripcion }}</p>
                </div>
                <!-- Botón: Agregar -->
                <div class="mt-6 flex items-center justify-end">
                  <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">
                    Agregar
                  </button>
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
/* Agrega estilos personalizados si es necesario */
</style>
