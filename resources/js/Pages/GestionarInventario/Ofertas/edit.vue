<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head,usePage  } from '@inertiajs/vue3';
import FileInput from '@/Components/FileInput.vue';

const page = usePage();
const producto = ref(page.props.producto);
const props = defineProps({
    categorias: Array,
});
const form = useForm({
  nombre: producto.value.nombre,
  stock: producto.value.stock,
  precio: producto.value.precio,
    categoria_id:producto.value.categoria_id,
    imagen: producto.value.imagen,
  descripcion: producto.value.descripcion,

});

const onSelectImagen = (e) => {
    const files = e.target.files;
    if (files.length) {
        form.imagen = files[0];  // Asegúrate de que form.imagen sea un archivo
    }
    console.log(form.imagen);  // Verifica que el archivo esté siendo asignado
};

const submitForm = () => {
    form.post(route('admin.productos.update', { producto: producto.value.id }), {
    data: form,  // Asegúrate de que todos los datos, incluyendo la imagen, se envíen correctamente
    onSuccess: () => {
        console.log('Producto actualizado exitosamente');
    },
    onError: () => {
        console.log('Hubo un error al actualizar el producto');
    },
});

};
</script>

<template>
  <Head title="Editar Producto" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Editar Producto</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <form @submit.prevent="submitForm">
              <div class="space-y-4">
                <div>
                  <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                  <input v-model="form.nombre" type="text" id="nombre" name="nombre" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />

                </div>

                <div>
                  <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                  <input v-model="form.stock" type="number" id="stock" name="stock" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>

                <div>
                  <label for="precio" class="block text-sm font-medium text-gray-700">Precio</label>
                  <input v-model="form.precio" type="number" id="precio" name="precio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>

                <div>
                  <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripcion</label>
                  <input v-model="form.descripcion" type="text" id="descripcion" name="descripcion" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required />
                </div>
                <div>
                    <img :style="{ height: '150px', width: '150px', objectFit: 'cover' }" :src=" producto.imagen" alt="Imagen del producto" />
                </div>
                  <div>
                    <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen</label>
                    <FileInput name="imagen" @change="onSelectImagen"/>
                </div>
              </div>
              <!-- Select de Rol -->
              <div>
  <label for="categoria_id" class="block text-sm font-medium text-gray-700">Categoria</label>
  <select v-model="form.categoria_id" id="categoria_id" name="categoria_id" class="mt-1 block w-full border-2 border-gray-400 text-gray-800 bg-white rounded-md shadow-sm" required>
    <option value="">Seleccionar Categoria</option>
    <option v-for="categoria in props.categorias" :key="categoria.id" :value="categoria.id">{{ categoria.nombre }}</option>
  </select>
</div>
              <div class="mt-6 flex items-center justify-end">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Editar Producto</button>
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
