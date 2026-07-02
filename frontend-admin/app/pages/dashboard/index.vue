<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })

const api = useApi()

interface Stats {
  total_posts: number
  draft_posts: number
  total_projects: number
  draft_projects: number
  total_pages: number
  pending_inquiries: number
}

const stats = ref<Stats | null>(null)

onMounted(async () => {
  stats.value = await api.get<{ data: Stats }>('/admin/dashboard/stats').then(r => r.data).catch(() => null)
})

const statCards = computed(() => stats.value ? [
  { label: 'Total Posts',        value: stats.value.total_posts,       sub: `${stats.value.draft_posts} draft`,       icon: 'i-heroicons-document-text',  href: '/dashboard/posts',    accent: false },
  { label: 'Total Projects',     value: stats.value.total_projects,    sub: `${stats.value.draft_projects} draft`,    icon: 'i-heroicons-squares-2x2',    href: '/dashboard/projects', accent: false },
  { label: 'Pages',              value: stats.value.total_pages,        sub: 'published pages',                       icon: 'i-heroicons-document',       href: '/dashboard/pages',    accent: false },
  { label: 'Pending Inquiries',  value: stats.value.pending_inquiries,  sub: 'awaiting review',                       icon: 'i-heroicons-inbox',          href: '/dashboard/inquiries', accent: stats.value.pending_inquiries > 0 },
] : [])

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

    <!-- Stats cards -->
    <div v-if="stats" class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-10">
      <NuxtLink
        v-for="card in statCards"
        :key="card.label"
        :to="card.href"
        :class="[
          'group flex flex-col gap-1.5 rounded-xl px-5 py-4 border transition-all duration-150',
          card.accent
            ? 'bg-amber-500/10 border-amber-500/30 hover:border-amber-500/60'
            : 'bg-surface border-border hover:border-primary/30 hover:bg-surface-alt',
        ]"
      >
        <div class="flex items-center justify-between">
          <Icon
            :name="card.icon"
            :class="['w-4 h-4', card.accent ? 'text-amber-400' : 'text-primary']"
          />
          <Icon name="i-heroicons-arrow-up-right" class="w-3.5 h-3.5 text-body/30 group-hover:text-body/60 transition-colors" />
        </div>
        <p
          :class="['text-3xl font-black tabular-nums leading-none mt-1', card.accent ? 'text-amber-400' : 'text-heading']"
          style="font-family: var(--font-display);"
        >{{ card.value }}</p>
        <p class="text-heading text-sm font-medium">{{ card.label }}</p>
        <p class="text-body text-xs">{{ card.sub }}</p>
      </NuxtLink>
    </div>
    <div v-else class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-10">
      <div v-for="i in 4" :key="i" class="h-[108px] rounded-xl bg-surface border border-border animate-pulse" />
    </div>

    <!-- Navigation sections -->
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
