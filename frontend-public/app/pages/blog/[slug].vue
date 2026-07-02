<script setup lang="ts">
const route = useRoute()
const api = useApi()
const { assetUrl } = useAssetUrl()

interface PostDetail {
  id: number
  title: string
  slug: string
  body: string
  excerpt: string
  image: string | null
  category: string | null
  category_slug: string | null
  published_at: string
  meta_title: string | null
  meta_description: string | null
  author: string | null
}

const { data: post, error } = await useAsyncData(`post-${route.params.slug}`, async () => {
  const res = await api.get<{ data: PostDetail }>(`/posts/${route.params.slug}`)
  return res.data
})

if (error.value) throw createError({ statusCode: 404, message: 'Post not found' })

const { data: related } = await useAsyncData(`related-${route.params.slug}`, async () => {
  if (!post.value) return []
  const res = await api.get<{ data: PostDetail[] }>(`/posts`, {
    params: { category: post.value.category_slug, limit: 3 },
  })
  return (res.data ?? []).filter((p: PostDetail) => p.slug !== route.params.slug).slice(0, 3)
})

const ogImageUrl = computed(() => post.value?.image ? assetUrl(post.value.image) : undefined)

useSeoMeta({
  title: post.value?.meta_title ?? post.value?.title ?? 'Blog Post',
  description: post.value?.meta_description ?? post.value?.excerpt ?? '',
  ogTitle: post.value?.meta_title ?? post.value?.title,
  ogDescription: post.value?.meta_description ?? post.value?.excerpt,
  ogType: 'article',
  ogImage: ogImageUrl.value,
  twitterCard: 'summary_large_image',
  twitterImage: ogImageUrl.value,
})

useHead({
  script: [{
    type: 'application/ld+json',
    innerHTML: JSON.stringify({
      '@context': 'https://schema.org',
      '@type': 'Article',
      headline: post.value?.title,
      description: post.value?.excerpt,
      image: ogImageUrl.value,
      datePublished: post.value?.published_at,
      author: { '@type': 'Person', name: post.value?.author ?? 'Fidelcom' },
      publisher: {
        '@type': 'Organization',
        name: 'Fidelcom Systems Limited',
        logo: { '@type': 'ImageObject', url: 'https://fidelcom.org/favicon.png' },
      },
    }),
  }],
})

function formatDate(d: string) {
  return new Date(d).toLocaleDateString('en-NG', { year: 'numeric', month: 'long', day: 'numeric' })
}

const shareUrl = computed(() => typeof window !== 'undefined' ? window.location.href : '')
const twitterShare = computed(() =>
  `https://twitter.com/intent/tweet?text=${encodeURIComponent(post.value?.title ?? '')}&url=${encodeURIComponent(shareUrl.value)}`
)
const linkedinShare = computed(() =>
  `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(shareUrl.value)}`
)
</script>

<template>
  <div>
    <Breadcrumbs :crumbs="[{ label: 'Blog', to: '/blog' }, { label: post?.title ?? 'Article' }]" />
    <article class="py-16">
      <div class="container mx-auto px-4 max-w-3xl">

        <div v-if="post">
          <div class="flex items-center gap-3 mb-4 text-sm text-body">
            <NuxtLink
              v-if="post.category && post.category_slug"
              :to="`/blog?category=${post.category_slug}`"
              class="text-primary font-medium hover:underline"
            >
              {{ post.category }}
            </NuxtLink>
            <span>{{ formatDate(post.published_at) }}</span>
            <span v-if="post.author" class="ml-auto">by {{ post.author }}</span>
          </div>

          <h1 class="text-4xl font-bold text-heading leading-tight mb-6">{{ post.title }}</h1>
          <img v-if="post.image" :src="assetUrl(post.image)" :alt="post.title" class="w-full rounded-2xl mb-8 object-cover max-h-96" />

          <!-- eslint-disable-next-line vue/no-v-html -->
          <div class="prose max-w-none text-body [&_a]:text-primary [&_h2]:text-heading [&_h3]:text-heading [&_img]:rounded-xl leading-relaxed" v-html="post.body" />

          <!-- Social Share -->
          <div class="mt-10 pt-8 border-t border-border flex items-center gap-4">
            <span class="text-sm text-body font-medium">Share:</span>
            <a
              :href="twitterShare"
              target="_blank"
              rel="noopener noreferrer"
              class="inline-flex items-center gap-2 text-sm text-body hover:text-primary transition-colors"
              aria-label="Share on X (Twitter)"
            >
              <Icon name="i-simple-icons-x" class="w-4 h-4" /> X
            </a>
            <a
              :href="linkedinShare"
              target="_blank"
              rel="noopener noreferrer"
              class="inline-flex items-center gap-2 text-sm text-body hover:text-primary transition-colors"
              aria-label="Share on LinkedIn"
            >
              <Icon name="i-simple-icons-linkedin" class="w-4 h-4" /> LinkedIn
            </a>
          </div>
        </div>
      </div>
    </article>

    <!-- Related Posts -->
    <section v-if="related && related.length" class="py-16 bg-surface border-t border-border">
      <div class="container mx-auto px-4 max-w-5xl">
        <h2 class="text-2xl font-bold text-heading mb-8">Related Articles</h2>
        <div class="grid md:grid-cols-3 gap-6">
          <NuxtLink
            v-for="rel in related"
            :key="rel.slug"
            :to="`/blog/${rel.slug}`"
            class="group bg-bg rounded-2xl overflow-hidden border border-border hover:border-primary transition-colors"
          >
            <img
              v-if="rel.image"
              :src="assetUrl(rel.image)"
              :alt="rel.title"
              class="w-full h-44 object-cover group-hover:opacity-90 transition-opacity"
            />
            <div class="p-4">
              <span v-if="rel.category" class="text-xs text-primary font-medium">{{ rel.category }}</span>
              <h3 class="text-heading font-semibold mt-1 leading-snug line-clamp-2">{{ rel.title }}</h3>
              <p class="text-xs text-body mt-2">{{ formatDate(rel.published_at) }}</p>
            </div>
          </NuxtLink>
        </div>
      </div>
    </section>
  </div>
</template>
