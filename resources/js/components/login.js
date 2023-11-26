import api from "@/api";
import router from '@/router';
import { email, password } from "./Login.vue";

export const login = async () => {
try {
const response = await api.post("/auth/login", {
email: email.value,
password: password.value,
});
console.log("token", response.data.data.token);
// authStore.setToken(response.data.token);
router.push('/home');

// console.log("Login successful:", response.data);
// Handle successful login, e.g., redirect or update user state
} catch (error) {
console.error("Login error:", error);
// Handle login error, e.g., display error message
}
};
