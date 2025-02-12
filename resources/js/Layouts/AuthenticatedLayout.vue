<script setup>
import { computed, ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';


const roles = computed(() => window.Laravel?.roles || []);
const permissions = computed(() => window.Laravel?.permissions || []);
const userData = computed(() => window.Laravel?.user || {});

const hasRole = (role) => {
  return roles.value.includes(role);
};

const hasPermission = (permission) => {
  return permissions.value[permission] === true;
};

// Depuración
console.log('Roles:', roles.value);
console.log('Permisos:', permissions.value);
const showingNavigationDropdown = ref(false);


</script>

<template>
    <div>
        <div class="min-h-screen bg-white dark:bg-gray-800">
            <nav
                class="border-b bg-white dark:bg-gray-800"
            >
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <!-- Dropdown para Dashboard -->
    <div class="hidden sm:flex sm:items-center sm:ms-6">
    <Dropdown align="right" width="48">
      <template #trigger>
        <button
          :active="route().current('dashboard')"
          class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
        >
          <div>Dashboard</div>
          <div class="ms-1">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </div>
        </button>
      </template>
      <template #content>
        <NavLink :href="route('dashboard')" :active="route().current('dashboard')">Dashboard</NavLink>
      </template>
    </Dropdown>
</div>
    <!-- v-if="canViewModuloUsuarios===true" -->
    <div  v-if="hasPermission('ver-modulo-usuarios')" class="hidden sm:flex sm:items-center sm:ms-6">
    <Dropdown align="right" width="48">
      <template #trigger>
        <button
          :active="route().current('admin.users')"
          class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
        >
          <div>Módulo Usuarios</div>
          <div class="ms-1">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </div>
        </button>
      </template>
      <template #content>
        <NavLink  v-if="hasPermission('ver-usuarios')":href="route('admin.users')" :active="route().current('admin.users')">Usuarios</NavLink>
        <NavLink  v-if="hasPermission('ver-roles')" :href="route('admin.roles')" :active="route().current('admin.roles')">Roles</NavLink>
        <NavLink  v-if="hasPermission('ver-permisos')" :href="route('admin.permisos')" :active="route().current('admin.permisos')">Permisos</NavLink>
      </template>

    </Dropdown>
</div>

 <!-- Dropdown para Modulo Productos -->
 <div v-if="hasPermission('ver-modulo-inventario')" class="hidden sm:flex sm:items-center sm:ms-6">
    <Dropdown align="right" width="48">
      <template #trigger>
        <button
          :active="route().current('admin.productos')"
          class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
        >
          <div>Módulo inventario</div>
          <div class="ms-1">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </div>
        </button>
      </template>
      <template #content>
        <NavLink v-if="hasPermission('ver-productos')" :href="route('admin.productos')" :active="route().current('admin.productos')">Productos</NavLink>
        <NavLink v-if="hasPermission('ver-categorias')" :href="route('admin.categorias')" :active="route().current('admin.catgorias')">Categorias</NavLink>
        <NavLink v-if="hasPermission('ver-ofertas')" :href="route('admin.ofertas')" :active="route().current('admin.ofertas')">Ofertas</NavLink>
        <NavLink v-if="hasPermission('ver-notas-compras')" :href="route('admin.notascompras')" :active="route().current('admin.notascompras')">Notas Compras</NavLink>
        <NavLink v-if="hasPermission('ver-proveedores')" :href="route('admin.proveedores')" :active="route().current('admin.proveedores')">Proveedores</NavLink>
        <NavLink v-if="hasPermission('ver-almacenes')" :href="route('admin.almacenes')" :active="route().current('admin.almacenes')">Almacenes</NavLink>
        <NavLink v-if="hasPermission('ver-ajustes-inventarios')" :href="route('admin.ajustesinventarios')" :active="route().current('admin.ajustesinventarios')">Ajuste Inventario</NavLink>
      </template>
    </Dropdown>
</div>






<!-- Dropdown para Modulo Ventas -->
<div v-if="hasPermission('ver-modulo-ventas')" class="hidden sm:flex sm:items-center sm:ms-6">
    <Dropdown align="right" width="48">
      <template #trigger>
        <button
          :active="route().current('admin.ventas')"
          class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
        >
          <div>Módulo Ventas</div>
          <div class="ms-1">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </div>
        </button>
      </template>
      <template #content>
        <NavLink v-if="hasPermission('ver-ventas')" :href="route('admin.ventas')" :active="route().current('admin.ventas')">Ventas</NavLink>
        <NavLink v-if="hasPermission('ver-pagos')" :href="route('admin.pagos')" :active="route().current('admin.pagos')">Pagos</NavLink>


      </template>
    </Dropdown>
</div>



<!-- Dropdown para Modulo Reportes y Estadisticas -->
<div v-if="hasPermission('ver-modulo-reportes')" class="hidden sm:flex sm:items-center sm:ms-6">
    <Dropdown align="right" width="48">
      <template #trigger>
        <button
          :active="route().current('admin.reportes')"
          class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
        >
          <div>Módulo Reportes y estadisticas</div>
          <div class="ms-1">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </div>
        </button>
      </template>
      <template #content>
        <NavLink v-if="hasPermission('ver-reportes')" :href="route('admin.reportes')" :active="route().current('admin.reportes')">Reportes</NavLink>
        <NavLink v-if="hasPermission('ver-ratings')" :href="route('admin.ratings')" :active="route().current('admin.ratings')">Ratings</NavLink>
        <NavLink  v-if="hasPermission('ver-views')" :href="route('admin.views')" :active="route().current('admin.views')">Views</NavLink>

      </template>
    </Dropdown>
</div>






  </div>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <!-- Settings Dropdown -->
                            <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="-me-0.5 ms-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div
                        class="border-t border-gray-200 pb-1 pt-4"
                    >
                        <div class="px-4">
                            <div
                                class="text-base font-medium text-gray-800"
                            >
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header
                class="bg-white shadow"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
