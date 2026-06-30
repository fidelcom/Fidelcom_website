import tailwindcss from '@tailwindcss/vite'

export default defineNuxtConfig({
  ssr: false,

  compatibilityDate: '2025-06-01',

  future: {
    compatibilityVersion: 4,
  },

  vite: {
    plugins: [tailwindcss()],
  },

  modules: [
    '@pinia/nuxt',
    '@nuxt/icon',
    '@vueuse/nuxt',
  ],

  runtimeConfig: {
    public: {
      apiBase: '',
    },
  },

  typescript: {
    strict: true,
    typeCheck: false,
  },

  app: {
    head: {
      title: 'Fidelcom Admin',
      meta: [
        { name: 'robots', content: 'noindex, nofollow' },
      ],
    },
  },
})
