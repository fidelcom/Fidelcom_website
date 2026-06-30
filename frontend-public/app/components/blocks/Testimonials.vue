<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

interface Testimonial { id: number; name: string; subtitle: string; location: string | null; desc: string; image: string | null; rating: number | null }

const heading = (props.data.heading as string | undefined) ?? 'What Our Clients Say'
const limit = (props.data.limit as number | undefined) ?? 6
const api = useApi()

const { data: testimonials } = await useAsyncData('testimonials-block', async () => {
  const res = await api.get<{ data: Testimonial[] }>('/testimonials', { limit })
  return res.data
})

const current = ref(0)
const count = computed(() => testimonials.value?.length ?? 0)
function prev() { current.value = (current.value - 1 + count.value) % count.value }
function next() { current.value = (current.value + 1) % count.value }
</script>

<template>
  <section class="py-20 bg-surface">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold text-heading text-center mb-12">{{ heading }}</h2>

      <div v-if="!testimonials?.length" class="text-center text-body">No testimonials yet.</div>

      <div v-else class="max-w-3xl mx-auto">
        <Transition name="fade" mode="out-in">
          <div :key="current" class="bg-bg rounded-2xl p-8 border border-border">
            <div class="flex gap-1 mb-4">
              <Icon
                v-for="i in 5"
                :key="i"
                name="i-heroicons-star-solid"
                :class="['w-4 h-4', (testimonials[current].rating ?? 5) >= i ? 'text-yellow-400' : 'text-border']"
              />
            </div>
            <p class="text-body text-lg leading-relaxed mb-6 italic">"{{ testimonials[current].desc }}"</p>
            <div class="flex items-center gap-4">
              <img v-if="testimonials[current].image" :src="testimonials[current].image!" :alt="testimonials[current].name" class="w-12 h-12 rounded-full object-cover" />
              <div v-else class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold">
                {{ testimonials[current].name.charAt(0) }}
              </div>
              <div>
                <p class="text-heading font-semibold">{{ testimonials[current].name }}</p>
                <p class="text-body text-sm">{{ testimonials[current].subtitle }}<span v-if="testimonials[current].location">, {{ testimonials[current].location }}</span></p>
              </div>
            </div>
          </div>
        </Transition>

        <div class="flex items-center justify-center gap-4 mt-6">
          <button class="w-9 h-9 rounded-full border border-border flex items-center justify-center text-body hover:border-primary hover:text-primary transition-colors" @click="prev">
            <Icon name="i-heroicons-chevron-left" class="w-4 h-4" />
          </button>
          <div class="flex gap-2">
            <button v-for="(_, i) in testimonials" :key="i" :class="['w-2 h-2 rounded-full transition-all', i === current ? 'w-5 bg-primary' : 'bg-border']" @click="current = i" />
          </div>
          <button class="w-9 h-9 rounded-full border border-border flex items-center justify-center text-body hover:border-primary hover:text-primary transition-colors" @click="next">
            <Icon name="i-heroicons-chevron-right" class="w-4 h-4" />
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.3s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
