<script setup lang="ts">
defineProps<{ settings?: { phone?: string; email?: string; facebook?: string | null; twitter?: string | null; instagram?: string | null; linkedin?: string | null } | null }>()

const api = useApi()
const { data: menuData } = await useAsyncData('header-menu', () =>
  api.get<{ data: { items: { id: number; label: string; url: string; children?: any[] }[] }[] }>('/menus?location=header').then(r => r.data[0])
)

const menuOpen = ref(false)
const route = useRoute()
watch(() => route.path, () => { menuOpen.value = false })

const { y: scrollY } = useWindowScroll()
const scrolled = computed(() => scrollY.value > 40)
</script>

<template>
  <header
    :class="[
      'fixed top-0 left-0 right-0 z-50 h-[72px] transition-all duration-300',
      scrolled
        ? 'bg-black/96 backdrop-blur-md border-b border-white/[0.07]'
        : 'bg-transparent border-b border-transparent',
    ]"
  >
    <!-- Edge-to-edge flex row — no horizontal padding on the wrapper -->
    <div class="flex items-center h-full w-full">

      <!-- ① Hamburger — touches left viewport edge -->
      <button
        class="flex-shrink-0 w-[64px] h-full flex items-center justify-center border-r border-white/[0.1] text-white/50 hover:text-white transition-colors duration-150"
        :aria-expanded="menuOpen"
        aria-label="Toggle navigation"
        @click="menuOpen = !menuOpen"
      >
        <Icon :name="menuOpen ? 'i-heroicons-x-mark' : 'i-heroicons-bars-3'" class="w-[18px] h-[18px]" />
      </button>

      <!-- ② Logo -->
      <NuxtLink to="/" class="flex items-center gap-3 flex-shrink-0 group pl-7 pr-10">
        <div class="w-[26px] h-[26px] bg-primary flex items-center justify-center flex-shrink-0 group-hover:bg-primary-alt transition-colors duration-150">
          <span class="text-white font-black text-[11px] leading-none" style="font-family: var(--font-display);">F</span>
        </div>
        <span class="text-white font-semibold text-[15px] tracking-[-0.01em] hidden sm:block" style="font-family: var(--font-display);">Fidelcom</span>
      </NuxtLink>

      <!-- ③ Desktop nav — centered, flex-1 -->
      <nav class="hidden md:flex items-center justify-center flex-1 gap-1" aria-label="Main navigation">
        <NuxtLink
          v-for="item in menuData?.items"
          :key="item.id"
          :to="item.url"
          :aria-current="(item.url === '/' ? route.path === '/' : route.path.startsWith(item.url)) ? 'page' : undefined"
          class="px-[14px] py-2 text-[13px] text-white/40 hover:text-white transition-colors duration-150 tracking-[0.01em] font-normal"
          active-class="!text-white"
        >{{ item.label }}</NuxtLink>
      </nav>

      <!-- ④ Right: CTA pill + search — search touches right viewport edge -->
      <div class="flex items-center flex-shrink-0 ml-auto">
        <NuxtLink
          to="/contact-us"
          class="hidden md:inline-flex items-center border border-white/50 rounded-full text-white text-[12px] font-medium px-5 py-[7px] hover:border-white hover:bg-white/5 transition-all duration-200 tracking-[0.1em] uppercase mr-5"
        >
          Contact Us
        </NuxtLink>

        <!-- Search — touches right viewport edge with left separator -->
        <button
          class="hidden md:flex flex-shrink-0 w-[64px] h-[72px] items-center justify-center border-l border-white/[0.1] text-white/40 hover:text-white transition-colors duration-150"
          aria-label="Search"
        >
          <Icon name="i-heroicons-magnifying-glass" class="w-[18px] h-[18px]" />
        </button>
      </div>
    </div>

    <!-- Slide-down nav drawer (desktop + mobile) -->
    <Transition name="slide-down">
      <nav
        v-if="menuOpen"
        :class="[
          'absolute top-full left-0 right-0 border-b border-white/[0.08] z-50',
          scrolled || menuOpen ? 'bg-black/97 backdrop-blur-md' : 'bg-black/95 backdrop-blur-md',
        ]"
      >
        <div class="max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16 py-4">
          <NuxtLink
            v-for="item in menuData?.items"
            :key="item.id"
            :to="item.url"
            :aria-current="(item.url === '/' ? route.path === '/' : route.path.startsWith(item.url)) ? 'page' : undefined"
            class="flex items-center py-4 text-[13px] text-white/50 hover:text-white border-b border-white/[0.05] last:border-0 transition-colors tracking-wide font-normal"
          >{{ item.label }}</NuxtLink>
          <NuxtLink
            to="/contact-us"
            class="flex justify-center items-center mt-5 w-full border border-white/20 rounded-full text-white text-[12px] font-medium px-4 py-3 hover:border-primary/60 hover:bg-primary/8 transition-all tracking-[0.06em] uppercase"
          >
            Contact Us
          </NuxtLink>
        </div>
      </nav>
    </Transition>
  </header>
</template>

<style scoped>
.slide-down-enter-active, .slide-down-leave-active { transition: all 0.22s cubic-bezier(0.16,1,0.3,1); }
.slide-down-enter-from, .slide-down-leave-to { opacity: 0; transform: translateY(-6px); }
</style>
