<!-- Register.vue -->

<template>
  <div>
    <h2>Register</h2>
    <form @submit.prevent="register">
      <label for="name">Name:</label>
      <input v-model="name" type="text" id="name" required />

      <label for="email">Email:</label>
      <input v-model="email" type="email" id="email" required />

      <label for="password">Password:</label>
      <input v-model="password" type="password" id="password" required />

      <button type="submit">Register</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from "vue";
import api from "@/api";

const name = ref("");
const email = ref("");
const password = ref("");

const register = async () => {
  try {
    const response = await api.post("/register", {
      name: name.value,
      email: email.value,
      password: password.value,
    });
    console.log("Registration successful:", response.data);
    // Handle successful registration, e.g., redirect or update user state
  } catch (error) {
    console.error("Registration error:", error);
    // Handle registration error, e.g., display error message
  }
};
</script>
