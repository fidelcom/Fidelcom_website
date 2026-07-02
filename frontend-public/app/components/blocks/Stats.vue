<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

const heading = props.data.heading as string | undefined

interface Stat { label: string; value: string }
const stats: Stat[] = (props.data.items as Stat[] | undefined) ?? [
  { label: 'Projects Delivered', value: '200+' },
  { label: 'Happy Clients', value: '150+' },
  { label: 'Years Experience', value: '10+' },
  { label: 'Countries Served', value: '5+' },
]

// Scroll-driven expand animation — section stays sticky while numbers grow
const wrapperRef = ref<HTMLElement | null>(null)
const { y: scrollY } = useWindowScroll()
const wrapperTop = ref(0)

onMounted(() => {
  nextTick(() => {
    wrapperTop.value = wrapperRef.value?.offsetTop ?? 0
  })
})

// progress: 0 when section pins at top, 1 when scrolled 1 viewport through
const progress = computed(() => {
  const vh = typeof window !== 'undefined' ? window.innerHeight : 800
  const scrolledPast = scrollY.value - wrapperTop.value
  return Math.max(0, Math.min(1, scrolledPast / vh))
})

// Font size: 2rem → 7rem as progress 0 → 1
const numFontSize = computed(() => {
  const min = 2; const max = 7
  return `${(min + (max - min) * easeOut(progress.value)).toFixed(3)}rem`
})

// Opacity: numbers fade in as they grow (start at 0.4, reach 1 at progress 0.5)
const numOpacity = computed(() => Math.min(1, 0.4 + progress.value * 1.2))

// Label opacity: appears after progress > 0.5
const labelOpacity = computed(() => Math.max(0, (progress.value - 0.4) / 0.6))

function easeOut(t: number): number {
  return 1 - Math.pow(1 - t, 3)
}
</script>

<template>
  <!-- Sticky scroll wrapper: 220vh gives 1vh of pin + 1vh animation room + 20vh pause at full size -->
  <div ref="wrapperRef" class="relative border-t border-[#1a1a1a]" style="height: 220vh;">

    <!-- Sticky panel — stays at top of viewport while scrolling through wrapper -->
    <div class="sticky top-0 h-screen bg-black flex flex-col justify-center overflow-hidden">
      <div class="w-full max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16">

        <p v-if="heading" class="text-white/25 text-xs font-semibold uppercase tracking-[0.2em] mb-14">{{ heading }}</p>

        <div class="grid grid-cols-2 md:grid-cols-4">
          <div
            v-for="(stat, i) in stats"
            :key="stat.label"
            :class="[
              'py-8',
              i < stats.length - 1 ? 'pr-6 md:pr-10 border-r border-[#1e1e1e]' : '',
              i > 0 ? 'pl-6 md:pl-10' : '',
            ]"
          >
            <!-- Gradient rule above number — EPAM signature -->
            <div
              class="w-full h-px mb-8"
              style="background: linear-gradient(to right, rgba(0,212,255,0.5), rgba(82,55,249,0.5));"
            />

            <!-- Expanding gradient number -->
            <p
              class="font-black leading-none tabular-nums mb-5"
              :style="{
                fontFamily: 'var(--font-display)',
                fontSize: numFontSize,
                opacity: numOpacity,
                background: 'linear-gradient(135deg, #00d4ff 0%, #5237f9 100%)',
                WebkitBackgroundClip: 'text',
                WebkitTextFillColor: 'transparent',
                backgroundClip: 'text',
                transition: 'none',
              }"
            >{{ stat.value }}</p>

            <!-- Label fades in as numbers reach full size -->
            <p
              class="text-white font-light leading-snug"
              style="font-size: 0.9rem;"
              :style="{ opacity: labelOpacity }"
            >{{ stat.label }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
