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
  {
    path: '/',
    name: 'ProtectedLayout',
    component: () => import('../components/layouts/protected/ProtectedLayout.vue'),
    children: [
      {
        path: '/profile',
        name: 'Profile',
        component: () => import('../pages/protected/Profile.vue'),
      },
      {
        path: '/cart',
        name: 'Cart',
        component: () => import('../pages/protected/Cart.vue'),
      },
      {
        path: '/checkout',
        name: 'Checkout',
        component: () => import('../pages/protected/Checkout.vue'),
      },
      {
        path: '/orders',
        name: 'Orders',
        component: () => import('../pages/protected/Orders.vue'),
      },
      {
        path: '/orders/:id',
        name: 'Orders',
        component: () => import('../pages/protected/OrderDetail.vue'),
      },
    ],
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'NotFound',
    component: () => import('../pages/guest/NotFound.vue'),
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
//