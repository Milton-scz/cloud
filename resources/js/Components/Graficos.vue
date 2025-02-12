<template>
    <div>
      <!-- Gráfico de barras -->
      <div v-if="type === 'bar'">
        <BarChart :data="chartData" :options="chartOptions" />
      </div>
      <!-- Gráfico de torta -->
      <div v-if="type === 'pie'">
        <PieChart :data="chartData" :options="chartOptions" />
      </div>
    </div>
  </template>

  <script setup>
  import { defineProps } from 'vue';
  import { Bar, Pie } from 'vue-chartjs';
  import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement } from 'chart.js';

  // Registrar los componentes de Chart.js
  ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement);

  // Definir las propiedades que el componente recibirá
  const props = defineProps({
    type: {
      type: String,
      required: true
    },
    chartData: {
      type: Object,
      required: true
    },
    chartOptions: {
      type: Object,
      required: true
    }
  });

  // Asignar los gráficos
  const BarChart = Bar;
  const PieChart = Pie;
  </script>
