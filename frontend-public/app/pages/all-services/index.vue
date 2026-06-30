<script setup lang="ts">
interface Service { id: number; title: string; slug: string; excerpt: string; image: string | null; icon: string | null }

const api = useApi()
const { data: services } = await useAsyncData('all-services', async () => {
  const res = await api.get<{ data: Service[] }>('/services')
  return res.data
})

useSeoMeta({ title: 'Our Services | Fidelcom Systems', description: 'Full-stack software development, IT consulting, mobile apps, web development, and digital transformation services in Nigeria.' })
</script>

<template>
  <div>
    <section class="py-16 bg-surface border-b border-border">
      <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-heading mb-3">Our Services</h1>
        <p class="text-body max-w-2xl">From custom software development to IT infrastructure and digital strategy — we help businesses grow with technology.</p>
      </div>
    </section>

    <section class="py-16">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <NuxtLink
            v-for="service in services"
            :key="service.id"
            :to="`/all-services/${service.slug}`"
            class="group bg-surface rounded-2xl p-6 border border-border hover:border-primary transition-all hover:shadow-lg"
          >
            <div v-if="service.icon" class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-primary/20 transition-colors">
              <Icon :name="service.icon" class="w-6 h-6 text-primary" />
            </div>
            <img v-else-if="service.image" :src="service.image" :alt="service.title" class="w-full h-36 object-cover rounded-xl mb-4" />
            <h2 class="text-heading font-semibold mb-2 group-hover:text-primary transition-colors">{{ service.title }}</h2>
            <p class="text-body text-sm line-clamp-3">{{ service.excerpt }}</p>
            <span class="mt-4 inline-flex items-center gap-1 text-primary text-sm font-medium">
              Learn more <Icon name="i-heroicons-arrow-right" class="w-4 h-4" />
            </span>
          </NuxtLink>
        </div>
      </div>
    </section>
  </div>
</template>
