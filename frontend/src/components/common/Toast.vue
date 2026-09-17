<script setup>
import { library } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { useToast } from '../../hooks/useToast';

library.add(fas);

const { show, type, title, message } = useToast();

</script>

<template>
  <div v-if="show" class="fixed top-20 right-10 z-50 text-white px-4 py-2 rounded shadow-lg"
    :class="`${type === 'success' ? 'bg-success' : type === 'error' ? 'bg-error' : type === 'info' ? 'bg-info' : ''}`">
    <strong>{{ title }}</strong>
    <p>{{ message }}</p>
  </div>
</template>