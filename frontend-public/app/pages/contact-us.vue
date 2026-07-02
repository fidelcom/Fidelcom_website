<script setup lang="ts">
import type { Page } from '../../../shared/types/api'

const api = useApi()
const { data: page } = await useAsyncData('contact', async () => {
  const res = await api.get<{ data: Page }>('/pages/contact-us')
  return res.data
})

const { data: settings } = useNuxtData<{ phone: string; email: string; address: string }>('settings')

const { href: canonicalUrl, origin } = useRequestURL()

useSeoMeta({
  title: page.value?.meta_title ?? 'Contact Us | Fidelcom Systems',
  description: page.value?.meta_description ?? 'Get in touch with Fidelcom Systems Limited for IT solutions, consulting, and project inquiries.',
  ogTitle: page.value?.meta_title ?? 'Contact Us | Fidelcom Systems',
  ogDescription: page.value?.meta_description ?? 'Get in touch with Fidelcom Systems Limited for IT solutions, consulting, and project inquiries.',
})

useHead({
  link: [{ rel: 'canonical', href: canonicalUrl }],
  script: computed(() => [{
    type: 'application/ld+json',
    innerHTML: JSON.stringify({
      '@context': 'https://schema.org',
      '@type': 'Organization',
      name: 'Fidelcom Systems',
      url: origin,
      ...(settings.value?.phone ? {
        contactPoint: {
          '@type': 'ContactPoint',
          telephone: settings.value.phone,
          contactType: 'customer service',
          areaServed: 'NG',
          availableLanguage: 'English',
        },
      } : {}),
      ...(settings.value?.address ? {
        address: {
          '@type': 'PostalAddress',
          addressLocality: 'Lagos',
          addressCountry: 'NG',
          streetAddress: settings.value.address,
        },
      } : {}),
    }),
  }]),
})
</script>

<template>
  <div>
    <section class="py-16 bg-surface border-b border-border">
      <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-heading mb-3">Contact Us</h1>
        <p class="text-body">We'd love to hear about your project. Reach out and we'll respond within 24 hours.</p>
      </div>
    </section>

    <template v-if="page?.blocks?.length">
      <BlockRenderer v-for="block in page.blocks" :key="block.id" :block="block" />
    </template>

    <template v-else>
      <section class="py-16">
        <div class="container mx-auto px-4">
          <div class="grid md:grid-cols-2 gap-12 max-w-5xl mx-auto">
            <!-- Contact form -->
            <BlocksContactForm :data="{ heading: 'Send a Message', subheading: 'Fill out the form and we\'ll be in touch shortly.' }" />

            <!-- Contact info -->
            <div class="space-y-6 pt-8">
              <div v-if="settings?.address" class="flex gap-4">
                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                  <Icon name="i-heroicons-map-pin" class="w-5 h-5 text-primary" />
                </div>
                <div>
                  <p class="text-heading font-medium mb-1">Address</p>
                  <p class="text-body text-sm">{{ settings.address }}</p>
                </div>
              </div>
              <div v-if="settings?.phone" class="flex gap-4">
                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                  <Icon name="i-heroicons-phone" class="w-5 h-5 text-primary" />
                </div>
                <div>
                  <p class="text-heading font-medium mb-1">Phone</p>
                  <a :href="`tel:${settings.phone}`" class="text-body text-sm hover:text-primary transition-colors">{{ settings.phone }}</a>
                </div>
              </div>
              <div v-if="settings?.email" class="flex gap-4">
                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                  <Icon name="i-heroicons-envelope" class="w-5 h-5 text-primary" />
                </div>
                <div>
                  <p class="text-heading font-medium mb-1">Email</p>
                  <a :href="`mailto:${settings.email}`" class="text-body text-sm hover:text-primary transition-colors">{{ settings.email }}</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </template>
  </div>
</template>
