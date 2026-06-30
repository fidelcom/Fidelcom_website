<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

interface Service { id: number; title: string; slug: string; excerpt: string; image: string | null; icon: string | null }

const heading = (props.data.heading as string | undefined) ?? 'Our Services'
const limit = (props.data.limit as number | undefined) ?? 6
const api = useApi()

const { data: services } = await useAsyncData('services-block', async () => {
  const res = await api.get<{ data: Service[] }>('/services', { limit })
  return res.data
})
</script>

<template>
  <section class="py-20 bg-surface">
    <div class="container mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-heading">{{ heading }}</h2>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <NuxtLink
          v-for="service in services"
          :key="service.id"
          :to="`/all-services/${service.slug}`"
          class="group bg-bg rounded-2xl p-6 border border-border hover:border-primary transition-all hover:shadow-lg"
        >
          <div v-if="service.icon" class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4 group-hover:bg-primary/20 transition-colors">
            <Icon :name="service.icon" class="w-6 h-6 text-primary" />
          </div>
          <img v-else-if="service.image" :src="service.image" :alt="service.title" class="w-full h-40 object-cover rounded-xl mb-4" />
          <h3 class="text-heading font-semibold mb-2 group-hover:text-primary transition-colors">{{ service.title }}</h3>
          <p class="text-body text-sm line-clamp-3">{{ service.excerpt }}</p>
        </NuxtLink>
      </div>
      <div class="text-center mt-10">
        <NuxtLink to="/all-services" class="border border-border text-heading px-6 py-3 rounded-xl font-medium hover:border-primary transition-colors">View All Services</NuxtLink>
      </div>
    </div>
  </section>
</template>
