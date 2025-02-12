<!-- resources/js/components/HeroSection.vue -->
<template>
    <section class="hero-section">
      <div class="container text-center">
        <h1 class="display-4">Bienvenido a Nuestro Sitio</h1>
        <p class="lead">Ofrecemos soluciones tecnológicas innovadoras para ti</p>
        <a href="#services" class="btn btn-primary">Ver Servicios</a>
      </div>
    </section>
  </template>

  <script setup>
  // Lógica opcional aquí
  </script>

  <style scoped>
  .hero-section {
    background: url('/images/hero-bg.jpg') no-repeat center center/cover;
    padding: 100px 0;
    color: white;
  }

  .hero-section .display-4 {
    font-size: 3rem;
    font-weight: bold;
  }

  .hero-section .lead {
    font-size: 1.2rem;
    margin-bottom: 30px;
  }

  .hero-section .btn {
    font-size: 1rem;
    padding: 10px 30px;
  }
  </style>
