import { inject } from "vue";
import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    path: "/",
    name: "GuestLayout",
    component: () => import("../components/layouts/guest/GuestLayout.vue"),
    children: [
      {
        path: "/",
        name: "Home",
        component: () => import('../pages/guest/Home.vue'),
      },
      {
        path: "/login",
        name: "Login",
        component: () => import('../pages/guest/auth/Login.vue'),
      },
      {
        path: "/register",
        name: "Register",
        component: () => import('../pages/guest/auth/Register.vue'),
      },
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
