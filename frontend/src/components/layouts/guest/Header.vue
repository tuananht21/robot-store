<script setup>
import { ref } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import Logo from "../../common/Logo.vue";
import {
  faCartShopping,
  faUser,
  faBars,
  faXmark,
  faChevronDown,
} from "@fortawesome/free-solid-svg-icons";

const isMenuOpen = ref(false);
</script>

<template>
  <header
    class="sticky top-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-200"
  >
    <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Main Header -->
      <div class="h-16 flex items-center justify-between gap-3">
        <!-- Logo -->
        <RouterLink to="/" class="flex items-center gap-3 shrink-0 group">
          <Logo />
          <div class="hidden sm:block">
            <h1
              class="text-xl font-bold text-blue-600 leading-tight transition-colors"
            >
              Robot-Store
            </h1>
            <span class="text-xs text-gray-500 leading-none block"
              >Smart Robot Shop</span
            >
          </div>
        </RouterLink>

        <!-- Desktop Navigation -->
        <nav class="hidden lg:flex items-center gap-1 mr-auto ml-8">
          <RouterLink
            to="/"
            class="px-4 py-2 text-base font-medium text-gray-700 hover:text-blue-400 hover:bg-gray-50 transition"
          >
            Home
          </RouterLink>
          <RouterLink
            to="/products"
            class="px-4 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 transition"
            active-class="text-blue-600 bg-blue-50/80 font-semibold"
          >
            Products
          </RouterLink>
          <!-- Categories -->
          <div class="relative group">
            <RouterLink
              to="/categories"
              class="px-4 py-2 text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 transition flex items-center gap-1.5"
              active-class="text-blue-600 bg-blue-50/80 font-semibold"
            >
              Categories
              <FontAwesomeIcon
                :icon="faChevronDown"
                class="text-xs transition-transform duration-200 group-hover:rotate-180"
              />
            </RouterLink>
            <!-- Dropdown -->
            <div
              class="absolute left-0 top-full pt-2 invisible opacity-0 translate-y-2 group-hover:visible group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-200 z-50"
            >
              <div
                class="w-48 bg-white shadow-xl border border-gray-100 p-2"
              >
                <RouterLink
                  to="/categories/home-robot"
                  class="block px-3 py-2  text-base text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition"
                >
                  Home Robots
                </RouterLink>
                <RouterLink
                  to="/categories/industrial"
                  class="block px-3 py-2  text-base text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition"
                >
                  Industrial Robots
                </RouterLink>
                <RouterLink
                  to="/categories/educational"
                  class="block px-3 py-2  text-base text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition"
                >
                  Educational Robots
                </RouterLink>
              </div>
            </div>
          </div>
          <RouterLink
            to="/about"
            class="px-4 py-2  text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 transition"
            active-class="text-blue-600 bg-blue-50/80 font-semibold"
          >
            About
          </RouterLink>
          <RouterLink
            to="/contact"
            class="px-4 py-2  text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-gray-50 transition"
            active-class="text-blue-600 bg-blue-50/80 font-semibold"
          >
            Contact
          </RouterLink>
        </nav>

        <!-- Right Actions -->
        <div class="flex items-center gap-2">
          <!-- Cart -->
          <RouterLink
            to="/cart"
            class="relative w-10 h-10  flex items-center justify-center text-gray-600 hover:text-blue-600 hover:bg-gray-50 transition"
            title="Cart"
          >
            <FontAwesomeIcon :icon="faCartShopping" class="text-lg" />
          </RouterLink>

          <!-- Login -->
          <RouterLink
            to="/login"
            class="inline-flex items-center justify-center h-10 px-5 border border-blue-600 text-blue-600 text-base font-medium hover:bg-gray-50 active:scale-95 transition-all"
          >
            Login
          </RouterLink>

          <!-- Register -->
          <RouterLink
            to="/register"
            class="hidden sm:inline-flex items-center justify-center h-10 px-5 bg-blue-600 text-white text-base font-medium leading-none hover:bg-blue-700 active:scale-95 transition-all shadow-xs shrink-0"
          >
            Register
          </RouterLink>

          <!-- Mobile Menu Toggle -->
          <button
            type="button"
            class="lg:hidden w-10 h-10  flex items-center justify-center text-gray-600 hover:bg-gray-100 transition"
            @click="isMenuOpen = !isMenuOpen"
            :aria-expanded="isMenuOpen"
            aria-label="Toggle navigation"
          >
            <FontAwesomeIcon
              :icon="isMenuOpen ? faXmark : faBars"
              class="text-lg"
            />
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div
      v-if="isMenuOpen"
      class="lg:hidden border-t border-gray-200 bg-white shadow-lg"
    >
      <nav class="max-w-7xl mx-auto px-4 py-4 space-y-1">
        <RouterLink
          to="/"
          class="block px-4 py-3  text-gray-700 hover:bg-gray-50 hover:text-blue-600 font-medium transition"
          active-class="text-blue-600 bg-blue-50 font-semibold"
          @click="isMenuOpen = false"
        >
          Home
        </RouterLink>
        <RouterLink
          to="/products"
          class="block px-4 py-3  text-gray-700 hover:bg-gray-50 hover:text-blue-600 font-medium transition"
          active-class="text-blue-600 bg-blue-50 font-semibold"
          @click="isMenuOpen = false"
        >
          Products
        </RouterLink>
        <RouterLink
          to="/categories"
          class="block px-4 py-3  text-gray-700 hover:bg-gray-50 hover:text-blue-600 font-medium transition"
          active-class="text-blue-600 bg-blue-50 font-semibold"
          @click="isMenuOpen = false"
        >
          Categories
        </RouterLink>
        <RouterLink
          to="/about"
          class="block px-4 py-3  text-gray-700 hover:bg-gray-50 hover:text-blue-600 font-medium transition"
          active-class="text-blue-600 bg-blue-50 font-semibold"
          @click="isMenuOpen = false"
        >
          About
        </RouterLink>
        <RouterLink
          to="/contact"
          class="block px-4 py-3  text-gray-700 hover:bg-gray-50 hover:text-blue-600 font-medium transition"
          active-class="text-blue-600 bg-blue-50 font-semibold"
          @click="isMenuOpen = false"
        >
          Contact
        </RouterLink>

        <!-- Auth Actions in Mobile Menu -->
        <div class="pt-3 mt-3 border-t border-gray-100 flex flex-col gap-2">
          <RouterLink
            to="/login"
            class="flex items-center justify-center gap-2 px-4 py-2.5  text-gray-700 hover:bg-gray-100 font-medium border border-gray-200 transition text-base leading-none"
            @click="isMenuOpen = false"
          >
            Login
          </RouterLink>
          <RouterLink
            to="/register"
            class="flex items-center justify-center px-4 py-2.5  bg-blue-600 text-white font-medium leading-none hover:bg-blue-700 transition text-base shadow-xs"
            @click="isMenuOpen = false"
          >
            Register
          </RouterLink>
        </div>
      </nav>
    </div>
  </header>
</template>