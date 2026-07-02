<script setup lang="ts">
import type { Page } from '../../../shared/types/api'

const route = useRoute()
const api = useApi()

const { data: page, error } = await useAsyncData(`page-${route.params.slug}`, async () => {
  const res = await api.get<{ data: Page }>(`/pages/${route.params.slug}`)
  return res.data
})

if (error.value) throw createError({ statusCode: 404, message: 'Page not found' })

useSeoMeta({
  title: page.value?.meta_title ?? page.value?.title ?? 'Fidelcom Systems',
  description: page.value?.meta_description ?? '',
})
</script>

<template>
  <div>
    <template v-if="page">
      <BlockRenderer v-for="block in page.blocks" :key="block.id" :block="block" />
    </template>
  </div>
</template>
