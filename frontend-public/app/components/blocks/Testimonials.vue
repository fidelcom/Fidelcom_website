<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

interface Testimonial { id: number; name: string; subtitle: string; location: string | null; desc: string; image: string | null; rating: number | null }

const heading = (props.data.heading as string | undefined) ?? 'What Our Clients Say'
const limit = (props.data.limit as number | undefined) ?? 6
const api = useApi()
const { assetUrl } = useAssetUrl()

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
  <section class="py-24 bg-bg border-t border-border">
    <div class="w-full max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16">

      <div class="text-center mb-16">
        <p class="text-primary text-xs font-semibold uppercase tracking-[0.16em] mb-5">Client Stories</p>
        <h2
          class="text-white font-black leading-[0.9] tracking-[-0.04em]"
          style="font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 5rem); text-wrap: balance;"
        >{{ heading }}</h2>
      </div>

      <div v-if="!testimonials?.length" class="text-center text-body py-12">No testimonials yet.</div>

      <div v-else class="max-w-2xl mx-auto">
        <div aria-live="polite" aria-atomic="true" aria-label="Client testimonials">
        <Transition name="fade" mode="out-in">
          <div :key="current" class="border border-border bg-surface p-10 md:p-12">
            <!-- Stars -->
            <div class="flex gap-1 mb-8">
              <Icon
                v-for="i in 5"
                :key="i"
                name="i-heroicons-star-solid"
                :class="['w-4 h-4', (testimonials[current].rating ?? 5) >= i ? 'text-amber-400' : 'text-border']"
              />
            </div>
            <p class="text-white text-xl leading-relaxed mb-10 font-medium">
              "{{ testimonials[current].desc }}"
            </p>
            <div class="flex items-center gap-4 border-t border-border pt-8">
              <img
                v-if="testimonials[current].image"
                :src="assetUrl(testimonials[current].image)"
                :alt="testimonials[current].name"
                class="w-12 h-12 object-cover flex-shrink-0"
              />
              <div v-else class="w-12 h-12 bg-primary/15 flex items-center justify-center text-primary font-bold text-sm flex-shrink-0">
                {{ testimonials[current].name.charAt(0) }}
              </div>
              <div>
                <p class="text-white font-semibold text-sm">{{ testimonials[current].name }}</p>
                <p class="text-body text-xs mt-1">
                  {{ testimonials[current].subtitle }}<span v-if="testimonials[current].location">, {{ testimonials[current].location }}</span>
                </p>
              </div>
            </div>
          </div>
        </Transition>
        </div>

        <div class="flex items-center justify-between mt-6">
          <button
            aria-label="Previous testimonial"
            class="w-10 h-10 border border-border flex items-center justify-center text-body hover:border-primary/50 hover:text-white transition-all"
            @click="prev"
          >
            <Icon name="i-heroicons-chevron-left" class="w-4 h-4" aria-hidden="true" />
          </button>
          <nav aria-label="Testimonial pagination" class="flex gap-1.5">
            <button
              v-for="(_, i) in testimonials"
              :key="i"
              :aria-label="`Go to testimonial ${i + 1}`"
              :aria-current="i === current ? 'true' : undefined"
              :class="['h-0.5 transition-all duration-250', i === current ? 'w-8 bg-primary' : 'w-2 bg-border']"
              @click="current = i"
            />
          </nav>
          <button
            aria-label="Next testimonial"
            class="w-10 h-10 border border-border flex items-center justify-center text-body hover:border-primary/50 hover:text-white transition-all"
            @click="next"
          >
            <Icon name="i-heroicons-chevron-right" class="w-4 h-4" aria-hidden="true" />
          </button>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
