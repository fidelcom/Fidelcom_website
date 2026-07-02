<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

const heading = props.data.heading as string | undefined
const body = (props.data.body as string | undefined) ?? ''
const align = (props.data.align as string | undefined) ?? 'left'
const image = props.data.image as string | undefined
const layout = (props.data.layout as string | undefined) ?? 'full'
const { assetUrl } = useAssetUrl()
</script>

<template>
  <section class="py-20">
    <div class="container mx-auto px-4">
      <div :class="layout === 'split' && image ? 'grid md:grid-cols-2 items-center gap-12' : 'max-w-4xl mx-auto'">
        <div :class="align === 'center' ? 'text-center' : ''">
          <h2 v-if="heading" class="text-3xl font-bold text-heading mb-6">{{ heading }}</h2>
          <!-- eslint-disable-next-line vue/no-v-html -->
          <div class="prose max-w-none text-body leading-relaxed [&_a]:text-primary [&_h2]:text-heading [&_h3]:text-heading" v-html="body" />
        </div>
        <img v-if="image && layout === 'split'" :src="assetUrl(image)" alt="" class="rounded-2xl w-full object-cover shadow-xl" />
      </div>
    </div>
  </section>
</template>
