<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

interface Project { id: number; title: string; slug: string; excerpt: string; image: string | null; category: string | null }

const heading = (props.data.heading as string | undefined) ?? 'Our Portfolio'
const limit = (props.data.limit as number | undefined) ?? 6
const category = props.data.category as string | undefined
const api = useApi()

const { data: projects } = await useAsyncData('projects-block', async () => {
  const params: Record<string, unknown> = { limit }
  if (category) params.category = category
  const res = await api.get<{ data: Project[] }>('/projects', params)
  return res.data
})
</script>

<template>
  <section class="py-20">
    <div class="container mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-3xl font-bold text-heading">{{ heading }}</h2>
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <NuxtLink
          v-for="project in projects"
          :key="project.id"
          :to="`/portfolio/${project.slug}`"
          class="group rounded-2xl overflow-hidden border border-border hover:border-primary transition-all hover:shadow-xl"
        >
          <div class="relative overflow-hidden h-52">
            <img v-if="project.image" :src="project.image" :alt="project.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
            <div v-else class="w-full h-full bg-surface flex items-center justify-center">
              <Icon name="i-heroicons-photo" class="w-12 h-12 text-body/30" />
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-bg/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity" />
          </div>
          <div class="p-5">
            <p v-if="project.category" class="text-primary text-xs font-medium mb-1 uppercase tracking-wide">{{ project.category }}</p>
            <h3 class="text-heading font-semibold group-hover:text-primary transition-colors">{{ project.title }}</h3>
            <p class="text-body text-sm mt-1 line-clamp-2">{{ project.excerpt }}</p>
          </div>
        </NuxtLink>
      </div>
      <div class="text-center mt-10">
        <NuxtLink to="/portfolio" class="border border-border text-heading px-6 py-3 rounded-xl font-medium hover:border-primary transition-colors">View All Projects</NuxtLink>
      </div>
    </div>
  </section>
</template>
