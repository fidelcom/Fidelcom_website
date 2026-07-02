<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })

const sections = [
  { group: 'Content', items: [
    { href: '/dashboard/posts',        label: 'Blog Posts',    icon: 'i-heroicons-document-text', desc: 'Articles & insights' },
    { href: '/dashboard/projects',     label: 'Projects',      icon: 'i-heroicons-squares-2x2',   desc: 'Portfolio work' },
    { href: '/dashboard/services',     label: 'Services',      icon: 'i-heroicons-cog-6-tooth',   desc: 'What you offer' },
    { href: '/dashboard/pages',        label: 'Pages',         icon: 'i-heroicons-document',      desc: 'Static pages' },
    { href: '/dashboard/sliders',      label: 'Sliders',       icon: 'i-heroicons-squares-plus',  desc: 'Hero slideshows' },
  ]},
  { group: 'People', items: [
    { href: '/dashboard/team',         label: 'Team',          icon: 'i-heroicons-users',                  desc: 'Staff members' },
    { href: '/dashboard/testimonials', label: 'Testimonials',  icon: 'i-heroicons-star',                   desc: 'Client reviews' },
    { href: '/dashboard/inquiries',    label: 'Inquiries',     icon: 'i-heroicons-inbox',                  desc: 'Contact messages' },
  ]},
  { group: 'Assets', items: [
    { href: '/dashboard/gallery',      label: 'Gallery',       icon: 'i-heroicons-photo',                  desc: 'Image gallery' },
    { href: '/dashboard/partners',     label: 'Partners',      icon: 'i-heroicons-building-office',        desc: 'Partner logos' },
    { href: '/dashboard/faqs',         label: 'FAQs',          icon: 'i-heroicons-question-mark-circle',   desc: 'Frequently asked' },
  ]},
  { group: 'Site', items: [
    { href: '/dashboard/menus',        label: 'Menus',         icon: 'i-heroicons-bars-3',                 desc: 'Navigation links' },
    { href: '/dashboard/media',        label: 'Media Library', icon: 'i-heroicons-folder-open',            desc: 'Uploaded files' },
    { href: '/dashboard/settings',     label: 'Settings',      icon: 'i-heroicons-adjustments-horizontal', desc: 'Site configuration' },
  ]},
]
</script>

<template>
  <div>
    <div class="mb-8">
      <h1 class="text-2xl font-bold text-heading">Overview</h1>
      <p class="text-body text-sm mt-1">Manage your site content from one place.</p>
    </div>

    <div class="space-y-8">
      <div v-for="section in sections" :key="section.group">
        <p class="text-[11px] font-semibold text-body/40 uppercase tracking-[0.12em] mb-3">{{ section.group }}</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
          <NuxtLink
            v-for="s in section.items"
            :key="s.href"
            :to="s.href"
            class="group flex items-center gap-4 bg-surface border border-border rounded-xl px-4 py-3.5 hover:bg-surface-alt hover:border-primary/40 transition-all duration-150"
          >
            <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center flex-shrink-0 group-hover:bg-primary/15 transition-colors">
              <Icon :name="s.icon" class="w-[18px] h-[18px] text-primary" />
            </div>
            <div class="min-w-0">
              <p class="text-heading text-sm font-medium truncate">{{ s.label }}</p>
              <p class="text-body text-xs truncate">{{ s.desc }}</p>
            </div>
          </NuxtLink>
        </div>
      </div>
    </div>
  </div>
</template>
