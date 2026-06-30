<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

const heading = (props.data.heading as string | undefined) ?? 'Welcome to Fidelcom'
const subheading = props.data.subheading as string | undefined
const buttonLabel = (props.data.button_label as string | undefined) ?? 'Get Started'
const buttonUrl = (props.data.button_url as string | undefined) ?? '/contact-us'
const secondaryLabel = props.data.secondary_label as string | undefined
const secondaryUrl = (props.data.secondary_url as string | undefined) ?? '/portfolio'
const image = props.data.image as string | undefined
</script>

<template>
  <section class="relative overflow-hidden bg-bg py-24 md:py-32">
    <div v-if="image" class="absolute inset-0">
      <img :src="image" alt="" class="w-full h-full object-cover opacity-20" />
      <div class="absolute inset-0 bg-gradient-to-r from-bg via-bg/80 to-transparent" />
    </div>
    <div class="relative container mx-auto px-4">
      <div class="max-w-3xl">
        <h1 class="text-4xl md:text-6xl font-bold text-heading leading-tight mb-6">{{ heading }}</h1>
        <p v-if="subheading" class="text-body text-xl mb-10 leading-relaxed">{{ subheading }}</p>
        <div class="flex flex-wrap gap-4">
          <NuxtLink :to="buttonUrl" class="bg-primary text-white px-6 py-3 rounded-xl font-medium hover:bg-primary-alt transition-colors">{{ buttonLabel }}</NuxtLink>
          <NuxtLink v-if="secondaryLabel" :to="secondaryUrl" class="border border-border text-heading px-6 py-3 rounded-xl font-medium hover:border-primary transition-colors">{{ secondaryLabel }}</NuxtLink>
        </div>
      </div>
    </div>
  </section>
</template>
