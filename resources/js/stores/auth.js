import { defineStore } from 'pinia';
import { ref } from "vue";

export const useAuthStore = defineStore('auth', () => {
    let token = ref(null);
    const setToken = (token) => {
        console.log('new token', token);
        token = token;
    }

    const logout = () => {
        token = null;
    }

    const getToken = () => {
        return token;
    }

    return { setToken, logout, getToken };
});
