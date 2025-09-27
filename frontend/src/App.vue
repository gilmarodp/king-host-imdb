<template>
  <div id="app" class="min-h-screen flex flex-col bg-background dark:bg-dark-background transition-colors duration-300 pb-20 md:pb-0">
    <header class="bg-surface dark:bg-dark-surface backdrop-blur-sm sticky top-0 z-50 shadow-md dark:shadow-lg dark:shadow-black/30">
      <NavBar
        :currentView="currentView"
        :user="user"
        :favorites="favorites"
        :isDarkMode="isDarkMode"
        :showLogin="showLogin"
        :showRegister="showRegister"
        @update:user="user = $event"
        @update:currentView="currentView = $event"
        @update:showLogin="showLogin = $event"
        @update:showRegister="showRegister = $event"
        @toggleTheme="toggleTheme"
      />
    </header>

    <main class="flex-grow">
      <component :is="activeComponent"
        :favorites="favorites"
         @add-favorite="addFavorite"
         @remove-favorite="removeFavorite"
      />
    </main>

    <footer class="bg-surface dark:bg-dark-surface mt-12 py-6 text-center text-text-secondary dark:text-dark-text-secondary hidden md:block">
      <p>&copy; 2025 King Host IMDB - Teste Técnico - Gilmar Oliveira.</p>
    </footer>

    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-surface dark:bg-dark-surface shadow-lg border-t border-border dark:border-dark-border z-50">
        <div class="flex justify-around h-16 items-center">
            <!-- Search Button -->
            <button @click="currentView = 'search'" class="flex flex-col items-center justify-center w-full" :class="{'text-primary': currentView === 'search', 'text-text-secondary dark:text-dark-text-secondary': currentView !== 'search'}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span class="text-xs mt-1">Buscar</span>
            </button>

            <!-- Favorites Button -->
            <button v-if="user" @click="currentView = 'favorites'" class="flex flex-col items-center justify-center w-full" :class="{'text-primary': currentView === 'favorites', 'text-text-secondary dark:text-dark-text-secondary': currentView !== 'favorites'}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" :fill="currentView === 'favorites' ? 'currentColor' : 'none'" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                </svg>
                <span class="text-xs mt-1">Favoritos</span>
            </button>
        </div>
    </div>

    <LoginModal
      :showLogin="showLogin"
      :authError="authError"
      @update:showLogin="showLogin = $event"
      @handleLogin="handleLogin"
    />

    <RegisterModal
      :showRegister="showRegister"
      :authError="authError"
      :validationErrors="validationErrors"
      @update:showRegister="showRegister = $event"
      @handleRegister="handleRegister"
    />
  </div>
</template>

<script setup>
import {computed, onMounted, reactive, ref} from 'vue';
import SearchView from '@/components/SearchView.vue';
import FavoritesView from '@/components/FavoritesView.vue';
import NavBar from "@/NavBar.vue";
import LoginModal from "@/components/modals/LoginModal.vue";
import RegisterModal from "@/RegisterModal.vue";

const currentView = ref('search');
const favorites = ref([]);
const user = ref(null);
const isDarkMode = ref(false);
const authError = ref('');
const validationErrors = reactive({ name: '', email: '', password: '' });

const showLogin = ref(false);
const showRegister = ref(false);

const activeComponent = computed(() => {
  if (currentView.value === 'favorites' && user.value) {
    return FavoritesView;
  }
  return SearchView;
});

const API_URL = import.meta.env?.VITE_API_URL || 'http://localhost:8000/api';

const toggleTheme = () => {
  isDarkMode.value = !isDarkMode.value;
  if (isDarkMode.value) {
    document.documentElement.classList.add('dark');
    localStorage.setItem('theme', 'dark');
  } else {
    document.documentElement.classList.remove('dark');
    localStorage.setItem('theme', 'light');
  }
};

const initializeTheme = () => {
  const savedTheme = localStorage.getItem('theme');
  const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

  if (savedTheme === 'dark' || (!savedTheme && systemPrefersDark)) {
    isDarkMode.value = true;
    document.documentElement.classList.add('dark');
  } else {
    isDarkMode.value = false;
    document.documentElement.classList.remove('dark');
  }
};

const fetchFavorites = async () => {
  if (!user.value) return;
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`${API_URL}/favorites`, {
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (res.ok) {
      favorites.value = await res.json();
    }
  } catch (error) {
    console.error("Erro ao buscar favoritos:", error);
  }
};

const addFavorite = async (movieToAdd) => {
  if (!user.value) {
    showLogin.value = true;
    return;
  }
  if (favorites.value.some(m => m.movie_id === movieToAdd.id)) return;

  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`${API_URL}/favorites`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': `Bearer ${token}`
      },
      body: JSON.stringify({
        movie_id: movieToAdd.id,
        movie_title: movieToAdd.title,
        movie_poster: movieToAdd.poster_path
      })
    });
    if (res.ok) {
      const newFavorite = await res.json();
      favorites.value.push(newFavorite);
    }
  } catch (error) {
    console.error("Erro ao adicionar favorito:", error);
  }
};

const removeFavorite = async (movieToRemove) => {
  try {
    const token = localStorage.getItem('token');
    const res = await fetch(`${API_URL}/favorites/${movieToRemove.id}`, {
      method: 'DELETE',
      headers: { 'Authorization': `Bearer ${token}` }
    });
    if (res.ok) {
      favorites.value = favorites.value.filter(m => m.movie_id !== movieToRemove.id);
    }
  } catch (error) {
    console.error("Erro ao remover favorito:", error);
  }
};

const handleLogin = async (loginForm) => {
  authError.value = '';
  try {
    const res = await fetch(`${API_URL}/login`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(loginForm)
    });
    if (res.ok) {
      const data = await res.json();
      localStorage.setItem('token', data.token);
      user.value = data.user;
      showLogin.value = false;
      await fetchFavorites();
    } else {
      const errorData = await res.json();
      authError.value = errorData.message || (errorData.errors && Object.values(errorData.errors)[0][0]) || 'Ocorreu um erro de autenticação.';
    }
  } catch (error) {
    authError.value = 'Não foi possível conectar ao servidor.';
    console.error("Erro ao fazer login:", error);
  }
};

const handleRegister = async (registerForm) => {
  authError.value = '';
  Object.keys(validationErrors).forEach(key => validationErrors[key] = '');

  try {
    const res = await fetch(`${API_URL}/register`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(registerForm)
    });
    if (res.ok) {
      const data = await res.json();
      localStorage.setItem('token', data.token);
      user.value = data.user;
      showRegister.value = false;
      await fetchFavorites();
    } else {
      const errorData = await res.json();
      if (res.status === 422) {
        for (const field in errorData.errors) {
          if (validationErrors.hasOwnProperty(field)) {
            validationErrors[field] = errorData.errors[field][0];
          }
        }
      } else {
        authError.value = errorData.message || 'Ocorreu um erro no registro.';
      }
    }
  } catch (error) {
    authError.value = 'Não foi possível conectar ao servidor.';
    console.error("Erro ao registrar:", error);
  }
};

const checkAuth = async () => {
  const token = localStorage.getItem('token');
  if (token) {
    try {
      const res = await fetch(`${API_URL}/user`, {
        headers: { 'Authorization': `Bearer ${token}` }
      });
      if (res.ok) {
        user.value = await res.json();
        await fetchFavorites();
      } else {
        localStorage.removeItem('token');
      }
    } catch (error) {
      console.error("Erro ao verificar autenticação:", error);
      localStorage.removeItem('token');
    }
  }
};

onMounted(() => {
  initializeTheme();
  checkAuth();
});
</script>