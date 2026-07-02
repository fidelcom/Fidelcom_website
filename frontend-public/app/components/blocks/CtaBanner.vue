<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

const heading = (props.data.heading as string | undefined) ?? 'Ready to Start Your Project?'
const body = props.data.body as string | undefined
const buttonLabel = (props.data.button_label as string | undefined) ?? 'Contact Us'
const buttonUrl = (props.data.button_url as string | undefined) ?? '/contact-us'
const bgColor = (props.data.bg_color as string | undefined) ?? 'primary'

const hasVideo = bgColor !== 'surface'
const videoReady = ref(false)
</script>

<template>
  <section :class="['relative py-28 overflow-hidden', bgColor === 'surface' ? 'bg-surface' : 'bg-black']">

    <!-- Video background for non-surface variant -->
    <template v-if="hasVideo">
      <!-- Place /public/videos/cta-bg.mp4 for self-hosted. Free source: pexels.com, mixkit.co -->
      <video
        autoplay
        muted
        loop
        playsinline
        class="absolute inset-0 w-full h-full object-cover pointer-events-none"
        :class="videoReady ? 'opacity-20' : 'opacity-0'"
        style="transition: opacity 2s ease;"
        @canplaythrough="videoReady = true"
      >
        <source :src="'/videos/cta-bg.mp4'" type="video/mp4" />
        <source :src="'https://videos.pexels.com/video-files/2867604/2867604-hd_1920_1080_30fps.mp4'" type="video/mp4" />
      </video>
      <div class="absolute inset-0 pointer-events-none" style="background: linear-gradient(135deg, rgba(82,55,249,0.15) 0%, transparent 50%, rgba(82,55,249,0.08) 100%);" />
    </template>

    <div :class="['relative z-10 container mx-auto px-6 md:px-12 text-center max-w-3xl']">
      <h2
        :class="['font-black leading-[0.92] tracking-[-0.03em] mb-5', bgColor === 'surface' ? 'text-white' : 'text-white']"
        style="font-family: var(--font-display); font-size: clamp(2rem, 5vw, 3.5rem); text-wrap: balance;"
      >{{ heading }}</h2>
      <p v-if="body" :class="['text-lg mb-10 leading-relaxed max-w-xl mx-auto', bgColor === 'surface' ? 'text-body' : 'text-white/55']">{{ body }}</p>
      <NuxtLink
        :to="buttonUrl"
        :class="[
          'inline-flex items-center gap-3 px-9 py-4 font-bold text-sm transition-all duration-200',
          bgColor === 'surface'
            ? 'bg-primary text-white hover:bg-primary-alt'
            : 'bg-white text-black hover:bg-white/90',
        ]"
      >{{ buttonLabel }} <Icon name="i-heroicons-arrow-right" class="w-4 h-4" /></NuxtLink>
    </div>
  </section>
</template>
