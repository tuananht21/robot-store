<script setup>
import { library } from "@fortawesome/fontawesome-svg-core";
import { fas } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(fas);

const props = defineProps({
  size: {
    type: String,
    default: "xl",
  },
});
</script>

<template>
  <div class="inline-flex items-center gap-3">
    <!-- Logo Icon -->
    <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-cyan-500 shadow-md">
      <FontAwesomeIcon icon="fa-solid fa-robot" :class="`text-white text-${props.size}`"/>
    </div>    
  </div>
</template>