// src/composables/useUser.js
import { computed } from 'vue';

export const useUser = () => {
  const roles = computed(() => window.Laravel?.user?.roles || []); // Obtener roles del usuario
  const permissions = computed(() => window.Laravel?.user?.can || {}); // Obtener permisos del usuario
  const userData = computed(() => window.Laravel?.user || {}); // Obtener datos del usuario

  // Método para verificar si el usuario tiene un rol específico
  const hasRole = (role) => {
    return roles.value.includes(role);
  };

  // Método para verificar si el usuario tiene un permiso específico
  const hasPermission = (permission) => {
    return permissions.value[permission] === true;
  };

  return {
    roles,
    permissions,
    userData,
    hasRole,
    hasPermission,
  };
};
