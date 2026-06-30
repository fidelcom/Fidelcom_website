<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

interface Partner { id: number; name: string; image: string; url: string | null }

const heading = (props.data.heading as string | undefined) ?? 'Trusted By'
const api = useApi()

const { data: partners } = await useAsyncData('partners-block', async () => {
  const res = await api.get<{ data: Partner[] }>('/partners')
  return res.data
})
</script>

<template>
  <section class="py-16 border-y border-border">
    <div class="container mx-auto px-4">
      <p class="text-body text-sm text-center mb-8 uppercase tracking-widest">{{ heading }}</p>
      <div class="flex flex-wrap items-center justify-center gap-8 md:gap-12">
        <component
          :is="partner.url ? 'a' : 'div'"
          v-for="partner in partners"
          :key="partner.id"
          :href="partner.url ?? undefined"
          :target="partner.url ? '_blank' : undefined"
          rel="noopener"
          class="opacity-50 hover:opacity-100 transition-opacity grayscale hover:grayscale-0"
        >
          <img :src="partner.image" :alt="partner.name" class="h-10 object-contain max-w-[140px]" />
        </component>
      </div>
    </div>
  </section>
</template>
