<script setup>
import {reactive} from "vue";

defineProps({
  showRegister: {
    type: Boolean,
    required: true
  },

  authError: {
    type: String,
    default: null
  },

  validationErrors: {
    type: Object,
    default: () => ({ name: '', email: '', password: '' })
  }
})

const registerForm = reactive(
  {
    name: '',
    email: '',
    password: '',
  }
);

defineEmits([
  'update:showRegister',
  'handleRegister',
]);
</script>

<template>
  <div v-if="showRegister" @click.self="$emit('update:showRegister', false)"
       class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
    <div class="bg-surface dark:bg-dark-surface p-8 rounded-lg shadow-xl w-full max-w-md">
      <h2 class="text-2xl font-bold text-text-primary dark:text-dark-text-primary mb-6">Registrar</h2>
      <form @submit.prevent="$emit('handleRegister', registerForm)" novalidate>
        <div class="mb-4">
          <label
            for="register-name"
            class="block text-sm font-medium text-text-secondary dark:text-dark-text-secondary mb-1"
          >
            Nome
          </label>
          <input
            v-model="registerForm.name"
            id="register-name"
            type="text"
            placeholder="Seu nome completo"
            class="w-full p-3 bg-background dark:bg-dark-background rounded border border-border dark:border-dark-border text-text-primary dark:text-dark-text-primary focus:outline-none focus:ring-2 focus:ring-primary"
          />
          <p
            v-if="validationErrors"
            class="text-red-500 text-xs mt-1"
          >
            {{ validationErrors.name }}
          </p>
        </div>
        <div class="mb-4">
          <label
            for="register-email"
            class="block text-sm font-medium text-text-secondary dark:text-dark-text-secondary mb-1"
          >
            Email
          </label>
          <input
            v-model="registerForm.email"
            id="register-email"
            type="email"
            autocomplete="email"
            placeholder="seu@email.com"
            class="w-full p-3 bg-background dark:bg-dark-background rounded border border-border dark:border-dark-border text-text-primary dark:text-dark-text-primary focus:outline-none focus:ring-2 focus:ring-primary"
          />
          <p
            v-if="validationErrors.email"
            class="text-red-500 text-xs mt-1"
          >
            {{ validationErrors.email }}
          </p>
        </div>
        <div class="mb-6">
          <label
            for="register-password"
            class="block text-sm font-medium text-text-secondary dark:text-dark-text-secondary mb-1"
          >
            Senha
          </label>
          <input
            v-model="registerForm.password"
            id="register-password"
            type="password"
            autocomplete="new-password"
            placeholder="Mínimo de 6 caracteres"
            class="w-full p-3 bg-background dark:bg-dark-background rounded border border-border dark:border-dark-border text-text-primary dark:text-dark-text-primary focus:outline-none focus:ring-2 focus:ring-primary"
          />
          <p
            v-if="validationErrors.password"
            class="text-red-500 text-xs mt-1"
          >
            {{ validationErrors.password }}
          </p>
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
          Criar Conta
        </button>
      </form>
    </div>
  </div>
</template>