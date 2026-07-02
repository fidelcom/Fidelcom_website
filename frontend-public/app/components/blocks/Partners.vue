<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

interface Partner { id: number; name: string; image: string; url: string | null }

const heading = (props.data.heading as string | undefined) ?? 'Trusted By'
const api = useApi()
const { assetUrl } = useAssetUrl()

const { data: partners } = await useAsyncData('partners-block', async () => {
  const res = await api.get<{ data: Partner[] }>('/partners')
  return res.data
})
</script>

<template>
  <section class="py-14 border-y border-border bg-bg-alt">
    <div class="w-full max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16">
      <p class="text-body/50 text-[10px] font-semibold uppercase tracking-[0.2em] text-center mb-10">{{ heading }}</p>
      <div class="flex flex-wrap items-center justify-center gap-10 md:gap-16">
        <component
          :is="partner.url ? 'a' : 'div'"
          v-for="partner in partners"
          :key="partner.id"
          :href="partner.url ?? undefined"
          :target="partner.url ? '_blank' : undefined"
          rel="noopener"
          class="opacity-30 hover:opacity-75 transition-opacity duration-300 grayscale hover:grayscale-0"
        >
          <img :src="assetUrl(partner.image)" :alt="partner.name" class="h-8 object-contain max-w-[120px]" />
        </component>
      </div>
    </div>
  </section>
</template>
