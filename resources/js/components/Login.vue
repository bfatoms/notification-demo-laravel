<template>
  <div>
    <h2>Login</h2>
    <form @submit.prevent="login">
      <label for="email">Email:</label>
      <input v-model="email" type="email" id="email" required />

      <label for="password">Password:</label>
      <input v-model="password" type="password" id="password" required />

      <button type="submit">Login</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import api from "@/api";
import router from '@/router';
import { useAuthStore } from '@/stores/auth';

const authStore = useAuthStore();

const email = ref("marketing@application.test");
const password = ref("password");

const login = async () => {
  try {
    const response = await api.post("/auth/login", {
      email: email.value,
      password: password.value,
    });

    authStore.setToken(response.data.data.token);

    router.push('/home');

    // console.log("Login successful:", response.data);
    // Handle successful login, e.g., redirect or update user state
  } catch (error) {
    console.error("Login error:", error);
    // Handle login error, e.g., display error message
  }
};
</script>
