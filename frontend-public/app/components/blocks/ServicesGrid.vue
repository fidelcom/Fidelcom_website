<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

interface Service { id: number; title: string; slug: string; excerpt: string; image: string | null; icon: string | null }

const heading = (props.data.heading as string | undefined) ?? 'Our Services'
const limit = (props.data.limit as number | undefined) ?? 8
const api = useApi()
const { assetUrl } = useAssetUrl()

const { data: services } = await useAsyncData('services-block', async () => {
  const res = await api.get<{ data: Service[] }>('/services', { limit })
  return res.data
})

const LABELS = ['DIGITAL', 'CREATIVE', 'STRATEGY', 'ENGINEERING', 'DESIGN', 'TECHNOLOGY', 'CONSULTING', 'INNOVATION']

// Solid-color fallback bg for cards with no image
const SOLID_BG = ['bg-primary', 'bg-[#111]', 'bg-[#1a1a1a]', 'bg-[#0d0d0d]']
function solidBg(i: number) { return SOLID_BG[i % SOLID_BG.length] ?? 'bg-[#111]' }

// Label color varies: light on image cards, adapted for solid
function labelColor(hasImage: boolean, i: number) {
  if (hasImage) return 'text-white/50'
  return i % 4 === 0 ? 'text-white/50' : 'text-primary'
}
function titleColor(hasImage: boolean) { return hasImage ? 'text-white' : 'text-white' }
</script>

<template>
  <section class="py-24 bg-black border-t border-[#1a1a1a]">
    <div class="w-full max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16">

      <!-- Section header -->
      <div class="flex items-end justify-between mb-10 gap-6">
        <div>
          <p class="text-primary text-xs font-semibold uppercase tracking-[0.16em] mb-5">What We Do</p>
          <h2
            class="text-white font-black leading-[0.9] tracking-[-0.04em]"
            style="font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 5rem); text-wrap: balance;"
          >{{ heading }}</h2>
        </div>
        <NuxtLink
          to="/all-services"
          class="hidden sm:inline-flex items-center gap-2 text-white/40 hover:text-white text-sm transition-colors duration-200 flex-shrink-0 group"
        >
          All services
          <Icon name="i-heroicons-arrow-right" class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" />
        </NuxtLink>
      </div>

      <!-- Card grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-1">
        <NuxtLink
          v-for="(service, i) in services"
          :key="service.id"
          :to="`/all-services/${service.slug}`"
          class="group relative overflow-hidden"
          style="min-height: 460px;"
        >
          <!-- ─── IMAGE CARD: full-bleed cover + gradient + text overlay ─── -->
          <template v-if="service.image">
            <!-- Cover image -->
            <img
              :src="assetUrl(service.image)"
              :alt="service.title"
              class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.06]"
            />
            <!-- Scrim: dark at top for text, fades toward centre -->
            <div
              class="absolute inset-0"
              style="background: linear-gradient(to bottom, rgba(0,0,0,0.78) 0%, rgba(0,0,0,0.35) 45%, rgba(0,0,0,0.1) 100%);"
            />
            <!-- Text -->
            <div class="absolute top-0 left-0 right-0 p-7 z-10">
              <p :class="['text-[10px] font-semibold uppercase tracking-[0.22em] mb-5', labelColor(true, i)]">
                {{ LABELS[i % LABELS.length] }}
              </p>
              <h3 class="text-white font-bold leading-[1.15]" style="font-size: clamp(1.2rem, 2vw, 1.6rem);">
                {{ service.title }}
              </h3>
            </div>
          </template>

          <!-- ─── SOLID CARD: no image, brand/dark colour ─── -->
          <template v-else>
            <div :class="['absolute inset-0', solidBg(i)]" />
            <!-- Subtle grid pattern overlay -->
            <div class="absolute inset-0 opacity-[0.04]" style="background-image: repeating-linear-gradient(0deg, #fff 0px, #fff 1px, transparent 1px, transparent 40px), repeating-linear-gradient(90deg, #fff 0px, #fff 1px, transparent 1px, transparent 40px);" />
            <div class="absolute top-0 left-0 right-0 p-7 z-10">
              <p :class="['text-[10px] font-semibold uppercase tracking-[0.22em] mb-5', labelColor(false, i)]">
                {{ LABELS[i % LABELS.length] }}
              </p>
              <h3 class="text-white font-bold leading-[1.15]" style="font-size: clamp(1.2rem, 2vw, 1.6rem);">
                {{ service.title }}
              </h3>
              <!-- Icon at bottom for solid cards -->
              <div v-if="service.icon" class="mt-8">
                <div class="w-11 h-11 border border-white/10 flex items-center justify-center">
                  <Icon :name="service.icon" class="w-5 h-5 text-white/30" />
                </div>
              </div>
            </div>
          </template>

          <!-- ─── HOVER: description slides up from bottom ─── -->
          <div
            class="absolute inset-x-0 bottom-0 p-7 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-[cubic-bezier(0.16,1,0.3,1)] z-20"
            :class="i % 4 === 0 && !service.image ? 'bg-white/10' : 'bg-primary/95'"
          >
            <p class="text-white text-[13px] leading-relaxed line-clamp-4">{{ service.excerpt }}</p>
            <span class="mt-5 inline-flex items-center gap-2 text-white/65 text-[11px] font-semibold uppercase tracking-[0.14em]">
              Explore <Icon name="i-heroicons-arrow-right" class="w-3.5 h-3.5" />
            </span>
          </div>

          <!-- Top-right arrow (fades in on hover) -->
          <div class="absolute top-5 right-5 w-8 h-8 border border-white/20 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-30 text-white">
            <Icon name="i-heroicons-arrow-up-right" class="w-4 h-4" />
          </div>
        </NuxtLink>
      </div>

      <!-- Mobile CTA -->
      <div class="mt-8 sm:hidden">
        <NuxtLink
          to="/all-services"
          class="inline-flex items-center gap-2 border border-white/15 text-white/60 text-sm px-5 py-2.5 hover:border-primary/50 hover:text-white transition-all"
        >
          All services <Icon name="i-heroicons-arrow-right" class="w-4 h-4" />
        </NuxtLink>
      </div>
    </div>
  </section>
</template>
