<script setup>
import {reactive} from "vue";

defineProps({
  showLogin: {
    type: Boolean,
    required: true,
    default: false,
  },

  authError: {
    type: String,
    default: null,
  },
})

const loginForm = reactive(
  {
    email: '',
    password: '',
  }
);

const emit = defineEmits([
  'update:showLogin',
  'handleLogin',
]);
</script>

<template>
  <div v-if="showLogin" @click.self="$emit('update:showLogin', false)"
       class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
    <div class="bg-surface dark:bg-dark-surface p-8 rounded-lg shadow-xl w-full max-w-md">
      <h2 class="text-2xl font-bold text-text-primary dark:text-dark-text-primary mb-6">
        Login
      </h2>
      <form @submit.prevent="$emit('handleLogin', loginForm)">
        <div class="mb-4">
          <label
            for="login-email"
            class="block text-sm font-medium text-text-secondary dark:text-dark-text-secondary mb-1"
          >
            Email
          </label>
          <input
            v-model="loginForm.email"
            id="login-email"
            type="email"
            autocomplete="email"
            placeholder="seu@email.com"
            class="w-full p-3 bg-background dark:bg-dark-background rounded border border-border dark:border-dark-border text-text-primary dark:text-dark-text-primary focus:outline-none focus:ring-2 focus:ring-primary"
          />
        </div>
        <div class="mb-6">
          <label
            for="login-password"
            class="block text-sm font-medium text-text-secondary dark:text-dark-text-secondary mb-1"
          >
            Senha
          </label>
          <input
            v-model="loginForm.password"
            id="login-password"
            type="password"
            autocomplete="current-password"
            placeholder="Sua senha"
            class="w-full p-3 bg-background dark:bg-dark-background rounded border border-border dark:border-dark-border text-text-primary dark:text-dark-text-primary focus:outline-none focus:ring-2 focus:ring-primary"
          />
        </div>
        <div
          v-if="authError"
          class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
          role="alert"
        >
          <span class="block sm:inline">
            {{ authError }}
          </span>
        </div>
        <button
          type="submit"
          class="w-full bg-primary hover:bg-primary-hover text-white font-bold py-3 rounded-lg transition-colors"
        >
          Entrar
        </button>
      </form>
    </div>
  </div>
</template>