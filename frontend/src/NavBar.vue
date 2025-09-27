<script setup>
import KingHostImdbLogo from '@/components/KingHostImdbLogo.vue'
import MenuBar from '@/components/MenuBar.vue'
import LightDarkToggle from '@/components/LightDarkToggle.vue'

defineProps({
  currentView: {
    type: String,
    required: true,
  },
  user: {
    type: Object,
    default: null,
  },
  favorites: {
    type: Array,
    default: () => [],
  },
  isDarkMode: {
    type: Boolean,
    required: true,
  },
  showLogin: {
    type: Boolean,
    required: true,
  },
  showRegister: {
    type: Boolean,
    required: true,
  },
})

const API_URL = import.meta.env?.VITE_API_URL || 'http://localhost:8000/api';

const emit = defineEmits([
  'update:showRegister',
  'update:favorites',
  'update:user',
  'update:currentView',
  'update:showLogin',
  'update:showRegister',
  'toggleTheme',
]);

const logout = async () => {
  try {
    const token = localStorage.getItem('token');
    await fetch(`${API_URL}/logout`, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      }
    });
  } catch (error) {
    console.error("Erro ao fazer logout:", error);
  } finally {
    localStorage.removeItem('token');
    emit('update:user', null);
    emit('update:favorites', []);
    emit('update:currentView', 'search');
  }
};
</script>

<template>
  <nav class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-20">
      <KingHostImdbLogo/>

      <MenuBar
        :currentView="currentView"
        :user="user"
        :favorites="favorites"
        @update:currentView="emit('update:currentView', $event)"
      />

      <LightDarkToggle
        :user="user"
        :showLogin="showLogin"
        :showRegister="showRegister"
        :isDarkMode="isDarkMode"
        @update:showLogin="$emit('update:showLogin', $event)"
        @update:showRegister="$emit('update:showRegister', $event)"
        @toggleTheme="$emit('toggleTheme')"
        @logout="logout"
      />
    </div>
  </nav>
</template>