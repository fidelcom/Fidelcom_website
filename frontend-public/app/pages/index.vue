<script setup lang="ts">
import type { Page } from '../../../shared/types/api'

const { get } = useApi()

const { data: page, error } = await useAsyncData('home', () =>
  get<{ data: Page }>('/pages/home').then(r => r.data)
)

useSeoMeta({
  title: page.value?.meta_title ?? 'Fidelcom Systems Limited',
  description: page.value?.meta_description ?? 'IT solutions, software development, and digital consulting in Nigeria and beyond.',
  ogTitle: page.value?.meta_title ?? 'Fidelcom Systems Limited',
  ogDescription: page.value?.meta_description ?? 'IT solutions, software development, and digital consulting in Nigeria and beyond.',
  ogType: 'website',
  ogUrl: 'https://fidelcom.org',
})

useHead({
  script: [{
    type: 'application/ld+json',
    innerHTML: JSON.stringify({
      '@context': 'https://schema.org',
      '@type': 'Organization',
      name: 'Fidelcom Systems Limited',
      url: 'https://fidelcom.org',
      logo: 'https://fidelcom.org/favicon.png',
      sameAs: [],
      address: {
        '@type': 'PostalAddress',
        addressCountry: 'NG',
        addressLocality: 'Lagos',
      },
      contactPoint: {
        '@type': 'ContactPoint',
        contactType: 'customer service',
        availableLanguage: 'English',
      },
    }),
  }],
})
</script>

<template>
  <div>
    <template v-if="page">
      <BlockRenderer v-for="block in page.blocks" :key="block.id" :block="block" />
    </template>
    <div v-else-if="error" class="py-32 text-center text-body">
      Unable to load page content.
    </div>
  </div>
</template>
