<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold text-heading mb-6">Dashboard</h1>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
      <NuxtLink
        v-for="item in navItems"
        :key="item.href"
        :to="item.href"
        class="bg-surface rounded-xl p-6 hover:bg-surface-alt transition-colors group"
      >
        <div class="text-3xl mb-3">{{ item.icon }}</div>
        <p class="text-heading font-semibold group-hover:text-primary transition-colors">{{ item.label }}</p>
      </NuxtLink>
    </div>
  </div>
</template>

<script lang="ts">
const navItems = [
  { href: '/dashboard/posts', label: 'Posts', icon: '📝' },
  { href: '/dashboard/projects', label: 'Projects', icon: '🏗️' },
  { href: '/dashboard/services', label: 'Services', icon: '⚙️' },
  { href: '/dashboard/pages', label: 'Pages', icon: '📄' },
  { href: '/dashboard/team', label: 'Team', icon: '👥' },
  { href: '/dashboard/testimonials', label: 'Testimonials', icon: '⭐' },
  { href: '/dashboard/inquiries', label: 'Inquiries', icon: '📬' },
  { href: '/dashboard/settings', label: 'Settings', icon: '🔧' },
]
</script>
