<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

const heading = props.data.heading as string | undefined

interface Stat { label: string; value: string; icon?: string }
const stats: Stat[] = (props.data.items as Stat[] | undefined) ?? [
  { label: 'Projects Delivered', value: '200+', icon: 'i-heroicons-rocket-launch' },
  { label: 'Happy Clients', value: '150+', icon: 'i-heroicons-face-smile' },
  { label: 'Years Experience', value: '10+', icon: 'i-heroicons-calendar-days' },
  { label: 'Countries Served', value: '5+', icon: 'i-heroicons-globe-alt' },
]
</script>

<template>
  <section class="py-20 bg-primary">
    <div class="container mx-auto px-4">
      <h2 v-if="heading" class="text-3xl font-bold text-white text-center mb-12">{{ heading }}</h2>
      <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
        <div v-for="stat in stats" :key="stat.label" class="text-center">
          <Icon v-if="stat.icon" :name="stat.icon" class="w-8 h-8 text-white/70 mx-auto mb-3" />
          <p class="text-4xl font-bold text-white mb-1">{{ stat.value }}</p>
          <p class="text-white/80 text-sm">{{ stat.label }}</p>
        </div>
      </div>
    </div>
  </section>
</template>
