<script setup lang="ts">
interface Crumb {
  label: string
  to?: string
}
defineProps<{ crumbs: Crumb[] }>()
</script>

<template>
  <nav aria-label="Breadcrumb" class="py-3 border-b border-border bg-surface">
    <div class="container mx-auto px-4">
      <ol class="flex flex-wrap items-center gap-1.5 text-sm text-body" itemscope itemtype="https://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" class="flex items-center gap-1.5">
          <NuxtLink to="/" itemprop="item" class="hover:text-primary transition-colors">
            <span itemprop="name">Home</span>
          </NuxtLink>
          <meta itemprop="position" content="1" />
          <Icon name="i-heroicons-chevron-right" class="w-3 h-3 opacity-50" />
        </li>
        <li
          v-for="(crumb, i) in crumbs"
          :key="crumb.label"
          itemprop="itemListElement"
          itemscope
          itemtype="https://schema.org/ListItem"
          class="flex items-center gap-1.5"
        >
          <NuxtLink
            v-if="crumb.to"
            :to="crumb.to"
            itemprop="item"
            class="hover:text-primary transition-colors"
          >
            <span itemprop="name">{{ crumb.label }}</span>
          </NuxtLink>
          <span v-else itemprop="name" class="text-heading font-medium">{{ crumb.label }}</span>
          <meta :content="String(i + 2)" itemprop="position" />
          <Icon v-if="crumb.to" name="i-heroicons-chevron-right" class="w-3 h-3 opacity-50" />
        </li>
      </ol>
    </div>
  </nav>
</template>
