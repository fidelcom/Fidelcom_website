<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

interface Slide { id: number; title: string; project: string; description: string; image: string }

const api = useApi()
const { assetUrl } = useAssetUrl()

const { data: sliders } = await useAsyncData('sliders', async () => {
  const res = await api.get<{ data: Slide[] }>('/sliders')
  return res.data
})

const current = ref(0)
const autoplay = props.data.autoplay !== false
const speed = (props.data.autoplay_speed as number) ?? 6000
const slide = computed(() => sliders.value?.[current.value])

let slideTimer: ReturnType<typeof setInterval> | null = null
function next() { current.value = (current.value + 1) % (sliders.value?.length ?? 1) }
function prev() { current.value = (current.value - 1 + (sliders.value?.length ?? 1)) % (sliders.value?.length ?? 1) }

// Particle animation
const canvas = ref<HTMLCanvasElement | null>(null)
let animFrame = 0
let resizeHandler: (() => void) | null = null

interface Particle {
  x: number; y: number; r: number
  vx: number; vy: number
  opacity: number; opacityDir: number
  color: string
}

onMounted(() => {
  if (autoplay && sliders.value?.length) {
    slideTimer = setInterval(next, speed)
  }

  const c = canvas.value
  if (!c) return
  const ctx = c.getContext('2d')
  if (!ctx) return

  resizeHandler = () => { c.width = c.offsetWidth; c.height = c.offsetHeight }
  resizeHandler()
  window.addEventListener('resize', resizeHandler)

  const colors = ['200,210,255', '160,140,255', '100,180,255', '255,255,255']
  const particles: Particle[] = Array.from({ length: 90 }, () => ({
    x: Math.random() * c.width,
    y: Math.random() * c.height,
    r: Math.random() * 1.5 + 0.3,
    vx: (Math.random() - 0.5) * 0.25,
    vy: (Math.random() - 0.5) * 0.25,
    opacity: Math.random() * 0.5 + 0.05,
    opacityDir: Math.random() > 0.5 ? 1 : -1,
    color: colors[Math.floor(Math.random() * colors.length)] ?? '200,210,255',
  }))

  function draw() {
    ctx!.clearRect(0, 0, c!.width, c!.height)
    for (const p of particles) {
      p.x += p.vx
      p.y += p.vy
      p.opacity += p.opacityDir * 0.002
      if (p.opacity >= 0.65 || p.opacity <= 0.03) p.opacityDir *= -1
      if (p.x < 0) p.x = c!.width
      if (p.x > c!.width) p.x = 0
      if (p.y < 0) p.y = c!.height
      if (p.y > c!.height) p.y = 0

      const grd = ctx!.createRadialGradient(p.x, p.y, 0, p.x, p.y, p.r * 4)
      grd.addColorStop(0, `rgba(${p.color},${p.opacity})`)
      grd.addColorStop(1, `rgba(${p.color},0)`)
      ctx!.beginPath()
      ctx!.arc(p.x, p.y, p.r * 4, 0, Math.PI * 2)
      ctx!.fillStyle = grd
      ctx!.fill()
    }
    animFrame = requestAnimationFrame(draw)
  }
  draw()
})

onUnmounted(() => {
  if (slideTimer) clearInterval(slideTimer)
  if (resizeHandler) window.removeEventListener('resize', resizeHandler)
  cancelAnimationFrame(animFrame)
})
</script>

<template>
  <section class="relative h-screen -mt-[72px] flex flex-col justify-end overflow-hidden bg-black">

    <!-- Particle canvas -->
    <canvas ref="canvas" class="absolute inset-0 w-full h-full pointer-events-none" />

    <!-- Background image — very subtle, mostly black -->
    <Transition name="fade" mode="out-in">
      <div v-if="slide?.image" :key="current" class="absolute inset-0">
        <img
          :src="assetUrl(slide.image)"
          :alt="slide.title"
          class="w-full h-full object-cover"
          style="opacity: 0.12;"
        />
      </div>
    </Transition>

    <!-- Permanent overlay: top dark band protects header nav, bottom fade anchors text -->
    <div
      class="absolute inset-0 pointer-events-none"
      style="background: linear-gradient(to bottom, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.1) 35%, rgba(0,0,0,0.1) 55%, rgba(0,0,0,0.85) 100%);"
    />

    <!-- Content — bottom-left anchored, EPAM style -->
    <div class="relative z-10 w-full max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16 pb-20 md:pb-28">
      <Transition name="slide-up" mode="out-in">
        <div v-if="slide" :key="current" class="max-w-4xl">

          <!-- Eyebrow line + label -->
          <div v-if="slide.project" class="flex items-center gap-4 mb-8">
            <div class="w-8 h-px bg-primary" />
            <span class="text-white/50 text-[11px] font-semibold uppercase tracking-[0.22em]">{{ slide.project }}</span>
          </div>

          <!-- Headline — light weight, tight tracking -->
          <h1
            class="text-white leading-[0.93] tracking-[-0.02em] mb-6"
            style="font-size: clamp(2.2rem, 4.5vw, 4.5rem); font-family: var(--font-display); font-weight: 300;"
          >{{ slide.title }}</h1>

          <p class="text-white/40 leading-relaxed mb-10 max-w-lg" style="font-size: 1.1rem; font-weight: 300;">
            {{ slide.description }}
          </p>

          <div class="flex flex-wrap gap-4">
            <NuxtLink
              to="/request-quote"
              class="bg-primary text-white text-sm font-semibold px-8 py-3.5 hover:bg-primary-alt transition-colors tracking-wide"
            >Request a Quote</NuxtLink>
            <NuxtLink
              to="/portfolio"
              class="border border-white/20 text-white/80 text-sm font-medium px-8 py-3.5 hover:border-white/50 hover:text-white transition-all tracking-wide"
            >View Portfolio</NuxtLink>
          </div>
        </div>
      </Transition>
    </div>

    <!-- Bottom-right: EPAM-style counter + circle arrows -->
    <div v-if="sliders && sliders.length > 1" class="absolute bottom-8 right-6 md:right-12 xl:right-16 flex items-center gap-4 z-20">
      <span class="text-white/25 text-xs tabular-nums tracking-widest">
        {{ String(current + 1).padStart(2, '0') }} / {{ String(sliders.length).padStart(2, '0') }}
      </span>
      <button
        class="w-9 h-9 rounded-full border border-white/20 flex items-center justify-center text-white/40 hover:border-white/60 hover:text-white transition-all duration-200"
        aria-label="Previous slide"
        @click="prev"
      >
        <Icon name="i-heroicons-arrow-left" class="w-4 h-4" />
      </button>
      <button
        class="w-9 h-9 rounded-full border border-white/20 flex items-center justify-center text-white/40 hover:border-white/60 hover:text-white transition-all duration-200"
        aria-label="Next slide"
        @click="next"
      >
        <Icon name="i-heroicons-arrow-right" class="w-4 h-4" />
      </button>
    </div>

    <!-- Progress bar at absolute bottom -->
    <div class="absolute bottom-0 left-0 right-0 h-px bg-white/[0.06] z-20">
      <div
        class="h-full bg-primary transition-all duration-700 ease-out"
        :style="{ width: `${((current + 1) / (sliders?.length ?? 1)) * 100}%` }"
      />
    </div>
  </section>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 1s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
.slide-up-enter-active { transition: all 0.7s cubic-bezier(0.16, 1, 0.3, 1); }
.slide-up-leave-active { transition: all 0.4s ease; }
.slide-up-enter-from { opacity: 0; transform: translateY(40px); }
.slide-up-leave-to { opacity: 0; transform: translateY(-12px); }
</style>
