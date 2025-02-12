<!-- resources/js/components/Footer.vue -->
<template>
    <footer class="site-footer">
      <div class="container">
        <div class="row">

            <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-lg font-semibold text-white">Visitas:{{ pageview.visits }}</span>
    </div>

        </div>
      </div>

      <div class="footer-bottom">
        <div class="container">
          <p>&copy; 2024 Pijamas Cloud. Todos los derechos reservados.</p>
        </div>
      </div>
    </footer>
  </template>

  <script setup>
  import { ref } from 'vue';
    import {usePage } from '@inertiajs/vue3';
const page = usePage();
const pageview = ref(page.props.pageview);
  </script>

  <style scoped>
  /* Estilos básicos para el footer */
  .site-footer {
    background-color: #333;
    color: white;
    padding: 40px 0;
    font-size: 0.9rem;
  }

  .site-footer h3 {
    color: #f39c12;
  }

  .site-footer p {
    margin-bottom: 15px;
  }

  .site-footer ul {
    list-style: none;
    padding: 0;
  }

  .site-footer ul li {
    margin-bottom: 10px;
  }

  .site-footer ul li a {
    color: white;
    text-decoration: none;
  }

  .site-footer ul li a:hover {
    text-decoration: underline;
  }

  .social-links {
    display: flex;
    gap: 10px;
  }

  .social-icon {
    color: white;
    font-size: 1.5rem;
    transition: color 0.3s ease;
  }

  .social-icon:hover {
    color: #f39c12;
  }

  .footer-bottom {
    background-color: #222;
    padding: 10px 0;
    text-align: center;
  }

  .footer-bottom p {
    margin: 0;
  }
  </style>
