<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import Graficos from '@/Components/Graficos.vue';

const page = usePage();
const views = ref(page.props.views);  // Asegúrate de que "views" contiene el array correcto

// Extraemos los nombres de las páginas y las visitas
const pagesNames = views.value.map(view => view.page_name);
const visitsPage = views.value.map(view => view.visits);

console.log("Views: " + pagesNames.join(', '));  // Mostramos los nombres de las páginas en la consola

const barChartData = ref({
  labels: pagesNames,
  datasets: [
    {
      label: 'Visitas por Páginas',
      data: visitsPage,
      backgroundColor: '#42A5F5',
      borderColor: '#1E88E5',
      borderWidth: 1
    }
  ]
});

const roles = computed(() => window.Laravel?.roles || []);
const permissions = computed(() => window.Laravel?.permissions || []);
const userData = computed(() => window.Laravel?.user || {});

const hasRole = (role) => {
  return roles.value.includes(role);
};

const hasPermission = (permission) => {
  return permissions.value[permission] === true;
};

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
              <section id="contenido_principal">
                <div class="grafico-container">
                  <Graficos :type="'bar'" :chartData="barChartData" :chartOptions="chartOptions" />
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style scoped>
/* Estilo para los gráficos */
.grafico-container {
  width: 600px;  /* Limitar el tamaño máximo del gráfico */
  height: 650px;     /* Limitar la altura del gráfico */
  margin: 0 auto;    /* Centrar el gráfico */
}
</style>
