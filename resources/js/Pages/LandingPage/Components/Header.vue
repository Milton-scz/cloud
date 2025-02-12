<template >
      <div :class="`${themeClass} ${isDarkMode ? 'dark' : 'light'} ${fontClass}`">
        <header :class="`${themeClass} ${isDarkMode ? 'dark' : 'light'} ${fontClass}`">
      <div  class="container ">
        <div  class="row">
          <div class="col-12 d-flex justify-content-between align-items-center">
            <!-- Contenedor de logo a la izquierda -->
            <div class="flex-left">
              Pijamas Cloud
            </div>

            <!-- Contenedor de buscador centrado -->
            <div class="flex-center">
              <form @submit.prevent="submitForm" class="flex-left w-full max-w-4xl">
                <div class="relative flex items-stretch w-full">
                  <input
                    type="search"
                    v-model="form.search"
                    placeholder="Buscar productos"
                    class="block p-4 w-full text-sm text-gray-900 bg-white rounded-lg border"
                  />
                  <button
                    type="submit"
                    class="ml-2 text-red bg-red-500 hover:bg-red-200 focus:outline-none"
                  >
                    Buscar
                  </button>
                </div>
              </form>
            </div>

            <!-- Contenedor del menú de navegación a la derecha -->
            <nav class="flex justify-end">
  <ul class="nav-list">
    <li>
      <Link :href="route('/')" method="get" as="button">Home</Link>
    </li>
    <li>
      <Link :href="route('landing.productos')" method="get" as="button">
        Productos
      </Link>
    </li>
    <li v-if="user">
      <Link :href="route('landing.mis.productos')" method="get" as="button">
        Mis Productos
      </Link>
    </li>
    <li v-if="!user">
      <Link :href="route('login')" method="get" as="button">Login</Link>

    </li>

    <li v-else>
      <!-- Logout usando href con confirmación -->
      <Link :href="route('logout')" method="post" as="button" @click.prevent="logout">Log Out</Link>

    </li>
    <li v-if="!user">
        <Link :href="route('register')" method="get" as="button">Register</Link>
      </li>
  </ul>
    <!-- Select para temas -->
      <!-- Selector de tema separado -->


    <!-- Selector de tema -->
  <!-- Selector de Tema -->
  <select
                id="theme-selector"
                v-model="selectedTheme"
                @change="applyTheme"
                class="block p-2 text-sm bg-white dark:bg-gray-800 dark:text-white rounded-lg border"
              >
                <option value="" disabled selected>Seleccionar tema</option>
                <option value="niño">Tema niño</option>
                <option value="adolescente">Tema adolescente</option>
                <option value="adulto">Tema adulto</option>
              </select>

</nav>

          </div>
        </div>
    </div>
    </header>
</div>
  </template>

  <script setup>

  import { Link, useForm } from '@inertiajs/vue3';
  import { ref } from 'vue';
  import {usePage } from '@inertiajs/vue3';
const page = usePage();
const user = ref(page.props.user);
const selectedTheme = ref(''); // Tema seleccionado
const isDarkMode = ref(false); // Estado del modo oscuro/claro
const themeClass = ref('default-theme'); // Clase aplicada al tema
const themeTextClass = ref(''); // Clase de color de texto
const fontClass = ref(''); // Clase para la fuente
  const form = useForm({
    search: '',
  });
  const logout = () => {
  if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
    window.location.href = route('/');  // Redirige a la ruta logout
  }
};
  const emit = defineEmits(['search']);
  const submitForm = () => {
    emit('search', form.search); // Emitir evento con el término de búsqueda
  };

  const applyTheme = () => {
  switch (selectedTheme.value) {
    case 'niño':
    themeClass.value = 'bg-niño-light dark:bg-niño-dark text-gray-800 dark:text-white font-niño';
    fontClass.value = 'font-niño'; // Aplicar fuente para el tema niño
      break;
    case 'adolescente':
    themeClass.value = 'bg-adolescente-light dark:bg-adolescente-dark text-white dark:text-white font-adolescente';
    fontClass.value = 'font-adolescente';
      break;
    case 'adulto':
    themeClass.value = 'bg-adulto-light dark:bg-adulto-dark text-gray-800 dark:text-white font-adulto';
    fontClass.value = 'font-adulto';
      break;
    default:
          themeClass.value = 'bg-default';
          fontClass.value = '';
  }
      localStorage.setItem('theme', themeClass.value);
      localStorage.setItem('font', fontClass.value);
  };

  const setThemeBasedOnTime = () => {
  const currentHour = new Date().getHours();
  isDarkMode.value = currentHour >= 19 || currentHour < 7;
  };


const savedTheme = localStorage.getItem('theme');
const savedFont = localStorage.getItem('font');
  if (savedTheme) {
    themeClass.value = savedTheme;
    selectedTheme.value = savedTheme;
  } else {
      localStorage.setItem('theme', 'bg-adulto-light dark:bg-adulto-dark text-gray-800 dark:text-white');
      themeClass.value = 'bg-adulto-light dark:bg-adulto-dark text-gray-800 dark:text-white';
      selectedTheme.value =  'adulto';
  }
  if (savedFont) {
  fontClass.value = savedFont;
}



// Llama a la función inmediatamente al cargar para aplicar el tema desde el principio
setThemeBasedOnTime();
  </script>

  <style scoped>

  /* Estilos básicos para el header */
  .site-navbar {
    position: fixed; /* Fijar el header en la parte superior */
    top: 0;
    left: 0;
    right: 0;
    background-color: #2e77d6;
    padding: 10px 0;
    color: white;
    z-index: 1000; /* Asegura que el header esté sobre otros elementos */
  }

  .site-logo {
    font-size: 1.8rem;
    color: white;
    text-decoration: none;
  }

  .nav-list {
    list-style: none;
    margin: 0;
    padding: 0;
    display: flex; /* Usar flex para alinear los items en una fila */
  }

  .nav-list li {
    margin: 0 20px;
  }

  .nav-list li a,


  .nav-list li a:hover,
  .nav-list li button:hover {
    text-decoration: underline;
  }

  body {
    padding-top: 70px; /* Ajusta este valor dependiendo de la altura de tu header */
  }

  /* Organiza el header */
  .d-flex {
    display: flex;
    justify-content: space-between; /* Distribuye el contenido entre los elementos */
    align-items: center;
    width: 100%;
  }

  /* Contenedor de logo alineado a la izquierda */
  .flex-left {
    display: flex;
    align-items: center;
  }

  /* Contenedor del buscador centrado */
  .flex-center {
    display: flex;
    justify-content: center; /* Centra el contenido */
    flex: 1; /* Hace que el contenedor ocupe el máximo espacio disponible */
    text-align: center; /* Asegura que el formulario se centre */
  }

  /* Contenedor del formulario de búsqueda con ancho máximo más grande */
  form.w-full {
    max-width: 700px; /* Aumento el tamaño máximo del formulario */
  }

  /* Contenedor del menú de navegación alineado a la derecha */
  .flex-right {
    display: flex;
    align-items: center;
    margin-left: auto; /* Alinea los elementos de navegación a la derecha */
  }

/* Definir las fuentes para cada tema */
.font-niño {
  font-family: 'Comic Sans MS', cursive;
  font-size: 1.5rem;
}

.font-adolescente {
  font-family: 'Dancing Script', cursive;
  font-size: 1.2rem;
}

.font-adulto {
  font-family: 'Roboto', sans-serif;
  font-size: 1.2rem;
}


  </style>
