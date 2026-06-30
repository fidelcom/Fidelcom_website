<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

interface Slide { id: number; title: string; project: string; description: string; image: string }

const api = useApi()
const { data: sliders } = await useAsyncData('sliders', async () => {
  const res = await api.get<{ data: Slide[] }>('/sliders')
  return res.data
})

const current = ref(0)
const autoplay = props.data.autoplay !== false
const speed = (props.data.autoplay_speed as number) ?? 5000
const slide = computed(() => sliders.value?.[current.value])

let timer: ReturnType<typeof setInterval> | null = null
function next() { current.value = (current.value + 1) % (sliders.value?.length ?? 1) }
function prev() { current.value = (current.value - 1 + (sliders.value?.length ?? 1)) % (sliders.value?.length ?? 1) }

onMounted(() => { if (autoplay && sliders.value?.length) timer = setInterval(next, speed) })
onUnmounted(() => { if (timer) clearInterval(timer) })
</script>

<template>
  <section class="relative overflow-hidden bg-bg min-h-[70vh] flex items-center">
    <div v-if="!sliders?.length" class="container mx-auto px-4 py-32 text-center text-body">
      <slot />
    </div>

    <template v-else>
      <Transition name="fade" mode="out-in">
        <div :key="current" class="absolute inset-0">
          <img :src="slide?.image" :alt="slide?.title" class="w-full h-full object-cover opacity-40" />
          <div class="absolute inset-0 bg-gradient-to-r from-bg via-bg/60 to-transparent" />
        </div>
      </Transition>

      <div class="relative container mx-auto px-4 py-24">
        <Transition name="slide-up" mode="out-in">
          <div :key="current" class="max-w-2xl">
            <p v-if="slide?.project" class="text-primary text-sm font-semibold uppercase tracking-widest mb-3">{{ slide?.project }}</p>
            <h1 class="text-4xl md:text-6xl font-bold text-heading leading-tight mb-6">{{ slide?.title }}</h1>
            <p class="text-body text-lg mb-8 leading-relaxed">{{ slide?.description }}</p>
            <div class="flex gap-4">
              <NuxtLink to="/contact-us" class="bg-primary text-white px-6 py-3 rounded-xl font-medium hover:bg-primary-alt transition-colors">Request a Quote</NuxtLink>
              <NuxtLink to="/portfolio" class="border border-border text-heading px-6 py-3 rounded-xl font-medium hover:border-primary transition-colors">View Portfolio</NuxtLink>
            </div>
          </div>
        </Transition>
      </div>

      <button class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-surface/60 hover:bg-surface rounded-full flex items-center justify-center text-heading transition-colors" @click="prev">
        <Icon name="i-heroicons-chevron-left" class="w-5 h-5" />
      </button>
      <button class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-surface/60 hover:bg-surface rounded-full flex items-center justify-center text-heading transition-colors" @click="next">
        <Icon name="i-heroicons-chevron-right" class="w-5 h-5" />
      </button>

      <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2">
        <button
          v-for="(_, i) in sliders"
          :key="i"
          :class="['w-2 h-2 rounded-full transition-all', i === current ? 'w-6 bg-primary' : 'bg-body/40']"
          @click="current = i"
        />
      </div>
    </template>
  </section>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.6s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
.slide-up-enter-active, .slide-up-leave-active { transition: all 0.5s ease; }
.slide-up-enter-from { opacity: 0; transform: translateY(24px); }
.slide-up-leave-to { opacity: 0; transform: translateY(-12px); }
</style>
