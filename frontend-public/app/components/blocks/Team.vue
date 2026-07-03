<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

interface Member { id: number; name: string; role: string; image: string | null; twitter: string | null; linkedin: string | null }

const heading = (props.data.heading as string | undefined) ?? 'Our Team'
const limit = (props.data.limit as number | undefined) ?? 8
const api = useApi()
const { assetUrl } = useAssetUrl()

const { data: members } = await useAsyncData('team-block', async () => {
  const res = await api.get<{ data: Member[] }>('/team', { limit })
  return res.data
})
</script>

<template>
  <section class="py-24 bg-surface border-t border-border">
    <div class="w-full max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16">

      <div class="text-center mb-16">
        <p class="text-primary text-xs font-semibold uppercase tracking-[0.16em] mb-5">The People</p>
        <h2
          class="text-heading font-black leading-[0.9] tracking-[-0.04em]"
          style="font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 5rem); text-wrap: balance;"
        >{{ heading }}</h2>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
        <div v-for="member in members" :key="member.id" class="group">
          <!-- Square photo — EPAM style -->
          <div class="relative aspect-square overflow-hidden mb-4 bg-surface-alt">
            <img
              v-if="member.image"
              :src="assetUrl(member.image)"
              :alt="member.name"
              class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.05]"
            />
            <div v-else class="w-full h-full flex items-center justify-center text-primary text-3xl font-black" style="font-family: var(--font-display);">
              {{ member.name.charAt(0) }}
            </div>
            <div
              v-if="member.twitter || member.linkedin"
              class="absolute inset-0 bg-black/80 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center gap-5"
            >
              <a v-if="member.twitter" :href="member.twitter" target="_blank" rel="noopener noreferrer" class="text-white/60 hover:text-white transition-colors" @click.stop>
                <Icon name="i-simple-icons-x" class="w-4 h-4" />
              </a>
              <a v-if="member.linkedin" :href="member.linkedin" target="_blank" rel="noopener noreferrer" class="text-white/60 hover:text-white transition-colors" @click.stop>
                <Icon name="i-simple-icons-linkedin" class="w-4 h-4" />
              </a>
            </div>
          </div>
          <p class="text-heading font-semibold text-sm leading-tight">{{ member.name }}</p>
          <p class="text-primary text-xs font-medium mt-1">{{ member.role }}</p>
        </div>
      </div>

      <div class="text-center mt-14">
        <NuxtLink
          to="/our-teams"
          class="inline-flex items-center gap-2 border border-border text-body text-sm font-medium px-6 py-2.5 hover:border-primary/50 hover:text-heading transition-all"
        >
          Meet the Full Team <Icon name="i-heroicons-arrow-right" class="w-4 h-4" />
        </NuxtLink>
      </div>
    </div>
  </section>
</template>
