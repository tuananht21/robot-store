<script setup>
import { ref } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { faUserPlus } from "@fortawesome/free-solid-svg-icons";
import { registerValidation } from "../../../validations/authValidation";
import { registerAPI } from "../../../apis/clients/auth";
import { useToast } from "../../../hooks/useToast";

const name = ref("");
const email = ref("");
const password = ref("");
const confPassword = ref("");
const nameMessage = ref("");
const emailMessage = ref("");
const passwordMessage = ref("");
const confPasswordMessage = ref("");
const isLoading = ref(false);

const { showToast } = useToast();

const handleRegister = async () => {  
  nameMessage.value = "";
  emailMessage.value = "";
  passwordMessage.value = "";
  confPasswordMessage.value = "";
  isLoading.value = true;
  try {
    const validation = registerValidation(name.value, email.value, password.value, confPassword.value);
    if (!validation.status) {
      nameMessage.value = validation.nameMessage;
      emailMessage.value = validation.emailMessage;
      passwordMessage.value = validation.passwordMessage;
      confPasswordMessage.value = validation.confPasswordMessage;
      return;
    }

    const res = await registerAPI(name.value, email.value, password.value);
    if (res.status === 201) {
      showToast({
        type: 'success',
        title: 'Thành công',
        message: 'Đăng ký thành công! Vui lòng đăng nhập.',
      });
      window.location.href = '/login';
      return;
    } else {
      showToast({
        type: 'error',
        title: 'Lỗi',
        message: 'Đăng ký thất bại. Vui lòng thử lại sau.',
      });
    }
  } catch (error) {
    console.error(error);
    showToast({
      type: 'error',
      title: 'Lỗi',
      message: error?.message || 'Đăng ký thất bại. Vui lòng thử lại sau.',
    })
  } finally {
    isLoading.value = false;
  }
};
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-10">
    <div class="w-full max-w-sm">
      <div class="bg-white rounded-2xl border border-gray-100 p-5 sm:p-6">
        <!-- Header -->
        <div class="text-center mb-8">
          <div class="w-12 h-12 mx-auto mb-3 flex items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-cyan-500 text-white shadow-md">
            <FontAwesomeIcon :icon="faUserPlus" class="text-lg" />
          </div>
          <h1 class="text-2xl font-semibold text-gray-800">Create Account</h1>
        </div>
        <form @submit.prevent="handleRegister" class="space-y-4">
          <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-700">User name</label>
            <input id="name" v-model="name" type="text" placeholder="user name"
              class="w-full h-10 px-3 rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-800 outline-none focus:border-blue-500 focus:bg-white transition"/>
            <p v-if="nameMessage" class="mt-1 text-sm text-red-600">{{ nameMessage }}</p>
          </div>
          <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
            <input id="email" v-model="email" type="email" placeholder="mail@site.com"
              class="w-full h-11 px-3 rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-800 outline-none focus:border-blue-500 focus:bg-white transition"/>
            <p v-if="emailMessage" class="mt-1 text-sm text-red-600">{{ emailMessage }}</p>
          </div>
          <div>
            <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
            <input id="password" v-model="password" type="password" placeholder="Password"
              class="w-full h-11 px-3 rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-800 outline-none focus:border-blue-500 focus:bg-white transition"/>
            <p v-if="passwordMessage" class="mt-1 text-sm text-red-600">{{ passwordMessage }}</p>
          </div>
          <div>
            <label for="confPassword" class="block mb-2 text-sm font-medium text-gray-700">Confirm Password</label>
            <input id="confPassword" v-model="confPassword" type="password" placeholder="Confirm password"
              class="w-full h-11 px-3 rounded-lg border border-gray-200 bg-gray-50 text-sm text-gray-800 outline-none focus:border-blue-500 focus:bg-white transition"/>
            <p v-if="confPasswordMessage" class="mt-1 text-sm text-red-600">{{ confPasswordMessage }}</p>
          </div>
          <button type="submit" :disabled="isLoading"
            class="w-full h-11 flex items-center justify-center gap-2 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 active:bg-blue-800 transition">
           {{ isLoading ? "Registering..." : "Register" }}</button>
        </form>
        <div class="mt-6 pt-6 border-t border-gray-600 text-center">
          <p class="text-sm text-gray-500">
            You already have an account?
            <RouterLink to="/login" class="font-medium text-blue-600 hover:text-blue-700 hover:underline">Login</RouterLink>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>