<script setup lang="ts">
interface Post { id: number; title: string; slug: string; excerpt: string; image: string | null; category: string | null; published_at: string }

const api = useApi()
const page = ref(1)
const search = ref('')
const category = ref('')

const { data, refresh } = await useAsyncData('blog', async () => {
  const res = await api.get<{ data: Post[]; meta: { total: number; last_page: number; current_page: number } }>('/posts', { page: page.value, search: search.value || undefined, category: category.value || undefined })
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
    <section class="py-16 bg-surface border-b border-border">
      <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-heading mb-3">Blog</h1>
        <p class="text-body">Latest insights, tutorials, and updates from Fidelcom.</p>
        <div class="flex gap-3 mt-6">
          <input v-model="search" type="search" placeholder="Search posts…" class="bg-bg border border-border rounded-xl px-4 py-2 text-heading placeholder-body/50 focus:outline-none focus:border-primary transition-colors w-64" @input="page = 1" />
        </div>
      </div>
    </section>

    <section class="py-16">
      <div class="container mx-auto px-4">
        <div v-if="!data?.data.length" class="text-center py-20 text-body">No posts found.</div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <NuxtLink
            v-for="post in data?.data"
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
              <h2 class="text-heading font-semibold mb-2 group-hover:text-primary transition-colors line-clamp-2">{{ post.title }}</h2>
              <p class="text-body text-sm line-clamp-3">{{ post.excerpt }}</p>
            </div>
          </NuxtLink>
        </div>

        <!-- Pagination -->
        <div v-if="(data?.meta.last_page ?? 1) > 1" class="flex items-center justify-center gap-3 mt-12">
          <button :disabled="page <= 1" class="px-4 py-2 border border-border rounded-xl text-body hover:border-primary disabled:opacity-40 transition-colors" @click="page--">Previous</button>
          <span class="text-body text-sm">Page {{ data?.meta.current_page }} of {{ data?.meta.last_page }}</span>
          <button :disabled="page >= (data?.meta.last_page ?? 1)" class="px-4 py-2 border border-border rounded-xl text-body hover:border-primary disabled:opacity-40 transition-colors" @click="page++">Next</button>
        </div>
      </div>
    </section>
  </div>
</template>
