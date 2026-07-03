<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

interface Project { id: number; title: string; slug: string; excerpt: string; image: string | null; category: string | null }

const heading = (props.data.heading as string | undefined) ?? 'Our Portfolio'
const limit = (props.data.limit as number | undefined) ?? 6
const category = props.data.category as string | undefined
const api = useApi()
const { assetUrl } = useAssetUrl()

const { data: projects } = await useAsyncData('projects-block', async () => {
  const params: Record<string, unknown> = { limit }
  if (category) params.category = category
  const res = await api.get<{ data: Project[] }>('/projects', params)
  return res.data
})
</script>

<template>
  <!-- Dark section — EPAM editorial full-bleed case study cards -->
  <section class="py-24 bg-bg border-t border-border">
    <div class="w-full max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16">

      <div class="flex items-end justify-between mb-14 gap-6">
        <div>
          <p class="text-primary text-xs font-semibold uppercase tracking-[0.15em] mb-5">Selected Work</p>
          <h2
            class="text-heading font-black leading-[0.9] tracking-[-0.04em]"
            style="font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 5rem); text-wrap: balance;"
          >{{ heading }}</h2>
        </div>
        <NuxtLink
          to="/portfolio"
          class="hidden sm:inline-flex items-center gap-2 text-sm text-body hover:text-heading transition-colors flex-shrink-0 group"
        >
          View all work
          <Icon name="i-heroicons-arrow-right" class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" />
        </NuxtLink>
      </div>

      <!-- Full-bleed editorial grid — EPAM case study style -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <NuxtLink
          v-for="(project, i) in projects"
          :key="project.id"
          :to="`/portfolio/${project.slug}`"
          :class="[
            'group relative overflow-hidden block bg-surface',
            i === 0 ? 'md:col-span-2 aspect-[16/7]' : 'aspect-[16/10]',
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

          <!-- Dark gradient overlay — heavier at bottom for text -->
          <div
            class="absolute inset-0 transition-opacity duration-300"
            style="background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.35) 45%, rgba(0,0,0,0.1) 100%);"
          />

          <!-- Hover overlay tint -->
          <div class="absolute inset-0 bg-primary/0 group-hover:bg-primary/8 transition-colors duration-500" />

          <!-- Text overlay at bottom -->
          <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8">
            <p v-if="project.category" class="text-primary text-[10px] font-bold uppercase tracking-[0.16em] mb-2">{{ project.category }}</p>
            <h3
              :class="[
                'text-white font-bold leading-snug group-hover:text-white/85 transition-colors duration-200',
                i === 0 ? 'text-2xl md:text-3xl' : 'text-lg md:text-xl',
              ]"
            >{{ project.title }}</h3>
          </div>

          <!-- Arrow on hover -->
          <div class="absolute top-6 right-6 w-10 h-10 border border-white/20 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200">
            <Icon name="i-heroicons-arrow-up-right" class="w-5 h-5 text-white" />
          </div>
        </NuxtLink>
      </div>

      <!-- Mobile view-all -->
      <div class="mt-10 sm:hidden">
        <NuxtLink
          to="/portfolio"
          class="inline-flex items-center gap-2 border border-border text-body text-sm font-medium px-5 py-3 hover:border-primary/50 hover:text-heading transition-all"
        >
          View All Work <Icon name="i-heroicons-arrow-right" class="w-4 h-4" />
        </NuxtLink>
      </div>
    </div>
  </section>
</template>
