<template>
  <div>
    <!-- Conditionally render the home or login page based on authentication -->
    <router-view></router-view>
  </div>
</template>

<script setup>
// import { computed } from "vue";
// import { useAuthStore } from "./stores/auth";

// const authStore = useAuthStore();

// const isAuthenticated = computed(() => !!authStore.token);
</script>
