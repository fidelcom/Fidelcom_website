<script setup lang="ts">
import type { Block } from '../../../shared/types/api'

const props = defineProps<{ block: Block }>()

const blockComponents: Record<string, ReturnType<typeof resolveComponent>> = {
  hero: resolveComponent('BlocksHero'),
  content: resolveComponent('BlocksContent'),
  services_grid: resolveComponent('BlocksServicesGrid'),
  projects_grid: resolveComponent('BlocksProjectsGrid'),
  stats: resolveComponent('BlocksStats'),
  testimonials: resolveComponent('BlocksTestimonials'),
  blog_posts: resolveComponent('BlocksBlogPosts'),
  team: resolveComponent('BlocksTeam'),
  faqs: resolveComponent('BlocksFaqs'),
  cta_banner: resolveComponent('BlocksCtaBanner'),
  gallery: resolveComponent('BlocksGallery'),
  partners: resolveComponent('BlocksPartners'),
  contact_form: resolveComponent('BlocksContactForm'),
  process_steps: resolveComponent('BlocksProcessSteps'),
  slider: resolveComponent('BlocksSlider'),
  case_study: resolveComponent('BlocksCaseStudy'),
}
</script>

<template>
  <component
    :is="blockComponents[block.block_type]"
    v-if="blockComponents[block.block_type]"
    :data="block.data"
  />
  <div v-else class="py-4 text-center text-body text-sm opacity-50">
    Unknown block: {{ block.block_type }}
  </div>
</template>
