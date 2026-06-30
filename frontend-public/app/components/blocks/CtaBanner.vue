<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

const heading = (props.data.heading as string | undefined) ?? 'Ready to Start Your Project?'
const body = props.data.body as string | undefined
const buttonLabel = (props.data.button_label as string | undefined) ?? 'Contact Us'
const buttonUrl = (props.data.button_url as string | undefined) ?? '/contact-us'
const bgColor = (props.data.bg_color as string | undefined) ?? 'primary'
</script>

<template>
  <section :class="['py-20', bgColor === 'surface' ? 'bg-surface' : 'bg-primary']">
    <div class="container mx-auto px-4 text-center max-w-2xl">
      <h2 :class="['text-3xl md:text-4xl font-bold mb-4', bgColor === 'surface' ? 'text-heading' : 'text-white']">{{ heading }}</h2>
      <p v-if="body" :class="['text-lg mb-8 leading-relaxed', bgColor === 'surface' ? 'text-body' : 'text-white/80']">{{ body }}</p>
      <NuxtLink
        :to="buttonUrl"
        :class="['px-8 py-4 rounded-xl font-semibold text-lg transition-colors', bgColor === 'surface' ? 'bg-primary text-white hover:bg-primary-alt' : 'bg-white text-primary hover:bg-white/90']"
      >{{ buttonLabel }}</NuxtLink>
    </div>
  </section>
</template>
