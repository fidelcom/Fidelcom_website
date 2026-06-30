<script setup lang="ts">
import { useAuthStore } from '../stores/auth'

const auth = useAuthStore()

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
    <aside class="w-60 bg-surface flex-shrink-0 flex flex-col border-r border-border">
      <div class="px-6 py-5 border-b border-border">
        <span class="text-heading font-bold text-lg tracking-tight">Fidelcom</span>
        <span class="text-primary text-xs font-semibold ml-1">Admin</span>
      </div>

      <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-6">
        <div v-for="group in navGroups" :key="group.label">
          <p class="text-xs font-semibold text-body uppercase tracking-widest px-3 mb-2">
            {{ group.label }}
          </p>
          <ul class="space-y-0.5">
            <li v-for="item in group.items" :key="item.href">
              <NuxtLink
                :to="item.href"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-body hover:text-heading hover:bg-surface-alt transition-colors"
                active-class="text-heading bg-primary/10 font-medium"
                exact-active-class="text-primary"
              >
                <Icon :name="item.icon" class="w-4 h-4 flex-shrink-0" />
                {{ item.label }}
              </NuxtLink>
            </li>
          </ul>
        </div>
      </nav>

      <div class="px-3 py-4 border-t border-border">
        <div class="flex items-center gap-3 px-3 py-2">
          <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center text-primary text-sm font-bold flex-shrink-0">
            {{ auth.user?.name?.charAt(0) ?? '?' }}
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-heading text-sm font-medium truncate">{{ auth.user?.name }}</p>
            <p class="text-body text-xs truncate">{{ auth.user?.email }}</p>
          </div>
        </div>
        <button
          class="mt-2 w-full text-left px-3 py-2 rounded-lg text-sm text-body hover:text-heading hover:bg-surface-alt transition-colors flex items-center gap-3"
          @click="auth.logout"
        >
          <Icon name="i-heroicons-arrow-right-on-rectangle" class="w-4 h-4" />
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
</template>
