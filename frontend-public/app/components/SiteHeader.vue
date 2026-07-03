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

const { isDark, toggle } = useTheme()

const headerBg = computed(() => {
  if (menuOpen.value || scrolled.value) {
    return isDark.value ? 'bg-black/96 backdrop-blur-md' : 'bg-white/97 backdrop-blur-md shadow-sm'
  }
  return 'bg-transparent'
})

const headerBorder = computed(() =>
  scrolled.value
    ? isDark.value ? 'border-b border-white/[0.07]' : 'border-b border-black/[0.06]'
    : 'border-b border-transparent'
)

const textColor = computed(() => isDark.value ? 'text-white' : 'text-heading')
const mutedText = computed(() => isDark.value ? 'text-white/40 hover:text-white' : 'text-body hover:text-heading')
const dividerColor = computed(() => isDark.value ? 'border-white/[0.1]' : 'border-black/[0.07]')
</script>

<template>
  <header
    :class="[
      'fixed top-0 left-0 right-0 z-50 h-[72px] transition-all duration-300',
      headerBg,
      headerBorder,
    ]"
  >
    <div class="flex items-center h-full w-full">

      <!-- Hamburger -->
      <button
        :class="['flex-shrink-0 w-[64px] h-full flex items-center justify-center border-r transition-colors duration-150', dividerColor, mutedText]"
        :aria-expanded="menuOpen"
        aria-label="Toggle navigation"
        @click="menuOpen = !menuOpen"
      >
        <Icon :name="menuOpen ? 'i-heroicons-x-mark' : 'i-heroicons-bars-3'" class="w-[18px] h-[18px]" />
      </button>

      <!-- Logo -->
      <NuxtLink to="/" class="flex items-center gap-3 flex-shrink-0 group pl-7 pr-10">
        <div class="w-[26px] h-[26px] bg-primary flex items-center justify-center flex-shrink-0 group-hover:bg-primary-alt transition-colors duration-150">
          <span class="text-white font-black text-[11px] leading-none" style="font-family: var(--font-display);">F</span>
        </div>
        <span :class="['font-semibold text-[15px] tracking-[-0.01em] hidden sm:block transition-colors', textColor]" style="font-family: var(--font-display);">Fidelcom</span>
      </NuxtLink>

      <!-- Desktop nav -->
      <nav class="hidden md:flex items-center justify-center flex-1 gap-1" aria-label="Main navigation">
        <NuxtLink
          v-for="item in menuData?.items"
          :key="item.id"
          :to="item.url"
          :aria-current="(item.url === '/' ? route.path === '/' : route.path.startsWith(item.url)) ? 'page' : undefined"
          :class="['px-[14px] py-2 text-[13px] transition-colors duration-150 tracking-[0.01em] font-normal', mutedText]"
          active-class="!text-primary"
        >{{ item.label }}</NuxtLink>
      </nav>

      <!-- Right: CTA + theme toggle + search -->
      <div class="flex items-center flex-shrink-0 ml-auto">
        <NuxtLink
          to="/contact-us"
          :class="['hidden md:inline-flex items-center rounded-full text-[12px] font-medium px-5 py-[7px] transition-all duration-200 tracking-[0.1em] uppercase mr-3 border',
                   isDark
                     ? 'border-white/50 text-white hover:border-white hover:bg-white/5'
                     : 'border-primary/50 text-primary hover:border-primary hover:bg-primary/5']"
        >
          Contact Us
        </NuxtLink>

        <!-- Theme toggle -->
        <button
          :title="isDark ? 'Switch to light mode' : 'Switch to dark mode'"
          :class="['hidden md:flex flex-shrink-0 w-10 h-10 items-center justify-center rounded-lg mr-2 transition-colors duration-150',
                   isDark ? 'text-white/40 hover:text-white hover:bg-white/8' : 'text-body hover:text-heading hover:bg-black/6']"
          @click="toggle"
        >
          <Icon :name="isDark ? 'i-heroicons-sun' : 'i-heroicons-moon'" class="w-[18px] h-[18px]" />
        </button>

        <!-- Search -->
        <button
          :class="['hidden md:flex flex-shrink-0 w-[64px] h-[72px] items-center justify-center border-l transition-colors duration-150', dividerColor, mutedText]"
          aria-label="Search"
        >
          <Icon name="i-heroicons-magnifying-glass" class="w-[18px] h-[18px]" />
        </button>
      </div>
    </div>

    <!-- Slide-down nav drawer -->
    <Transition name="slide-down">
      <nav
        v-if="menuOpen"
        :class="[
          'absolute top-full left-0 right-0 border-b z-50',
          isDark
            ? 'bg-black/97 backdrop-blur-md border-white/[0.08]'
            : 'bg-white/97 backdrop-blur-md border-black/[0.06] shadow-lg',
        ]"
      >
        <div class="max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16 py-4">
          <NuxtLink
            v-for="item in menuData?.items"
            :key="item.id"
            :to="item.url"
            :aria-current="(item.url === '/' ? route.path === '/' : route.path.startsWith(item.url)) ? 'page' : undefined"
            :class="['flex items-center py-4 text-[13px] border-b last:border-0 transition-colors tracking-wide font-normal',
                     isDark ? 'text-white/50 hover:text-white border-white/[0.05]' : 'text-body hover:text-heading border-border']"
          >{{ item.label }}</NuxtLink>

          <!-- Mobile theme toggle -->
          <button
            :class="['flex items-center gap-3 py-4 text-[13px] tracking-wide font-normal w-full transition-colors',
                     isDark ? 'text-white/50 hover:text-white' : 'text-body hover:text-heading']"
            @click="toggle"
          >
            <Icon :name="isDark ? 'i-heroicons-sun' : 'i-heroicons-moon'" class="w-4 h-4" />
            {{ isDark ? 'Light mode' : 'Dark mode' }}
          </button>

          <NuxtLink
            to="/contact-us"
            :class="['flex justify-center items-center mt-3 w-full border rounded-full text-[12px] font-medium px-4 py-3 transition-all tracking-[0.06em] uppercase',
                     isDark ? 'border-white/20 text-white hover:border-primary/60 hover:bg-primary/8' : 'border-primary/30 text-primary hover:border-primary hover:bg-primary/5']"
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
