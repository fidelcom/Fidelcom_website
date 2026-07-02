<script setup lang="ts">
interface Post { id: number; title: string; slug: string; excerpt: string; image: string | null; category: string | null; published_at: string }

const api = useApi()
const { assetUrl } = useAssetUrl()
const page = ref(1)
const search = ref('')
const category = ref('')

const { data, refresh } = await useAsyncData('blog', async () => {
  const res = await api.get<{ data: Post[]; meta: { total: number; last_page: number; current_page: number } }>('/posts', {
    page: page.value,
    q: search.value || undefined,
    category: category.value || undefined,
  })
  return res
})

watch([page, search, category], () => refresh())

function formatDate(d: string) {
  return new Date(d).toLocaleDateString('en-NG', { year: 'numeric', month: 'short', day: 'numeric' })
}

useSeoMeta({ title: 'Blog | Fidelcom Systems', description: 'Latest insights, news, and tutorials from the Fidelcom team.' })
</script>

<template>
  <div>
    <!-- Page header -->
    <section class="pt-16 pb-20 bg-black border-b border-[#1a1a1a]">
      <div class="w-full max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16">
        <div class="flex items-center gap-4 mb-8">
          <div class="w-8 h-px bg-primary" />
          <span class="text-primary/80 text-xs font-semibold uppercase tracking-[0.2em]">Ideas &amp; Insights</span>
        </div>
        <h1
          class="text-white font-black leading-[0.88] tracking-[-0.04em] mb-5"
          style="font-family: var(--font-display); font-size: clamp(3rem, 7vw, 6.5rem);"
        >Blog</h1>
        <p class="text-white/40 text-lg max-w-xl leading-relaxed mb-10">Latest insights, tutorials, and technology updates from the Fidelcom team.</p>
        <div class="relative max-w-sm">
          <Icon name="i-heroicons-magnifying-glass" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-white/30" />
          <input
            v-model="search"
            type="search"
            placeholder="Search articles…"
            class="w-full bg-white/5 border border-[#2a2a2a] pl-11 pr-4 py-3 text-sm text-white placeholder:text-white/25 focus:outline-none focus:border-primary/40 transition-colors"
            @input="page = 1"
          />
        </div>
      </div>
    </section>

    <!-- Posts grid — light section like EPAM insights -->
    <section class="py-16 bg-light-alt">
      <div class="w-full max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16">
        <div v-if="!data?.data.length" class="text-center py-32">
          <Icon name="i-heroicons-document-text" class="w-10 h-10 text-[#ccc] mx-auto mb-3" />
          <p class="text-body-invert text-sm">{{ search ? 'No posts match your search.' : 'No posts yet.' }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
          <NuxtLink
            v-for="post in data?.data"
            :key="post.id"
            :to="`/blog/${post.slug}`"
            class="group flex flex-col bg-white border border-border-light overflow-hidden hover:shadow-xl hover:shadow-black/8 transition-all duration-300"
          >
            <div class="relative aspect-video overflow-hidden bg-[#e8e8e8] flex-shrink-0">
              <img
                v-if="post.image"
                :src="assetUrl(post.image)"
                :alt="post.title"
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.05]"
              />
              <div v-else class="w-full h-full flex items-center justify-center">
                <Icon name="i-heroicons-document-text" class="w-10 h-10 text-[#bbb]" />
              </div>
              <div v-if="post.category" class="absolute top-4 left-4">
                <span class="bg-primary text-white text-[10px] font-bold uppercase tracking-[0.12em] px-3 py-1">{{ post.category }}</span>
              </div>
            </div>
            <div class="p-6 flex flex-col flex-1">
              <time class="text-body-invert/50 text-[11px] mb-3 block">{{ formatDate(post.published_at) }}</time>
              <h2 class="text-heading-invert font-bold text-[16px] leading-snug mb-3 group-hover:text-primary transition-colors duration-150 line-clamp-2">{{ post.title }}</h2>
              <p class="text-body-invert text-sm leading-relaxed line-clamp-3 flex-1">{{ post.excerpt }}</p>
              <span class="mt-5 inline-flex items-center gap-2 text-primary text-xs font-bold uppercase tracking-[0.1em] group-hover:gap-3 transition-all duration-150">
                Read article <Icon name="i-heroicons-arrow-right" class="w-3.5 h-3.5" />
              </span>
            </div>
          </NuxtLink>
        </div>

        <div v-if="(data?.meta.last_page ?? 1) > 1" class="flex items-center justify-center gap-4 mt-14">
          <button
            :disabled="page <= 1"
            class="inline-flex items-center gap-2 px-5 py-2.5 border border-border-light text-body-invert text-sm hover:border-primary hover:text-primary disabled:opacity-30 transition-all"
            @click="page--"
          >
            <Icon name="i-heroicons-chevron-left" class="w-4 h-4" /> Previous
          </button>
          <span class="text-body-invert text-sm tabular-nums">{{ data?.meta.current_page }} / {{ data?.meta.last_page }}</span>
          <button
            :disabled="page >= (data?.meta.last_page ?? 1)"
            class="inline-flex items-center gap-2 px-5 py-2.5 border border-border-light text-body-invert text-sm hover:border-primary hover:text-primary disabled:opacity-30 transition-all"
            @click="page++"
          >
            Next <Icon name="i-heroicons-chevron-right" class="w-4 h-4" />
          </button>
        </div>
      </div>
    </section>
  </div>
</template>
