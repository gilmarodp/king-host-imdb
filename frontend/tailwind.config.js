module.exports = {
  darkMode: 'class',
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {
      colors: {
        'primary': '#E50914',
        'primary-hover': '#F6121D',
        'background': '#F0F2F5',
        'surface': '#FFFFFF',
        'text-primary': '#1C1E21',
        'text-secondary': '#606770',
        'border': '#CED0D4',

        'dark-primary': '#E50914',
        'dark-primary-hover': '#F6121D',
        'dark-background': '#141414',
        'dark-surface': '#1F1F1F',
        'dark-text-primary': '#E4E6EB',
        'dark-text-secondary': '#B0B3B8',
        'dark-border': '#393A3B',
      }
    },
  },
  plugins: [],
}
