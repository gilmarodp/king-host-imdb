<script setup>
import { defineProps } from 'vue';

defineProps({
  currentView: {
    type: String,
    required: true
  },

  user: {
    type: Object,
    default: null
  },

  favorites: {
    type: Array,
    default: () => []
  }
})

const emit = defineEmits(['update:currentView']);
</script>

<template>
  <div class="hidden md:flex items-center space-x-6 text-lg">
    <button
      class="py-2"
      :class="{
        'text-primary font-bold border-b-2 border-primary': currentView === 'search',
        'text-text-secondary dark:text-dark-text-secondary hover:text-text-primary dark:hover:text-dark-text-primary transition-colors duration-300': currentView !== 'search',
      }"
      @click="$emit('update:currentView', 'search')"
    >
      Buscar
    </button>
    <button
      v-if="user"
      class="py-2"
      :class="{
        'text-primary font-bold border-b-2 border-primary': currentView === 'favorites',
        'text-text-secondary dark:text-dark-text-secondary hover:text-text-primary dark:hover:text-dark-text-primary transition-colors duration-300': currentView !== 'favorites',
      }"
      @click="$emit('update:currentView', 'favorites')"
    >
      Favoritos
      <span class="bg-primary text-white text-xs font-bold rounded-full px-2 py-0.5 ml-1">
        {{ favorites.length }}
      </span>
    </button>
  </div>
</template>