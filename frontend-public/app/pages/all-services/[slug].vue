<script setup lang="ts">
const route = useRoute()
const api = useApi()

const { data: service, error } = await useAsyncData(`service-${route.params.slug}`, async () => {
  const res = await api.get<{ data: { id: number; title: string; slug: string; body: string; excerpt: string; image: string | null; icon: string | null; meta_title: string | null; meta_description: string | null } }>(`/services/${route.params.slug}`)
  return res.data
})

if (error.value) throw createError({ statusCode: 404, message: 'Service not found' })

useSeoMeta({
  title: service.value?.meta_title ?? `${service.value?.title} | Fidelcom Systems`,
  description: service.value?.meta_description ?? service.value?.excerpt ?? '',
  ogImage: service.value?.image ?? undefined,
})
</script>

<template>
  <div>
    <div class="py-16">
      <div class="container mx-auto px-4 max-w-4xl">
        <NuxtLink to="/all-services" class="text-primary text-sm hover:underline mb-8 inline-flex items-center gap-1">
          <Icon name="i-heroicons-arrow-left" class="w-4 h-4" /> Services
        </NuxtLink>

        <div v-if="service">
          <div class="flex items-center gap-4 mb-6">
            <div v-if="service.icon" class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center flex-shrink-0">
              <Icon :name="service.icon" class="w-7 h-7 text-primary" />
            </div>
            <h1 class="text-4xl font-bold text-heading">{{ service.title }}</h1>
          </div>
          <p class="text-body text-xl leading-relaxed mb-8">{{ service.excerpt }}</p>
          <img v-if="service.image" :src="service.image" :alt="service.title" class="w-full rounded-2xl mb-10 object-cover max-h-80" />
          <!-- eslint-disable-next-line vue/no-v-html -->
          <div class="prose max-w-none text-body [&_a]:text-primary [&_h2]:text-heading [&_h3]:text-heading leading-relaxed" v-html="service.body" />

          <div class="mt-12 p-8 bg-primary rounded-2xl text-center">
            <h3 class="text-white text-2xl font-bold mb-3">Ready to get started?</h3>
            <p class="text-white/80 mb-6">Let's discuss how we can help your business with {{ service.title }}.</p>
            <NuxtLink to="/contact-us" class="bg-white text-primary px-6 py-3 rounded-xl font-semibold hover:bg-white/90 transition-colors">Contact Us</NuxtLink>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
