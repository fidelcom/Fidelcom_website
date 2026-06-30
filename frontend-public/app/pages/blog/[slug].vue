<script setup lang="ts">
const route = useRoute()
const api = useApi()

const { data: post, error } = await useAsyncData(`post-${route.params.slug}`, async () => {
  const res = await api.get<{ data: { id: number; title: string; slug: string; body: string; excerpt: string; image: string | null; category: string | null; published_at: string; meta_title: string | null; meta_description: string | null } }>(`/posts/${route.params.slug}`)
  return res.data
})

if (error.value) throw createError({ statusCode: 404, message: 'Post not found' })

useSeoMeta({
  title: post.value?.meta_title ?? post.value?.title ?? 'Blog Post',
  description: post.value?.meta_description ?? post.value?.excerpt ?? '',
  ogTitle: post.value?.meta_title ?? post.value?.title,
  ogDescription: post.value?.meta_description ?? post.value?.excerpt,
  ogImage: post.value?.image ?? undefined,
})

function formatDate(d: string) {
  return new Date(d).toLocaleDateString('en-NG', { year: 'numeric', month: 'long', day: 'numeric' })
}
</script>

<template>
  <div>
    <article class="py-16">
      <div class="container mx-auto px-4 max-w-3xl">
        <NuxtLink to="/blog" class="text-primary text-sm hover:underline mb-6 inline-flex items-center gap-1">
          <Icon name="i-heroicons-arrow-left" class="w-4 h-4" /> Blog
        </NuxtLink>

        <div v-if="post">
          <div class="flex items-center gap-3 mb-4 text-sm text-body">
            <span v-if="post.category" class="text-primary font-medium">{{ post.category }}</span>
            <span>{{ formatDate(post.published_at) }}</span>
          </div>
          <h1 class="text-4xl font-bold text-heading leading-tight mb-6">{{ post.title }}</h1>
          <img v-if="post.image" :src="post.image" :alt="post.title" class="w-full rounded-2xl mb-8 object-cover max-h-96" />
          <!-- eslint-disable-next-line vue/no-v-html -->
          <div class="prose max-w-none text-body [&_a]:text-primary [&_h2]:text-heading [&_h3]:text-heading [&_img]:rounded-xl leading-relaxed" v-html="post.body" />
        </div>
      </div>
    </article>
  </div>
</template>
