import tailwindcss from '@tailwindcss/vite'

export default defineNuxtConfig({
  ssr: false,

  compatibilityDate: '2025-06-01',

  future: {
    compatibilityVersion: 4,
  },

  css: ['~/assets/css/main.css'],

  vite: {
    plugins: [tailwindcss()],
  },

  modules: [
    '@nuxt/icon',
    '@vueuse/nuxt',
  ],

  routeRules: {
    '/': { redirect: '/dashboard' },
  },

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
      link: [
        { rel: 'preconnect', href: 'https://fonts.googleapis.com' },
        { rel: 'preconnect', href: 'https://fonts.gstatic.com', crossorigin: '' },
        { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Sora:wght@600;700;800&display=swap' },
      ],
    },
  },
})
