<script setup lang="ts">
interface Service { id: number; title: string; slug: string; excerpt: string; image: string | null; icon: string | null }

const api = useApi()
const { assetUrl } = useAssetUrl()
const { data: services } = await useAsyncData('all-services', async () => {
  const res = await api.get<{ data: Service[] }>('/services')
  return res.data
})

useSeoMeta({ title: 'Our Services | Fidelcom Systems', description: 'Full-stack software development, IT consulting, mobile apps, web development, and digital transformation services in Nigeria.' })
</script>

<template>
  <div>
    <!-- Page header -->
    <section class="pt-16 pb-20 bg-black border-b border-[#1a1a1a]">
      <div class="w-full max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16">
        <div class="flex items-center gap-4 mb-8">
          <div class="w-8 h-px bg-primary" />
          <span class="text-primary/80 text-xs font-semibold uppercase tracking-[0.2em]">What We Do</span>
        </div>
        <h1
          class="text-white font-black leading-[0.88] tracking-[-0.04em] mb-5"
          style="font-family: var(--font-display); font-size: clamp(3rem, 7vw, 6.5rem);"
        >Our Services</h1>
        <p class="text-white/40 text-lg max-w-xl leading-relaxed">From custom software development to IT infrastructure and digital strategy — we help businesses grow with technology.</p>
      </div>
    </section>

    <!-- Numbered list -->
    <section class="py-14 bg-bg">
      <div class="w-full max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16">
        <div>
          <NuxtLink
            v-for="(service, i) in services"
            :key="service.id"
            :to="`/all-services/${service.slug}`"
            class="group flex items-start gap-8 md:gap-14 py-8 border-t border-border last:border-b hover:bg-white/[0.02] transition-colors duration-150 -mx-6 md:-mx-12 xl:-mx-16 px-6 md:px-12 xl:px-16"
          >
            <span class="text-body/20 text-sm font-mono tabular-nums w-7 flex-shrink-0 pt-1.5 group-hover:text-primary/40 transition-colors">
              {{ String(i + 1).padStart(2, '0') }}
            </span>

            <div v-if="service.icon || service.image" class="flex-shrink-0 mt-0.5">
              <div v-if="service.icon" class="w-10 h-10 border border-border group-hover:border-primary/30 group-hover:bg-primary/5 flex items-center justify-center transition-all">
                <Icon :name="service.icon" class="w-5 h-5 text-body group-hover:text-primary transition-colors" />
              </div>
              <img v-else-if="service.image" :src="assetUrl(service.image)" :alt="service.title" class="w-10 h-10 object-cover" />
            </div>

            <div class="flex-1 min-w-0">
              <h2 class="text-white text-xl md:text-2xl font-bold mb-2.5 group-hover:text-primary transition-colors duration-150">{{ service.title }}</h2>
              <p class="text-body text-sm leading-relaxed line-clamp-2 max-w-2xl">{{ service.excerpt }}</p>
            </div>

            <Icon
              name="i-heroicons-arrow-up-right"
              class="w-5 h-5 text-border group-hover:text-primary group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-all flex-shrink-0 mt-1.5"
            />
          </NuxtLink>
        </div>
      </div>
    </section>
  </div>
</template>
