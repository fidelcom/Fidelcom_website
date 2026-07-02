<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

interface Post { id: number; title: string; slug: string; excerpt: string; image: string | null; category: string | null; published_at: string }

const heading = (props.data.heading as string | undefined) ?? 'Latest Insights'
const limit = (props.data.limit as number | undefined) ?? 3
const api = useApi()
const { assetUrl } = useAssetUrl()

const { data: posts } = await useAsyncData('blog-posts-block', async () => {
  const res = await api.get<{ data: Post[] }>('/posts', { limit })
  return res.data
})

function formatDate(d: string) {
  return new Date(d).toLocaleDateString('en-NG', { year: 'numeric', month: 'short', day: 'numeric' })
}
</script>

<template>
  <!-- Light section for blog/insights — EPAM uses contrast here -->
  <section class="py-24 bg-light-alt">
    <div class="w-full max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16">

      <div class="flex items-end justify-between mb-14 gap-6">
        <div>
          <p class="text-primary text-xs font-semibold uppercase tracking-[0.15em] mb-5">From the Blog</p>
          <h2
            class="text-heading-invert font-black leading-[0.9] tracking-[-0.04em]"
            style="font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 5rem); text-wrap: balance;"
          >{{ heading }}</h2>
        </div>
        <NuxtLink
          to="/blog"
          class="hidden sm:inline-flex items-center gap-2 text-sm text-body-invert hover:text-heading-invert transition-colors flex-shrink-0 group"
        >
          All articles
          <Icon name="i-heroicons-arrow-right" class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" />
        </NuxtLink>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <NuxtLink
          v-for="post in posts"
          :key="post.id"
          :to="`/blog/${post.slug}`"
          class="group flex flex-col bg-white border border-border-light overflow-hidden hover:shadow-xl hover:shadow-black/8 transition-all duration-300"
        >
          <!-- Image -->
          <div class="relative aspect-video overflow-hidden bg-[#e8e8e8] flex-shrink-0">
            <img
              v-if="post.image"
              :src="assetUrl(post.image)"
              :alt="post.title"
              class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.05]"
            />
            <div v-else class="w-full h-full bg-[#e8e8e8] flex items-center justify-center">
              <Icon name="i-heroicons-document-text" class="w-10 h-10 text-[#bbb]" />
            </div>
            <!-- Category badge -->
            <div v-if="post.category" class="absolute top-4 left-4">
              <span class="bg-primary text-white text-[10px] font-bold uppercase tracking-[0.12em] px-3 py-1">
                {{ post.category }}
              </span>
            </div>
          </div>

          <!-- Text -->
          <div class="p-6 flex flex-col flex-1">
            <time class="text-body-invert/60 text-[11px] mb-3 block">{{ formatDate(post.published_at) }}</time>
            <h3 class="text-heading-invert font-bold text-[16px] leading-snug mb-3 group-hover:text-primary transition-colors duration-150 line-clamp-2">
              {{ post.title }}
            </h3>
            <p class="text-body-invert text-sm leading-relaxed line-clamp-3 flex-1">{{ post.excerpt }}</p>
            <span class="mt-5 inline-flex items-center gap-2 text-primary text-xs font-bold uppercase tracking-[0.1em] group-hover:gap-3 transition-all duration-150">
              Read article <Icon name="i-heroicons-arrow-right" class="w-3.5 h-3.5" />
            </span>
          </div>
        </NuxtLink>
      </div>

    </div>
  </section>
</template>
