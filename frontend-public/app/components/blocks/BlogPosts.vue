<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

interface Post { id: number; title: string; slug: string; excerpt: string; image: string | null; category: string | null; published_at: string }

const heading = (props.data.heading as string | undefined) ?? 'Latest Insights'
const limit = (props.data.limit as number | undefined) ?? 3
const api = useApi()

const { data: posts } = await useAsyncData('blog-posts-block', async () => {
  const res = await api.get<{ data: Post[] }>('/posts', { limit })
  return res.data
})

function formatDate(d: string) {
  return new Date(d).toLocaleDateString('en-NG', { year: 'numeric', month: 'short', day: 'numeric' })
}
</script>

<template>
  <section class="py-20">
    <div class="container mx-auto px-4">
      <div class="flex items-end justify-between mb-12">
        <h2 class="text-3xl font-bold text-heading">{{ heading }}</h2>
        <NuxtLink to="/blog" class="text-primary text-sm font-medium hover:underline">View all →</NuxtLink>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <NuxtLink
          v-for="post in posts"
          :key="post.id"
          :to="`/blog/${post.slug}`"
          class="group rounded-2xl overflow-hidden border border-border hover:border-primary transition-all hover:shadow-lg"
        >
          <div class="h-48 overflow-hidden">
            <img v-if="post.image" :src="post.image" :alt="post.title" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
            <div v-else class="w-full h-full bg-surface flex items-center justify-center">
              <Icon name="i-heroicons-document-text" class="w-12 h-12 text-body/30" />
            </div>
          </div>
          <div class="p-5">
            <div class="flex items-center gap-3 mb-2 text-xs text-body">
              <span v-if="post.category" class="text-primary font-medium">{{ post.category }}</span>
              <span>{{ formatDate(post.published_at) }}</span>
            </div>
            <h3 class="text-heading font-semibold mb-2 group-hover:text-primary transition-colors line-clamp-2">{{ post.title }}</h3>
            <p class="text-body text-sm line-clamp-3">{{ post.excerpt }}</p>
          </div>
        </NuxtLink>
      </div>
    </div>
  </section>
</template>
