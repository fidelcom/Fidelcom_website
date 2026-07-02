<script setup lang="ts">
interface Project { id: number; title: string; slug: string; excerpt: string; image: string | null; category: string | null }

const api = useApi()
const { assetUrl } = useAssetUrl()
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
    <!-- Page header -->
    <section class="pt-16 pb-20 bg-black border-b border-[#1a1a1a]">
      <div class="w-full max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16">
        <div class="flex items-center gap-4 mb-8">
          <div class="w-8 h-px bg-primary" />
          <span class="text-primary/80 text-xs font-semibold uppercase tracking-[0.2em]">Our Work</span>
        </div>
        <h1
          class="text-white font-black leading-[0.88] tracking-[-0.04em] mb-5"
          style="font-family: var(--font-display); font-size: clamp(3rem, 7vw, 6.5rem);"
        >Portfolio</h1>
        <p class="text-white/40 text-lg max-w-xl leading-relaxed">Explore our work across web development, mobile apps, IT infrastructure, and digital consulting.</p>
      </div>
    </section>

    <!-- Projects — full-bleed editorial cards on dark -->
    <section class="py-14 bg-bg">
      <div class="w-full max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16">
        <div v-if="!data?.data.length" class="text-center py-32">
          <Icon name="i-heroicons-squares-2x2" class="w-10 h-10 text-body/10 mx-auto mb-3" />
          <p class="text-body text-sm">No projects found.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
          <NuxtLink
            v-for="(project, i) in data?.data"
            :key="project.id"
            :to="`/portfolio/${project.slug}`"
            :class="[
              'group relative overflow-hidden block bg-surface',
              i === 0 && page === 1 ? 'md:col-span-2 aspect-[16/7]' : 'aspect-[16/10]',
            ]"
          >
            <!-- Full-bleed image -->
            <img
              v-if="project.image"
              :src="assetUrl(project.image)"
              :alt="project.title"
              class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-[1.04]"
            />
            <div v-else class="absolute inset-0 bg-surface-alt flex items-center justify-center">
              <Icon name="i-heroicons-squares-2x2" class="w-12 h-12 text-body/10" />
            </div>

            <!-- Gradient overlay -->
            <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.3) 45%, rgba(0,0,0,0.05) 100%);" />

            <!-- Primary tint on hover -->
            <div class="absolute inset-0 bg-primary/0 group-hover:bg-primary/8 transition-colors duration-500" />

            <!-- Text -->
            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10">
              <p v-if="project.category" class="text-primary text-[10px] font-bold uppercase tracking-[0.16em] mb-2">{{ project.category }}</p>
              <h2
                :class="[
                  'text-white font-bold leading-snug',
                  i === 0 && page === 1 ? 'text-2xl md:text-4xl' : 'text-xl md:text-2xl',
                ]"
              >{{ project.title }}</h2>
            </div>

            <!-- Hover arrow -->
            <div class="absolute top-6 right-6 w-10 h-10 border border-white/20 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
              <Icon name="i-heroicons-arrow-up-right" class="w-5 h-5 text-white" />
            </div>
          </NuxtLink>
        </div>

        <div v-if="(data?.meta.last_page ?? 1) > 1" class="flex items-center justify-center gap-4 mt-14">
          <button
            :disabled="page <= 1"
            class="inline-flex items-center gap-2 px-5 py-2.5 border border-border text-body text-sm hover:border-primary/50 hover:text-white disabled:opacity-30 transition-all"
            @click="page--"
          >
            <Icon name="i-heroicons-chevron-left" class="w-4 h-4" /> Previous
          </button>
          <span class="text-body text-sm tabular-nums">{{ data?.meta.current_page }} / {{ data?.meta.last_page }}</span>
          <button
            :disabled="page >= (data?.meta.last_page ?? 1)"
            class="inline-flex items-center gap-2 px-5 py-2.5 border border-border text-body text-sm hover:border-primary/50 hover:text-white disabled:opacity-30 transition-all"
            @click="page++"
          >
            Next <Icon name="i-heroicons-chevron-right" class="w-4 h-4" />
          </button>
        </div>
      </div>
    </section>
  </div>
</template>
