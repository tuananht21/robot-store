<script setup>

const props = defineProps({
  isLoading: {
    type: Boolean,
  },
})

</script>

<template>
  <div v-if="props.isLoading" class="fixed inset-0 flex flex-col items-center justify-center bg-slate-50 z-9999">
    <div class="w-12 h-12 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>

    <p class="mt-4 text-slate-600 font-medium animate-pulse">
      Đang tải dữ liệu...
    </p>
  </div>
</template>