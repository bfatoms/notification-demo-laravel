import { createRouter, createWebHistory } from 'vue-router';
import Home from '@/components/Home.vue';
import Login from '@/components/Login.vue';
import Register from '@/components/Register.vue';
import { useAuthStore } from '@/stores/auth';

// const authStore = useAuthStore();

const routes = [
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/', redirect: '/home' },
  { path: '/home', component: Home, meta: { requiresAuth: true } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

// router.beforeEach((to, from, next) => {
//   const isAuthenticated = !!authStore.token;

//   if (to.matched.some((record) => record.meta.requiresAuth) && !isAuthenticated) {
//     next('/login');
//   } else {
//     next();
//   }
// });

export default router;
