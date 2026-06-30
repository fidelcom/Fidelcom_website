<script setup lang="ts">
defineProps<{ settings?: { phone?: string; email?: string; facebook?: string | null; twitter?: string | null; instagram?: string | null; linkedin?: string | null } | null }>()

const api = useApi()
const { data: menuData } = await useAsyncData('header-menu', () =>
  api.get<{ data: { items: { id: number; label: string; url: string; children?: any[] }[] }[] }>('/menus?location=header').then(r => r.data[0])
)

const menuOpen = ref(false)
const route = useRoute()
watch(() => route.path, () => menuOpen.value = false)
</script>

<template>
  <header class="sticky top-0 z-40 bg-bg/95 backdrop-blur border-b border-border">
    <div class="container mx-auto px-4 h-16 flex items-center justify-between gap-6">
      <!-- Logo -->
      <NuxtLink to="/" class="flex items-center gap-2 flex-shrink-0">
        <span class="text-primary font-bold text-xl tracking-tight">Fidelcom</span>
        <span class="hidden sm:block text-body text-xs">Systems Limited</span>
      </NuxtLink>

      <!-- Desktop nav -->
      <nav class="hidden md:flex items-center gap-1">
        <NuxtLink
          v-for="item in menuData?.items"
          :key="item.id"
          :to="item.url"
          class="px-3 py-2 rounded-lg text-sm text-body hover:text-heading transition-colors"
          active-class="text-heading font-medium"
        >{{ item.label }}</NuxtLink>
      </nav>

      <div class="flex items-center gap-3">
        <NuxtLink to="/contact-us" class="hidden md:flex items-center btn-cta">Request a Quote</NuxtLink>
        <button class="md:hidden p-2 text-body hover:text-heading" @click="menuOpen = !menuOpen">
          <Icon :name="menuOpen ? 'i-heroicons-x-mark' : 'i-heroicons-bars-3'" class="w-5 h-5" />
        </button>
      </div>
    </div>

    <!-- Mobile nav -->
    <Transition name="slide-down">
      <nav v-if="menuOpen" class="md:hidden bg-surface border-b border-border px-4 pb-4">
        <NuxtLink
          v-for="item in menuData?.items"
          :key="item.id"
          :to="item.url"
          class="flex items-center py-3 text-body hover:text-heading border-b border-border/50 last:border-0"
        >{{ item.label }}</NuxtLink>
      </nav>
    </Transition>
  </header>
</template>

<style scoped>
@reference "../assets/css/main.css";
.btn-cta { @apply bg-primary text-white text-sm font-medium px-4 py-2 rounded-lg hover:bg-primary-alt transition-colors; }
.slide-down-enter-active, .slide-down-leave-active { transition: all 0.2s ease; }
.slide-down-enter-from, .slide-down-leave-to { opacity: 0; transform: translateY(-8px); }
</style>
