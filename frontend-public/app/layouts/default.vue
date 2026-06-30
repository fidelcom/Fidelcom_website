<script setup lang="ts">
const { get } = useApi()

const { data: settings } = await useAsyncData('settings', () =>
  get<{ data: { phone: string; email: string; address: string; facebook: string | null; twitter: string | null; instagram: string | null; linkedin: string | null } }>('/settings').then(r => r.data)
)
</script>

<template>
  <div class="flex flex-col min-h-screen bg-bg">
    <SiteHeader :settings="settings" />

    <main id="main-content" class="flex-1">
      <slot />
    </main>

    <SiteFooter :settings="settings" />
  </div>
</template>
