<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

interface Project { id: number; title: string; slug: string; excerpt: string; image: string | null; category: string | null }

const limit = (props.data.limit as number | undefined) ?? 5
const api = useApi()
const { assetUrl } = useAssetUrl()

const { data: projects } = await useAsyncData('case-study-block', async () => {
  const res = await api.get<{ data: Project[] }>('/projects', { limit })
  return res.data
})

const current = ref(0)
const total = computed(() => projects.value?.length ?? 0)
const project = computed(() => projects.value?.[current.value])

function next() { current.value = (current.value + 1) % total.value }
function prev() { current.value = (current.value - 1 + total.value) % total.value }
</script>

<template>
  <section v-if="project" class="bg-black border-t border-[#1a1a1a] overflow-hidden">
    <Transition name="case-fade" mode="out-in">
      <div :key="current" class="flex flex-col lg:flex-row" style="min-height: 560px;">

        <!-- ① LEFT — image, full height, no padding, edge-to-edge -->
        <div class="relative w-full lg:w-[48%] bg-[#111] overflow-hidden" style="min-height: 340px;">
          <img
            v-if="project.image"
            :src="assetUrl(project.image)"
            :alt="project.title"
            class="absolute inset-0 w-full h-full object-cover"
          />
          <div v-else class="absolute inset-0 flex items-center justify-center">
            <Icon name="i-heroicons-squares-2x2" class="w-20 h-20 text-white/5" />
          </div>
        </div>

        <!-- ② RIGHT — text content -->
        <div class="flex-1 flex flex-col justify-center bg-black px-10 md:px-16 xl:px-20 py-16">

          <!-- CASE STUDY label — EPAM cyan style (we use primary) -->
          <p class="text-primary text-[10px] font-bold uppercase tracking-[0.35em] mb-8">
            Case Study
          </p>

          <!-- Category tags -->
          <p v-if="project.category" class="text-white/35 text-[10px] uppercase tracking-[0.18em] leading-loose mb-7">
            {{ project.category }}
          </p>

          <!-- Title — large, bold, underlined like EPAM -->
          <h2
            class="text-white font-bold leading-[1.1] mb-10"
            style="
              font-size: clamp(1.6rem, 3vw, 2.8rem);
              font-family: var(--font-display);
              text-decoration: underline;
              text-decoration-color: rgba(255,255,255,0.18);
              text-underline-offset: 6px;
              text-decoration-thickness: 2px;
            "
          >{{ project.title }}</h2>

          <!-- Read More + arrow (EPAM puts these on separate lines) -->
          <NuxtLink :to="`/portfolio/${project.slug}`" class="group inline-flex flex-col gap-4 w-fit">
            <span
              class="text-primary font-bold text-sm tracking-wide"
              style="text-decoration: underline; text-decoration-color: rgba(82,55,249,0.5); text-underline-offset: 4px;"
            >Read More</span>
            <Icon name="i-heroicons-arrow-right" class="w-5 h-5 text-primary group-hover:translate-x-1 transition-transform duration-200" />
          </NuxtLink>

          <!-- Prev / Next navigation -->
          <div v-if="total > 1" class="flex items-center gap-4 mt-14">
            <button
              class="w-9 h-9 rounded-full border border-white/15 flex items-center justify-center text-white/35 hover:border-white/50 hover:text-white transition-all duration-200"
              aria-label="Previous case study"
              @click="prev"
            >
              <Icon name="i-heroicons-arrow-left" class="w-4 h-4" />
            </button>
            <button
              class="w-9 h-9 rounded-full border border-white/15 flex items-center justify-center text-white/35 hover:border-white/50 hover:text-white transition-all duration-200"
              aria-label="Next case study"
              @click="next"
            >
              <Icon name="i-heroicons-arrow-right" class="w-4 h-4" />
            </button>
            <span class="text-white/20 text-xs tabular-nums tracking-widest ml-1">
              {{ String(current + 1).padStart(2, '0') }} / {{ String(total).padStart(2, '0') }}
            </span>
          </div>
        </div>

      </div>
    </Transition>
  </section>
</template>

<style scoped>
.case-fade-enter-active, .case-fade-leave-active { transition: opacity 0.4s ease; }
.case-fade-enter-from, .case-fade-leave-to { opacity: 0; }
</style>
