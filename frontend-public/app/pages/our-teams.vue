<script setup lang="ts">
interface Member { id: number; name: string; role: string; bio: string | null; image: string | null; twitter: string | null; linkedin: string | null; instagram: string | null; facebook: string | null }

const api = useApi()
const { data: members } = await useAsyncData('all-team', async () => {
  const res = await api.get<{ data: Member[] }>('/team')
  return res.data
})

useSeoMeta({ title: 'Our Team | Fidelcom Systems', description: 'Meet the talented professionals behind Fidelcom Systems Limited.' })
</script>

<template>
  <div>
    <section class="py-16 bg-surface border-b border-border">
      <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-heading mb-3">Our Team</h1>
        <p class="text-body">The people who make Fidelcom Systems tick.</p>
      </div>
    </section>

    <section class="py-16">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          <div v-for="member in members" :key="member.id" class="bg-surface rounded-2xl p-6 border border-border text-center group">
            <div class="relative w-24 h-24 rounded-2xl overflow-hidden mx-auto mb-4">
              <img v-if="member.image" :src="member.image" :alt="member.name" class="w-full h-full object-cover" />
              <div v-else class="w-full h-full bg-primary/10 flex items-center justify-center text-primary text-3xl font-bold">
                {{ member.name.charAt(0) }}
              </div>
            </div>
            <h2 class="text-heading font-semibold">{{ member.name }}</h2>
            <p class="text-body text-sm mt-1 mb-3">{{ member.role }}</p>
            <p v-if="member.bio" class="text-body text-xs leading-relaxed mb-4 line-clamp-3">{{ member.bio }}</p>
            <div class="flex justify-center gap-3">
              <a v-if="member.twitter" :href="member.twitter" target="_blank" rel="noopener" class="text-body hover:text-primary transition-colors">
                <Icon name="i-simple-icons-x" class="w-4 h-4" />
              </a>
              <a v-if="member.linkedin" :href="member.linkedin" target="_blank" rel="noopener" class="text-body hover:text-primary transition-colors">
                <Icon name="i-simple-icons-linkedin" class="w-4 h-4" />
              </a>
              <a v-if="member.instagram" :href="member.instagram" target="_blank" rel="noopener" class="text-body hover:text-primary transition-colors">
                <Icon name="i-simple-icons-instagram" class="w-4 h-4" />
              </a>
              <a v-if="member.facebook" :href="member.facebook" target="_blank" rel="noopener" class="text-body hover:text-primary transition-colors">
                <Icon name="i-simple-icons-facebook" class="w-4 h-4" />
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
