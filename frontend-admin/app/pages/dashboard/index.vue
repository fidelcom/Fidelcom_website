<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })

const sections = [
  { href: '/dashboard/posts',        label: 'Blog Posts',    icon: 'i-heroicons-document-text' },
  { href: '/dashboard/projects',     label: 'Projects',      icon: 'i-heroicons-squares-2x2' },
  { href: '/dashboard/services',     label: 'Services',      icon: 'i-heroicons-cog-6-tooth' },
  { href: '/dashboard/pages',        label: 'Pages',         icon: 'i-heroicons-document' },
  { href: '/dashboard/team',         label: 'Team',          icon: 'i-heroicons-users' },
  { href: '/dashboard/testimonials', label: 'Testimonials',  icon: 'i-heroicons-star' },
  { href: '/dashboard/faqs',         label: 'FAQs',          icon: 'i-heroicons-question-mark-circle' },
  { href: '/dashboard/gallery',      label: 'Gallery',       icon: 'i-heroicons-photo' },
  { href: '/dashboard/partners',     label: 'Partners',      icon: 'i-heroicons-building-office' },
  { href: '/dashboard/sliders',      label: 'Sliders',       icon: 'i-heroicons-squares-plus' },
  { href: '/dashboard/menus',        label: 'Menus',         icon: 'i-heroicons-bars-3' },
  { href: '/dashboard/inquiries',    label: 'Inquiries',     icon: 'i-heroicons-inbox' },
  { href: '/dashboard/media',        label: 'Media Library', icon: 'i-heroicons-folder-open' },
  { href: '/dashboard/settings',     label: 'Settings',      icon: 'i-heroicons-adjustments-horizontal' },
]
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold text-heading mb-6">Dashboard</h1>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
      <NuxtLink
        v-for="s in sections"
        :key="s.href"
        :to="s.href"
        class="bg-surface rounded-xl p-5 hover:bg-surface-alt transition-colors group flex flex-col gap-3"
      >
        <Icon :name="s.icon" class="w-7 h-7 text-primary" />
        <p class="text-heading font-medium text-sm group-hover:text-primary transition-colors">{{ s.label }}</p>
      </NuxtLink>
    </div>
  </div>
</template>
