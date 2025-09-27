<template>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col sm:flex-row justify-between items-center mb-8">
      <h2 class="text-3xl font-bold mb-4 sm:mb-0 text-text-primary dark:text-dark-text-primary">
        Meus Favoritos
      </h2>
    </div>

    <div v-if="favorites.length > 0">
      <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
        <MovieCard
            v-for="movie in favorites" :key="movie.movie_id"
            :movie="{
              id: movie.movie_id,
              title: movie.movie_title,
              poster_path: movie.movie_poster,
              overview: '',
            }"
            :is-favorite="true"
            @remove-favorite="$emit('removeFavorite', { id: movie.movie_id })"
        />
      </div>
    </div>
    <div v-else class="text-center py-16">
      <p class="text-2xl text-text-secondary dark:text-dark-text-secondary">
        Sua lista de favoritos está vazia.
      </p>
      <p class="text-lg text-gray-500 dark:text-gray-400 mt-2">
        Adicione filmes na tela de busca!
      </p>
    </div>
  </div>
</template>

<script setup>
import MovieCard from './MovieCard.vue';

defineProps(['favorites']);
defineEmits(['removeFavorite']);
</script>
