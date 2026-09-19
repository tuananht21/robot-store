<script setup>
import { inject } from "vue";
import { useRouter } from "vue-router";

const user = inject('user');
const router = useRouter();

if(!user.value) {
  router.push('/login');
}
</script>

<template>
  <main>
    <div>
      <router-view />
    </div>
  </main>
</template>