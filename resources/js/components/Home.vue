<!-- Home.vue -->

<template>
    <div>
      <h2>Welcome to the Home Page!</h2>
      <p>This content is only visible to authenticated users.</p>
      <button @click="logout">Logout</button>
    </div>
  </template>

  <script setup>
  import { useAuthStore } from '@/stores/auth';
  import router from '@/router';

  const authStore = useAuthStore();

  console.log(authStore.getToken());

  const logout = () => {
    // Call the logout method from the Pinia store
    authStore.logout();

    // Redirect to the login page after logout
    router.push('/login');
  };
  </script>
