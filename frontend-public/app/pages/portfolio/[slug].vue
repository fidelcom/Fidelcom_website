<script setup lang="ts">
const route = useRoute()
const api = useApi()

const { data: project, error } = await useAsyncData(`project-${route.params.slug}`, async () => {
  const res = await api.get<{ data: { id: number; title: string; slug: string; body: string; excerpt: string; image: string | null; multi_image: string[] | null; category: string | null; client: string | null; year: number | null; url: string | null; meta_title: string | null; meta_description: string | null } }>(`/projects/${route.params.slug}`)
  return res.data
})

if (error.value) throw createError({ statusCode: 404, message: 'Project not found' })

useSeoMeta({
  title: project.value?.meta_title ?? project.value?.title ?? 'Project',
  description: project.value?.meta_description ?? project.value?.excerpt ?? '',
  ogImage: project.value?.image ?? undefined,
})

const activeImage = ref(0)
const images = computed(() => {
  const all: string[] = []
  if (project.value?.image) all.push(project.value.image)
  if (project.value?.multi_image) all.push(...project.value.multi_image)
  return all
})
</script>

<template>
  <div>
    <div class="py-16">
      <div class="container mx-auto px-4 max-w-5xl">
        <NuxtLink to="/portfolio" class="text-primary text-sm hover:underline mb-8 inline-flex items-center gap-1">
          <Icon name="i-heroicons-arrow-left" class="w-4 h-4" /> Portfolio
        </NuxtLink>

        <div v-if="project" class="grid md:grid-cols-3 gap-10">
          <div class="md:col-span-2">
            <p v-if="project.category" class="text-primary text-sm font-medium mb-2 uppercase tracking-wide">{{ project.category }}</p>
            <h1 class="text-4xl font-bold text-heading mb-4">{{ project.title }}</h1>

            <!-- Image gallery -->
            <div v-if="images.length" class="mb-8">
              <img :src="images[activeImage]" :alt="project.title" class="w-full rounded-2xl object-cover max-h-96 mb-2" />
              <div v-if="images.length > 1" class="flex gap-2 overflow-x-auto pb-2">
                <button v-for="(img, i) in images" :key="i" :class="['flex-shrink-0 rounded-lg overflow-hidden border-2 transition-colors', i === activeImage ? 'border-primary' : 'border-border']" @click="activeImage = i">
                  <img :src="img" :alt="`${project.title} ${i + 1}`" class="w-16 h-12 object-cover" />
                </button>
              </div>
            </div>

            <!-- eslint-disable-next-line vue/no-v-html -->
            <div class="prose max-w-none text-body [&_a]:text-primary [&_h2]:text-heading [&_h3]:text-heading leading-relaxed" v-html="project.body" />
          </div>

          <aside class="space-y-4">
            <div class="bg-surface rounded-2xl p-6 border border-border">
              <h3 class="text-heading font-semibold mb-4">Project Details</h3>
              <dl class="space-y-3 text-sm">
                <div v-if="project.client">
                  <dt class="text-body">Client</dt>
                  <dd class="text-heading font-medium">{{ project.client }}</dd>
                </div>
                <div v-if="project.year">
                  <dt class="text-body">Year</dt>
                  <dd class="text-heading font-medium">{{ project.year }}</dd>
                </div>
                <div v-if="project.category">
                  <dt class="text-body">Category</dt>
                  <dd class="text-heading font-medium">{{ project.category }}</dd>
                </div>
              </dl>
              <a v-if="project.url" :href="project.url" target="_blank" rel="noopener" class="mt-6 flex items-center justify-center gap-2 bg-primary text-white py-2.5 rounded-xl font-medium hover:bg-primary-alt transition-colors">
                <Icon name="i-heroicons-arrow-top-right-on-square" class="w-4 h-4" />
                View Live
              </a>
            </div>
            <NuxtLink to="/contact-us" class="flex items-center justify-center gap-2 border border-border text-heading py-2.5 rounded-xl font-medium hover:border-primary transition-colors w-full">
              Start a Similar Project
            </NuxtLink>
          </aside>
        </div>
      </div>
    </div>
  </div>
</template>
