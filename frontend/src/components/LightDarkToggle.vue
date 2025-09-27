<script setup>
defineProps({
  user: {
    type: Object,
    default: null,
  },
  showLogin: {
    type: Boolean,
    required: true,
    default: false,
  },
  showRegister: {
    type: Boolean,
    required: true,
    default: false,
  },
  isDarkMode: {
    type: Boolean,
    required: true,
  },
})

defineEmits([
  'update:showLogin',
  'update:showRegister',

  'toggleTheme',
  'logout',
])
</script>

<template>
  <div class="flex items-center space-x-4">
    <button
      class="text-text-secondary dark:text-dark-text-secondary hover:text-primary dark:hover:text-dark-primary transition-colors"
      @click="$emit('toggleTheme')"
    >
      <svg v-if="isDarkMode" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
      </svg>
      <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
      </svg>
    </button>

    <template v-if="user">
      <span class="text-text-secondary dark:text-dark-text-secondary hidden sm:block">
        Olá, {{ user.name ?? 'Fulano' }}
      </span>

      <button
        class="bg-primary hover:bg-primary-hover text-white font-bold py-2 px-4 rounded-lg transition-colors"
        @click="$emit('logout')"
      >
        Sair
      </button>
    </template>

    <template v-else>
      <button
        class="text-text-secondary dark:text-dark-text-secondary hover:text-text-primary dark:hover:text-dark-text-primary transition-colors"
        @click="$emit('update:showLogin', true)"
      >
        Login
      </button>

      <button
        class="bg-primary hover:bg-primary-hover text-white font-bold py-2 px-4 rounded-lg transition-colors"
        @click="$emit('update:showRegister', true)"
      >
        Registrar
      </button>
    </template>
  </div>
</template>