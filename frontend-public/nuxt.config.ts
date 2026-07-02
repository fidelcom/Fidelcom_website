import tailwindcss from '@tailwindcss/vite'

export default defineNuxtConfig({
  ssr: true,

  compatibilityDate: '2025-06-01',

  future: {
    compatibilityVersion: 4,
  },

  css: ['~/assets/css/main.css'],

  vite: {
    plugins: [tailwindcss()],
  },

  modules: [
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
    '/blog/**': { swr: 60 },
    '/portfolio/**': { swr: 60 },
    '/all-services/**': { swr: 60 },
    '/**': {
      headers: {
        'X-Content-Type-Options': 'nosniff',
        'X-Frame-Options': 'SAMEORIGIN',
        'X-XSS-Protection': '1; mode=block',
        'Referrer-Policy': 'strict-origin-when-cross-origin',
        'Permissions-Policy': 'camera=(), microphone=(), geolocation=()',
        'Content-Security-Policy': [
          "default-src 'self'",
          "script-src 'self' 'unsafe-inline'",
          "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
          "img-src 'self' data: blob: http://localhost:8001 https://fidelcom.org",
          "font-src 'self' data: https://fonts.gstatic.com",
          "media-src 'self' blob: https://videos.pexels.com https://assets.mixkit.co",
          "connect-src 'self' http://localhost:8001",
          "frame-ancestors 'none'",
        ].join('; '),
      },
    },
  },

  app: {
    head: {
      htmlAttrs: { lang: 'en-NG' },
      meta: [
        { name: 'theme-color', content: '#5237f9' },
      ],
      link: [
        { rel: 'preconnect', href: 'https://fonts.googleapis.com' },
        { rel: 'preconnect', href: 'https://fonts.gstatic.com', crossorigin: '' },
        { rel: 'stylesheet', href: 'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Sora:wght@300;400;600;700;800&display=swap' },
        { rel: 'icon', type: 'image/png', href: '/favicon.png' },
      ],
    },
  },

  image: {
    quality: 85,
    format: ['webp', 'avif'],
  },
})
