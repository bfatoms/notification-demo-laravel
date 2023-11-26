<template>
  <div>
    {{ data.title }}
    <h1 v-if="data.title">{{ data.title }}</h1>
    <div v-else>Loading...</div>
  </div>
</template>

  <script setup>
import { ref, onMounted } from "vue";
import api from "@/api";

const data = ref({});

onMounted(async () => {
  try {
    const response = await api.get("/status");
    data.value = response.data;
  } catch (error) {
    console.error("Error fetching data:", error);
  }
});
</script>
