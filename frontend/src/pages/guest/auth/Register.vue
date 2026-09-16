<script setup>
import { ref } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faUserPlus } from "@fortawesome/free-solid-svg-icons";

const form = ref({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  agree: false,
});

const handleRegister = () => {
  console.log("Register:", form.value);
};
</script>

<template>
  <div
    class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-10"
  >
    <div class="w-full max-w-sm">
      <!-- Register Card -->
      <div
        class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-6"
      >
        <!-- Header -->
        <div class="text-center mb-8">
          <div
            class="w-14 h-14 mx-auto mb-4 flex items-center justify-center rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-500 text-white shadow-md"
          >
            <FontAwesomeIcon :icon="faUserPlus" class="text-xl" />
          </div>

          <h1 class="text-2xl font-semibold text-gray-800">Register to continue</h1>
        </div>

        <!-- Register Form -->
        <form @submit.prevent="handleRegister" class="space-y-4">
          <!-- Name -->
          <div>
            <label
              for="name"
              class="block mb-2 text-sm font-medium text-gray-700"
            >
              User name
            </label>

            <input
              id="name"
              v-model="form.name"
              type="text"
              placeholder="user name"
              class="w-full h-10 px-3 rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-800 outline-none focus:border-blue-500 focus:bg-white transition"
            />
          </div>

          <!-- Email -->
          <div>
            <label
              for="email"
              class="block mb-2 text-sm font-medium text-gray-700"
            >
              Email
            </label>

            <input
              id="email"
              v-model="form.email"
              type="email"
              placeholder="mail@site.com"
              class="w-full h-11 px-3 rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-800 outline-none focus:border-blue-500 focus:bg-white transition"
            />
          </div>

          <!-- Password -->
          <div>
            <label
              for="password"
              class="block mb-2 text-sm font-medium text-gray-700"
            >
              Password
            </label>

            <input
              id="password"
              v-model="form.password"
              type="password"
              placeholder="Password"
              class="w-full h-11 px-3 rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-800 outline-none focus:border-blue-500 focus:bg-white transition"
            />
          </div>

          <!-- Confirm Password -->
          <div>
            <label
              for="password_confirmation"
              class="block mb-2 text-sm font-medium text-gray-700"
            >
              Confirm Password
            </label>

            <input
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              placeholder="Confirm password"
              class="w-full h-11 px-3 rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-800 outline-none focus:border-blue-500 focus:bg-white transition"
            />
          </div>

          <!-- Register Button -->
          <button
            type="submit"
            class="w-full h-11 flex items-center justify-center gap-2 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 active:bg-blue-800 transition"
          >
            <FontAwesomeIcon :icon="faUserPlus" />

            Register
          </button>
        </form>

        <!-- Login -->
        <div class="mt-6 pt-6 border-t border-gray-600 text-center">
          <p class="text-sm text-gray-500">
            You already have an account?
            <RouterLink
              to="/login"
              class="font-medium text-blue-600 hover:text-blue-700 hover:underline"
            >
              Login
            </RouterLink>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
