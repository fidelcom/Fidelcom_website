import tailwindcss from '@tailwindcss/vite'

export default defineNuxtConfig({
  ssr: true,

  compatibilityDate: '2025-06-01',

  future: {
    compatibilityVersion: 4,
  },

  vite: {
    plugins: [tailwindcss()],
  },

  modules: [
    '@pinia/nuxt',
    '@nuxt/image',
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

  routeRules: {
    '/': { prerender: false },
    '/blog/**': { swr: 300 },
    '/portfolio/**': { swr: 300 },
    '/all-services/**': { swr: 3600 },
  },

  app: {
    head: {
      htmlAttrs: { lang: 'en-NG' },
      meta: [
        { name: 'theme-color', content: '#5237f9' },
      ],
      link: [
        { rel: 'icon', type: 'image/png', href: '/favicon.png' },
      ],
    },
  },

  image: {
    quality: 85,
    format: ['webp', 'avif'],
  },
})
