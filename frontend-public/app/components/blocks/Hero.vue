<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

const heading = (props.data.heading as string | undefined) ?? 'We Engineer Digital Excellence'
const subheading = props.data.subheading as string | undefined
const buttonLabel = (props.data.button_label as string | undefined) ?? 'Start a Project'
const buttonUrl = (props.data.button_url as string | undefined) ?? '/contact-us'
const secondaryLabel = props.data.secondary_label as string | undefined
const secondaryUrl = (props.data.secondary_url as string | undefined) ?? '/portfolio'
const { assetUrl } = useAssetUrl()

const videoReady = ref(false)
</script>

<template>
  <!--
    -mt-[72px] extends hero behind the fixed header for true full-viewport coverage.
    Place a free tech video at /public/videos/hero-bg.mp4
    Sources: pexels.com, mixkit.co, coverr.co — search "abstract technology dark"
  -->
  <section class="relative h-screen -mt-[72px] flex flex-col justify-end overflow-hidden bg-black">

    <!-- Pure black base; subtle brand glow at center (no animation — cleaner look) -->
    <div class="absolute inset-0" aria-hidden="true" style="background: radial-gradient(ellipse 80% 60% at 60% 40%, rgba(82,55,249,0.06) 0%, transparent 70%);" />

    <!-- Background video -->
    <!--
      Self-hosted (primary): /public/videos/hero-bg.mp4
      CDN fallback: Pexels abstract-tech video
    -->
    <video
      autoplay
      muted
      loop
      playsinline
      class="absolute inset-0 w-full h-full object-cover pointer-events-none"
      :class="videoReady ? 'opacity-40' : 'opacity-0'"
      style="transition: opacity 2s ease;"
      @canplaythrough="videoReady = true"
    >
      <source :src="'/videos/hero-bg.mp4'" type="video/mp4" />
      <source :src="'https://videos.pexels.com/video-files/3130284/3130284-hd_1920_1080_25fps.mp4'" type="video/mp4" />
    </video>

    <!-- Multi-stop overlay: opaque at bottom for text, transparent at top -->
    <div
      class="absolute inset-0 pointer-events-none"
      style="background: linear-gradient(to top, #000 0%, rgba(0,0,0,0.75) 35%, rgba(0,0,0,0.2) 70%, rgba(0,0,0,0.1) 100%);"
      aria-hidden="true"
    />

    <!-- Scroll indicator -->
    <div class="absolute right-8 bottom-24 hidden xl:flex flex-col items-center gap-3 pointer-events-none" aria-hidden="true">
      <div class="w-px h-16 bg-gradient-to-b from-white/15 to-transparent" />
      <span class="text-white/20 text-[9px] tracking-[0.32em] uppercase" style="writing-mode: vertical-rl;">Scroll</span>
    </div>

    <!-- Hero content — bottom-anchored, wide container -->
    <div class="relative z-10 w-full max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16 pb-20 md:pb-28">

      <!-- Eyebrow line (optional) -->
      <div class="flex items-center gap-4 mb-8">
        <div class="w-8 h-px bg-primary" />
        <span class="text-primary/80 text-xs font-semibold uppercase tracking-[0.2em]">IT Solutions &amp; Digital Consulting</span>
      </div>

      <h1
        class="text-white font-black leading-[0.88] tracking-[-0.04em] mb-8 max-w-5xl"
        style="font-family: var(--font-display); font-size: clamp(3rem, 8vw, 7.5rem); text-wrap: balance;"
      >
        {{ heading }}
      </h1>

      <p v-if="subheading" class="text-white/45 text-lg md:text-xl leading-relaxed mb-12 max-w-2xl">
        {{ subheading }}
      </p>

      <div class="flex flex-wrap items-center gap-4">
        <NuxtLink
          :to="buttonUrl"
          class="group inline-flex items-center gap-3 bg-primary text-white px-8 py-4 text-sm font-bold hover:bg-primary-alt transition-colors duration-200 tracking-wide"
        >
          {{ buttonLabel }}
          <Icon name="i-heroicons-arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-150" />
        </NuxtLink>
        <NuxtLink
          v-if="secondaryLabel"
          :to="secondaryUrl"
          class="inline-flex items-center gap-3 border border-white/20 text-white/80 px-8 py-4 text-sm font-semibold hover:border-white/50 hover:text-white hover:bg-white/5 transition-all duration-200"
        >
          {{ secondaryLabel }}
          <Icon name="i-heroicons-play" class="w-3.5 h-3.5" />
        </NuxtLink>
      </div>
    </div>

    <!-- Bottom border line -->
    <div class="absolute bottom-0 inset-x-0 h-px bg-white/5 pointer-events-none" />
  </section>
</template>
