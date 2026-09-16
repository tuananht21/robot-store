<script setup>
import { ref } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faRightToBracket } from "@fortawesome/free-solid-svg-icons";

const form = ref({
  email: "",
  password: "",
  remember: false,
});

const handleLogin = () => {
  console.log("Login:", form.value);
};
</script>

<template>
  <div
    class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-10"
  >
    <div class="w-full max-w-sm">
      <div
        class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 sm:p-6"
      >
        <!-- Header -->
        <div class="text-center mb-6">
          <div
            class="w-12 h-12 mx-auto mb-3 flex items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-cyan-500 text-white shadow-md"
          >
            <FontAwesomeIcon :icon="faRightToBracket" class="text-lg" />
          </div>

          <h1 class="text-2xl font-bold text-gray-800">Welcome Back</h1>

          <p class="mt-1 text-sm text-gray-500">Login to continue</p>
        </div>

        <!-- Form -->
        <form @submit.prevent="handleLogin" class="space-y-4">
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
              class="w-full h-10 px-3 rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-800 outline-none focus:border-blue-500 focus:bg-white transition"
            />
          </div>

          <!-- Password -->
          <div>
            <div class="flex items-center justify-between mb-2">
              <label for="password" class="text-sm font-medium text-gray-700">
                Password
              </label>

              <RouterLink
                to="/forgot-password"
                class="text-xs text-blue-600 hover:text-blue-700 hover:underline"
              >
                Forgot password?
              </RouterLink>
            </div>

            <input
              id="password"
              v-model="form.password"
              type="password"
              placeholder="Password"
              class="w-full h-10 px-3 rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-800 outline-none focus:border-blue-500 focus:bg-white transition"
            />
          </div>

          <!-- Remember -->
          <div class="flex items-center gap-2">
            <input
              id="remember"
              v-model="form.remember"
              type="checkbox"
              class="w-4 h-4 accent-blue-600"
            />

            <label for="remember" class="text-sm text-gray-600">
              Remember me
            </label>
          </div>

          <!-- Button -->
          <button
            type="submit"
            class="w-full h-10 flex items-center justify-center gap-2 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 active:bg-blue-800 transition"
          >
            <FontAwesomeIcon :icon="faRightToBracket" />

            Login
          </button>
        </form>

        <!-- Register -->
        <div class="mt-5 pt-5 border-t border-gray-100 text-center">
          <p class="text-sm text-gray-500">
            Don't have an account?

            <RouterLink
              to="/register"
              class="font-medium text-blue-600 hover:text-blue-700 hover:underline"
            >
              Register
            </RouterLink>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>
