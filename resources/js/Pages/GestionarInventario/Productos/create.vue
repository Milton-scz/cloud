<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import FileInput from '@/Components/FileInput.vue';
const props = defineProps({
  categorias: Array, // Define que se recibe un array de roles
});
const form = useForm({
  nombre: '',
  stock: 0,
  precio: '',
    categoria_id: '',
    imagen: null,
  descripcion: '',

});

const onSelectImagen = (e) => {
    const files = e.target.files;
    if (files.length) {
        form.imagen=files[0]
    }
    console.log(form.imagen);
}
const submitForm = () => {
  form.post(route('admin.productos.store'), {
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
  <Head title="Crear Producto" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Crear Producto</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <form @submit.prevent="submitForm">
              <div class="space-y-4">
                <div>
                  <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                  <input v-model="form.nombre" type="text" id="nombre" name="nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"  />
                  <p v-if="form.errors.nombre" class="text-sm text-red-500 mt-2">{{ form.errors.nombre }}</p>  </div>



                <div>
                  <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                  <input v-model="form.precio" type="number" id="precio" name="precio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"  />
                  <p v-if="form.errors.precio" class="text-sm text-red-500 mt-2">{{ form.errors.precio }}</p>
                </div>

                <div>
                  <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripcion</label>
                  <input v-model="form.descripcion" type="text" id="descripcion" name="descripcion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" />
                  <p v-if="form.errors.descripcion" class="text-sm text-red-500 mt-2">{{ form.errors.descripcion }}</p>
                </div>

                <div>
                    <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen</label>
                    <FileInput name="imagen" @change="onSelectImagen"/>
                    <p v-if="form.errors.imagen" class="text-sm text-red-500 mt-2">{{ form.errors.imagen }}</p>
                </div>
              </div>
              <!-- Select de Rol -->
              <div>
  <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoria</label>
  <select v-model="form.categoria_id" id="categoria_id" name="categoria_id" class="mt-1 block w-full border-2 border-gray-400 text-gray-800 bg-white rounded-md shadow-sm" >
    <option value="">Seleccionar Categoria</option>
    <option v-for="categoria in props.categorias" :key="categoria.id" :value="categoria.id">{{ categoria.nombre }}</option>
  </select>
  <p v-if="form.errors.categoria_id" class="text-sm text-red-500 mt-2">{{ form.errors.categoria_id }}</p>
</div>
              <div class="mt-6 flex items-center justify-end">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Crear Producto</button>
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
