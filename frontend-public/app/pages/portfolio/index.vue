<script setup lang="ts">
interface Project { id: number; title: string; slug: string; excerpt: string; image: string | null; category: string | null }

const api = useApi()
const page = ref(1)
const category = ref('')

const { data, refresh } = await useAsyncData('portfolio', async () => {
  const params: Record<string, unknown> = { page: page.value }
  if (category.value) params.category = category.value
  const res = await api.get<{ data: Project[]; meta: { total: number; last_page: number; current_page: number } }>('/projects', params)
  return res
})

watch([page, category], () => refresh())

useSeoMeta({ title: 'Portfolio | Fidelcom Systems', description: 'Our portfolio of software development, web, and digital consulting projects in Nigeria.' })
</script>

<template>
  <div>
    <section class="py-16 bg-surface border-b border-border">
      <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-heading mb-3">Portfolio</h1>
        <p class="text-body">Explore our work across web development, mobile apps, IT infrastructure, and digital consulting.</p>
      </div>
    </section>

    <section class="py-16">
      <div class="container mx-auto px-4">
        <div v-if="!data?.data.length" class="text-center py-20 text-body">No projects found.</div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <NuxtLink
            v-for="project in data?.data"
            :key="project.id"
            :to="`/portfolio/${project.slug}`"
            class="group rounded-2xl overflow-hidden border border-border hover:border-primary transition-all hover:shadow-xl"
          >
            <div class="relative overflow-hidden h-52">
              <img v-if="project.image" :src="project.image" :alt="project.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              <div v-else class="w-full h-full bg-surface flex items-center justify-center">
                <Icon name="i-heroicons-photo" class="w-12 h-12 text-body/30" />
              </div>
            </div>
            <div class="p-5">
              <p v-if="project.category" class="text-primary text-xs font-medium mb-1 uppercase tracking-wide">{{ project.category }}</p>
              <h2 class="text-heading font-semibold group-hover:text-primary transition-colors">{{ project.title }}</h2>
              <p class="text-body text-sm mt-1 line-clamp-2">{{ project.excerpt }}</p>
            </div>
          </NuxtLink>
        </div>

        <div v-if="(data?.meta.last_page ?? 1) > 1" class="flex items-center justify-center gap-3 mt-12">
          <button :disabled="page <= 1" class="px-4 py-2 border border-border rounded-xl text-body hover:border-primary disabled:opacity-40 transition-colors" @click="page--">Previous</button>
          <span class="text-body text-sm">Page {{ data?.meta.current_page }} of {{ data?.meta.last_page }}</span>
          <button :disabled="page >= (data?.meta.last_page ?? 1)" class="px-4 py-2 border border-border rounded-xl text-body hover:border-primary disabled:opacity-40 transition-colors" @click="page++">Next</button>
        </div>
      </div>
    </section>
  </div>
</template>
