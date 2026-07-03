<script setup lang="ts">
const auth = reactive(useAuth())
const { isDark, toggle } = useTheme()

const navGroups = [
  {
    label: 'Content',
    items: [
      { href: '/dashboard',                    label: 'Overview',           icon: 'i-heroicons-home' },
      { href: '/dashboard/posts',              label: 'Blog Posts',         icon: 'i-heroicons-document-text' },
      { href: '/dashboard/blog-categories',    label: 'Blog Categories',    icon: 'i-heroicons-tag' },
      { href: '/dashboard/projects',           label: 'Projects',           icon: 'i-heroicons-squares-2x2' },
      { href: '/dashboard/project-categories', label: 'Project Categories', icon: 'i-heroicons-tag' },
      { href: '/dashboard/services',           label: 'Services',           icon: 'i-heroicons-cog-6-tooth' },
      { href: '/dashboard/pages',              label: 'Pages',              icon: 'i-heroicons-document' },
      { href: '/dashboard/sliders',            label: 'Sliders',            icon: 'i-heroicons-squares-plus' },
    ],
  },
  {
    label: 'People',
    items: [
      { href: '/dashboard/team',         label: 'Team',         icon: 'i-heroicons-users' },
      { href: '/dashboard/testimonials', label: 'Testimonials', icon: 'i-heroicons-star' },
    ],
  },
  {
    label: 'Assets',
    items: [
      { href: '/dashboard/gallery',  label: 'Gallery',  icon: 'i-heroicons-photo' },
      { href: '/dashboard/partners', label: 'Partners', icon: 'i-heroicons-building-office' },
      { href: '/dashboard/faqs',     label: 'FAQs',     icon: 'i-heroicons-question-mark-circle' },
    ],
  },
  {
    label: 'Inquiries',
    items: [
      { href: '/dashboard/inquiries', label: 'All Inquiries', icon: 'i-heroicons-inbox' },
    ],
  },
  {
    label: 'Site',
    items: [
      { href: '/dashboard/menus',    label: 'Menus',         icon: 'i-heroicons-bars-3' },
      { href: '/dashboard/media',    label: 'Media Library', icon: 'i-heroicons-folder-open' },
      { href: '/dashboard/settings', label: 'Settings',      icon: 'i-heroicons-adjustments-horizontal' },
    ],
  },
]
</script>

<template>
  <div class="flex min-h-screen bg-bg">

    <!-- Sidebar -->
    <aside class="w-64 bg-surface flex-shrink-0 flex flex-col border-r border-border">

      <!-- Brand -->
      <div class="h-14 px-4 flex items-center border-b border-border gap-3">
        <div class="relative flex-shrink-0">
          <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center shadow-lg shadow-primary/30">
            <span class="text-white text-sm font-bold leading-none" style="font-family: var(--font-display);">F</span>
          </div>
        </div>
        <div class="flex items-baseline gap-1.5 min-w-0">
          <span class="text-heading font-bold text-sm tracking-tight truncate" style="font-family: var(--font-display);">Fidelcom</span>
          <span class="text-primary text-[9px] font-bold uppercase tracking-[0.15em] flex-shrink-0">Admin</span>
        </div>
      </div>

      <!-- Nav -->
      <nav class="flex-1 overflow-y-auto py-3 px-2">
        <div v-for="(group, gi) in navGroups" :key="group.label" :class="gi > 0 ? 'mt-4' : ''">
          <p class="text-[10px] font-semibold text-body/40 uppercase tracking-[0.14em] px-2.5 mb-1">
            {{ group.label }}
          </p>
          <ul>
            <li v-for="item in group.items" :key="item.href">
              <NuxtLink
                :to="item.href"
                class="nav-item"
                active-class="nav-active"
                exact-active-class="nav-exact"
              >
                <Icon :name="item.icon" class="w-[15px] h-[15px] flex-shrink-0 opacity-70 group-[.nav-active]:opacity-100" />
                {{ item.label }}
              </NuxtLink>
            </li>
          </ul>
        </div>
      </nav>

      <!-- User footer -->
      <div class="border-t border-border p-2">
        <div class="flex items-center gap-2.5 px-2 py-2 rounded-lg">
          <div class="w-7 h-7 rounded-full bg-primary/15 ring-1 ring-primary/25 flex items-center justify-center text-primary text-[11px] font-bold flex-shrink-0">
            {{ auth.user?.name?.charAt(0) ?? '?' }}
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-heading text-xs font-medium truncate leading-none mb-0.5">{{ auth.user?.name }}</p>
            <p class="text-body text-[10px] truncate leading-none opacity-60">{{ auth.user?.email }}</p>
          </div>
          <!-- Theme toggle -->
          <button
            :title="isDark ? 'Switch to light mode' : 'Switch to dark mode'"
            class="w-7 h-7 rounded-lg flex items-center justify-center text-body hover:text-heading hover:bg-surface-alt transition-colors flex-shrink-0"
            @click="toggle"
          >
            <Icon :name="isDark ? 'i-heroicons-sun' : 'i-heroicons-moon'" class="w-4 h-4" />
          </button>
        </div>
        <button
          class="mt-1 w-full text-left px-2.5 py-1.5 rounded-lg text-xs text-body/60 hover:text-red-400 hover:bg-red-500/6 transition-colors flex items-center gap-2"
          @click="auth.logout"
        >
          <Icon name="i-heroicons-arrow-right-on-rectangle" class="w-3.5 h-3.5" />
          Sign out
        </button>
      </div>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col min-w-0">
      <main class="flex-1 p-8">
        <slot />
      </main>
    </div>
  </div>

  <AppToast />
</template>

<style scoped>
@reference "../assets/css/main.css";

.nav-item {
  @apply flex items-center gap-2.5 px-2.5 py-[7px] rounded-md text-[13px] text-body
         hover:text-heading hover:bg-surface-alt transition-all duration-100 w-full mb-0.5;
}

.nav-active {
  @apply text-heading bg-surface-alt;
}

.nav-exact {
  @apply text-primary;
}
</style>
