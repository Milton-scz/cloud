<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

// Obtener datos desde la página actual
const page = usePage();
const pagos = ref(page.props.pagos);
const roles = computed(() => window.Laravel?.roles || []);
const permissions = computed(() => window.Laravel?.permissions || []);
const userData = computed(() => window.Laravel?.user || {});

const hasRole = (role) => {
  return roles.value.includes(role);
};

const hasPermission = (permission) => {
  return permissions.value[permission] === true;
};
// Manejar éxito de eliminación
const onDeleteSuccess = (e) => {
    console.log(e);
    pagos.value = e.props.pagos;
};
</script>

<template>
    <Head title="Pagos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Pagos
            </h2>
        </template>

        <div>
            <!-- Tabla de ventas -->
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            <section id="contenido_principal">



                                <!-- Tabla -->
                                <div class="col-md-12">
                                    <div class="box box-default border border-gray-500">
                                        <div class="overflow-auto p-4">
                                            <table class="table table-bordered table-condensed table-striped w-full">
                                                <!-- Encabezados -->
                                                <thead>
                                                    <tr class="bg-gray-100">
                                                        <th style="text-align: center;">Nro</th>
                                                        <th style="text-align: center;">Fecha Pago</th>
                                                        <th style="text-align: center;">Estado</th>
                                                        <th style="text-align: center;">Método de Pago</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="pago in pagos" :key="pago.id">
                                                        <td style="text-align: center;">{{ pago.id }}</td>
                                                        <td style="text-align: center;">{{ pago.fechapago}}</td>
                                                        <td style="text-align: center;" :style="{ color: pago.estado === 2 ? 'green' : 'red' }">
                                                            {{ pago.estado === 2 ? 'Pagado' : 'No cancelado' }}
                                                        </td>
                                                        <td style="text-align: center;">
                                                            {{ pago.metodopago == "4" ? 'Pago QR' : 'Pago Tigo Money' }}
                                                        </td>

                                                        <td style="text-align: center;">


                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
