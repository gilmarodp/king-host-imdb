<template>
  <div class="group relative bg-surface dark:bg-dark-surface rounded-lg overflow-hidden shadow-lg transform hover:scale-105 hover:z-10 transition-transform duration-300 ease-in-out cursor-pointer h-full">
    <img
        v-if="movie.poster_path"
        :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`"
        :alt="'Pôster do filme ' + movie.title"
        class="w-full h-full object-cover"
    >
    <div v-else class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center p-4">
        <p class="text-center text-sm font-semibold text-text-secondary dark:text-dark-text-secondary">
          {{ movie.title }}
        </p>
    </div>

    <div class="absolute inset-0 movie-card-gradient flex flex-col justify-end p-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
      <h3 class="text-white font-bold text-lg">
        {{ movie.title }}
      </h3>
      <p class="text-gray-300 text-xs line-clamp-2 mt-1">
        {{ movie.overview }}
      </p>

      <button
        v-if="!isFavorite"
        @click.stop="$emit('addFavorite', movie)"
        class="absolute top-3 right-3 bg-black bg-opacity-60 rounded-full p-2 text-white hover:bg-primary transition-colors"
      >
       <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
         <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
       </svg>
      </button>
      <button
        v-else
        @click.stop="$emit('removeFavorite', movie)"
        class="absolute top-3 right-3 bg-primary rounded-full p-2 text-white hover:bg-primary-hover transition-colors"
      >
         <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
           <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
         </svg>
      </button>
    </div>
  </div>
</template>

<script setup>
defineProps(['movie', 'isFavorite']);
defineEmits(['addFavorite', 'removeFavorite']);
</script>
