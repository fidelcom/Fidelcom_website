<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

interface Member { id: number; name: string; role: string; image: string | null; twitter: string | null; linkedin: string | null }

const heading = (props.data.heading as string | undefined) ?? 'Our Team'
const limit = (props.data.limit as number | undefined) ?? 8
const api = useApi()

const { data: members } = await useAsyncData('team-block', async () => {
  const res = await api.get<{ data: Member[] }>('/team', { limit })
  return res.data
})
</script>

<template>
  <section class="py-20 bg-surface">
    <div class="container mx-auto px-4">
      <h2 class="text-3xl font-bold text-heading text-center mb-12">{{ heading }}</h2>
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div v-for="member in members" :key="member.id" class="text-center group">
          <div class="relative mx-auto w-32 h-32 rounded-2xl overflow-hidden mb-4">
            <img v-if="member.image" :src="member.image" :alt="member.name" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
            <div v-else class="w-full h-full bg-primary/10 flex items-center justify-center text-primary text-3xl font-bold">
              {{ member.name.charAt(0) }}
            </div>
            <div class="absolute inset-0 bg-bg/80 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3">
              <a v-if="member.twitter" :href="member.twitter" target="_blank" rel="noopener" class="text-white hover:text-primary transition-colors" @click.stop>
                <Icon name="i-simple-icons-x" class="w-4 h-4" />
              </a>
              <a v-if="member.linkedin" :href="member.linkedin" target="_blank" rel="noopener" class="text-white hover:text-primary transition-colors" @click.stop>
                <Icon name="i-simple-icons-linkedin" class="w-4 h-4" />
              </a>
            </div>
          </div>
          <p class="text-heading font-semibold text-sm">{{ member.name }}</p>
          <p class="text-body text-xs mt-1">{{ member.role }}</p>
        </div>
      </div>
      <div class="text-center mt-10">
        <NuxtLink to="/our-teams" class="border border-border text-heading px-6 py-3 rounded-xl font-medium hover:border-primary transition-colors">Meet the Team</NuxtLink>
      </div>
    </div>
  </section>
</template>
