<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })

const api = useApi()
const { items, loading, saving, error, meta, page, search, load, create, update, remove } = useCrud<{
  id: number; title: string; slug: string; author: string; blog_category?: { name: string }; created_at: string
}>('/api/v1/admin/posts')

const showModal = ref(false)
const editing = ref<null | { id: number; title: string; author: string; short_desc: string; long_desc: string; blog_category_id: number; meta_title?: string; meta_description?: string }>(null)
const categories = ref<{ id: number; name: string }[]>([])
const form = reactive({ title: '', author: '', blog_category_id: 0, short_desc: '', long_desc: '', meta_title: '', meta_description: '' })
const imageFile = ref<File | null>(null)

async function openCreate() {
  Object.assign(form, { title: '', author: '', blog_category_id: categories.value[0]?.id ?? 0, short_desc: '', long_desc: '', meta_title: '', meta_description: '' })
  imageFile.value = null
  editing.value = null
  showModal.value = true
}

function openEdit(row: typeof editing.value) {
  editing.value = row
  Object.assign(form, row)
  imageFile.value = null
  showModal.value = true
}

async function save() {
  const fd = new FormData()
  Object.entries(form).forEach(([k, v]) => fd.append(k, String(v ?? '')))
  if (imageFile.value) fd.append('image', imageFile.value)

  const result = editing.value
    ? await update(editing.value.id, fd)
    : await create(fd)

  if (result) { showModal.value = false; load() }
}

async function deleteRow(id: number) {
  if (confirm('Delete this post?')) await remove(id)
}

onMounted(async () => {
  const res = await api.get<{ data: { id: number; name: string }[] }>('/api/v1/admin/posts') // will lazy-fill
  categories.value = await api.get<{ data: { id: number; name: string }[] }>('/api/v1/admin/blog-categories').then(r => r.data).catch(() => [])
  load()
})

const cols = [
  { key: 'title', label: 'Title' },
  { key: 'author', label: 'Author' },
  { key: 'category', label: 'Category' },
  { key: 'created_at', label: 'Date' },
]
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-heading">Blog Posts</h1>
      <button class="btn-primary" @click="openCreate">+ New Post</button>
    </div>

    <div class="mb-4">
      <input
        v-model="search"
        placeholder="Search posts…"
        class="input w-64"
      />
    </div>

    <div v-if="error" class="text-red-400 mb-4 text-sm">{{ error }}</div>

    <AppTable :cols="cols" :rows="items" :loading="loading">
      <template #category="{ row }">
        {{ (row as any).blog_category?.name ?? '—' }}
      </template>
      <template #created_at="{ row }">
        {{ new Date((row as any).created_at).toLocaleDateString() }}
      </template>
      <template #actions="{ row }">
        <button class="btn-ghost text-xs mr-2" @click="openEdit(row as any)">Edit</button>
        <button class="btn-ghost text-xs text-red-400" @click="deleteRow((row as any).id)">Delete</button>
      </template>
    </AppTable>

    <AppPagination :page="meta.current_page" :last-page="meta.last_page" :total="meta.total" @update:page="p => { page = p }" />

    <AppModal v-model:show="showModal" :title="editing ? 'Edit Post' : 'New Post'" max-width="max-w-2xl">
      <form class="p-6 space-y-4" @submit.prevent="save">
        <div>
          <label class="label">Title</label>
          <input v-model="form.title" class="input" required />
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="label">Author</label>
            <input v-model="form.author" class="input" required />
          </div>
          <div>
            <label class="label">Category</label>
            <select v-model="form.blog_category_id" class="input">
              <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
            </select>
          </div>
        </div>
        <div>
          <label class="label">Short Description</label>
          <textarea v-model="form.short_desc" class="input" rows="3" required />
        </div>
        <div>
          <label class="label">Full Content</label>
          <textarea v-model="form.long_desc" class="input" rows="6" required />
        </div>
        <div>
          <label class="label">Featured Image{{ editing ? ' (leave empty to keep current)' : '' }}</label>
          <input type="file" accept="image/*" class="input" @change="imageFile = ($event.target as HTMLInputElement).files?.[0] ?? null" />
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="label">Meta Title</label>
            <input v-model="form.meta_title" class="input" maxlength="100" />
          </div>
          <div>
            <label class="label">Meta Description</label>
            <input v-model="form.meta_description" class="input" maxlength="300" />
          </div>
        </div>
        <div v-if="error" class="text-red-400 text-sm">{{ error }}</div>
        <div class="flex justify-end gap-3 pt-2">
          <button type="button" class="btn-ghost" @click="showModal = false">Cancel</button>
          <button type="submit" class="btn-primary" :disabled="saving">
            {{ saving ? 'Saving…' : 'Save' }}
          </button>
        </div>
      </form>
    </AppModal>
  </div>
</template>
