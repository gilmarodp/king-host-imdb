<template>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="max-w-2xl mx-auto mb-12">
      <form @submit.prevent="searchMovies" class="relative">
        <input
            type="text"
            v-model="searchQuery"
            placeholder="Buscar por um filme..."
            class="w-full px-6 py-4 bg-surface dark:bg-dark-surface border-2 border-border dark:border-dark-border rounded-full text-text-primary dark:text-dark-text-primary text-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-shadow duration-300"
        >
        <button
          type="submit"
          class="absolute right-2 top-1/2 -translate-y-1/2 bg-primary hover:bg-primary-hover rounded-full p-3 text-white transition-colors"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
          </svg>
        </button>
      </form>
    </div>

      <div v-if="isLoading" class="text-center">
         <p class="text-2xl animate-pulse text-text-secondary dark:text-dark-text-secondary">
           Buscando...
         </p>
      </div>
      <div v-else-if="hasSearched && searchResults.length > 0">
        <h2 class="text-3xl font-bold mb-6 text-text-primary dark:text-dark-text-primary">
          Resultados da Busca
        </h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
          <MovieCard
            v-for="movie in searchResults" :key="movie.id"
            :movie="movie"
            :is-favorite="isFavorite(movie)"
            @add-favorite="$emit('addFavorite', movie)"
            @remove-favorite="$emit('removeFavorite', movie)"
          />
        </div>
      </div>
    <div v-else-if="hasSearched && searchResults.length === 0" class="text-center py-16">
      <p class="text-2xl text-text-secondary dark:text-dark-text-secondary">
        Nenhum filme encontrado para "{{ searchQuery }}".
      </p>
    </div>
    <div v-else class="text-center py-16">
      <h2 class="text-4xl font-bold mb-2 text-text-primary dark:text-dark-text-primary">
        Encontre Seu Próximo Filme Favorito
      </h2>
      <p class="text-xl text-text-secondary dark:text-dark-text-secondary">
        Use a busca para explorar um universo de filmes.
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import MovieCard from './MovieCard.vue';

const props = defineProps(['favorites']);
const emit = defineEmits(['addFavorite', 'removeFavorite']);

const searchQuery = ref('');
const searchResults = ref([]);
const isLoading = ref(false);
const hasSearched = ref(false);

const TMDB_API_KEY = import.meta.env?.VITE_TMDB_API_KEY || 'chave_tmdb';

const favoriteIds = computed(() => new Set(props.favorites.map(f => f.movie_id)));
const isFavorite = (movie) => favoriteIds.value.has(movie.id);

const searchMovies = async () => {
  if (!searchQuery.value.trim()) return;

  isLoading.value = true;
  hasSearched.value = true;

  try {
    const url = `https://api.themoviedb.org/3/search/movie?api_key=${TMDB_API_KEY}&query=${encodeURIComponent(searchQuery.value)}&language=pt-BR`;
    const res = await fetch(url);
    const data = await res.json();
    searchResults.value = data.results || [];
  } catch (error) {
    console.error("Erro ao buscar filmes:", error);
    searchResults.value = [];
  } finally {
    isLoading.value = false;
  }
};
</script>
