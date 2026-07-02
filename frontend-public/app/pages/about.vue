<script setup lang="ts">
import type { Page } from '../../../shared/types/api'

const api = useApi()
const { data: page } = await useAsyncData('about', async () => {
  const res = await api.get<{ data: Page }>('/pages/about')
  return res.data
})

useSeoMeta({
  title: page.value?.meta_title ?? 'About Us | Fidelcom Systems',
  description: page.value?.meta_description ?? 'Learn about Fidelcom Systems Limited — our mission, team, and story.',
})
</script>

<template>
  <div>
    <template v-if="page">
      <BlockRenderer v-for="block in page.blocks" :key="block.id" :block="block" />
    </template>
    <template v-else>
      <section class="py-24">
        <div class="container mx-auto px-4 max-w-3xl text-center">
          <h1 class="text-4xl font-bold text-heading mb-4">About Fidelcom</h1>
          <p class="text-body text-lg">We are a Nigerian IT company delivering enterprise software, web development, and digital consulting solutions across Africa and beyond.</p>
        </div>
      </section>
    </template>
  </div>
</template>
