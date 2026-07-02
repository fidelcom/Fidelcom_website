<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })

const api = useApi()
const { items, loading, saving, error, meta, page, search, load, create, update, remove } = useCrud<{
  id: number; title: string; slug: string; client: string; status: string; project_category?: { name: string }; published_at: string | null
}>('/admin/projects', 'Project')

const showModal = ref(false)
const editing = ref<null | any>(null)
const categories = ref<{ id: number; name: string }[]>([])
const form = reactive({
  title: '',
  project_category_id: 0,
  short_desc: '',
  long_desc: '',
  client: '',
  year: '',
  location: '',
  meta_title: '',
  meta_description: '',
  status: 'published' as 'draft' | 'published',
  published_at: '',
})
const imageFile = ref<File | null>(null)
const { resizeImage } = useImageResize()

const slugPreview = computed(() =>
  form.title
    .toLowerCase()
    .normalize('NFD')
    .replace(/[̀-ͯ]/g, '')
    .replace(/[^a-z0-9]+/g, '-')
    .replace(/(^-|-$)/g, '') || '—'
)

function metaTitleColor(len: number) {
  if (len === 0) return 'text-body'
  if (len <= 60) return 'text-green-500'
  if (len <= 100) return 'text-amber-500'
  return 'text-red-500'
}
function metaDescColor(len: number) {
  if (len === 0) return 'text-body'
  if (len <= 160) return 'text-green-500'
  if (len <= 300) return 'text-amber-500'
  return 'text-red-500'
}

function openCreate() {
  editing.value = null
  Object.assign(form, {
    title: '', project_category_id: categories.value[0]?.id ?? 0,
    short_desc: '', long_desc: '', client: '', year: '', location: '',
    meta_title: '', meta_description: '', status: 'published', published_at: '',
  })
  imageFile.value = null
  showModal.value = true
}

function openEdit(row: any) {
  editing.value = row
  Object.assign(form, {
    ...row,
    project_category_id: row.project_category?.id ?? 0,
    status: row.status ?? 'published',
    published_at: row.published_at ? row.published_at.slice(0, 16) : '',
  })
  imageFile.value = null
  showModal.value = true
}

async function save() {
  const fd = new FormData()
  Object.entries(form).forEach(([k, v]) => {
    if (v !== null && v !== undefined && v !== '') fd.append(k, String(v))
  })
  if (imageFile.value) fd.append('image', await resizeImage(imageFile.value, 1920, 1280))
  const r = editing.value ? await update(editing.value.slug, fd) : await create(fd)
  if (r) { showModal.value = false; load() }
}

onMounted(async () => {
  categories.value = await api.get<{ data: { id: number; name: string }[] }>('/admin/project-categories').then(r => r.data).catch(() => [])
  load()
})
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-heading">Projects</h1>
      <button class="btn-primary" @click="openCreate">+ New Project</button>
    </div>

    <div class="mb-4">
      <input v-model="search" placeholder="Search…" class="input w-64" />
    </div>

    <AppTable
      :cols="[
        { key: 'title',    label: 'Title' },
        { key: 'category', label: 'Category' },
        { key: 'client',   label: 'Client' },
        { key: 'status',   label: 'Status' },
      ]"
      :rows="items"
      :loading="loading"
    >
      <template #category="{ row }">{{ (row as any).project_category?.name ?? '—' }}</template>
      <template #status="{ row }">
        <span :class="(row as any).status === 'published' ? 'text-green-400' : 'text-amber-400'" class="text-xs font-medium capitalize">
          {{ (row as any).status ?? 'published' }}
        </span>
      </template>
      <template #actions="{ row }">
        <button class="btn-ghost text-xs mr-2" @click="openEdit(row)">Edit</button>
        <button class="btn-danger text-xs" @click="confirm('Delete?') && remove((row as any).slug)">Delete</button>
      </template>
    </AppTable>

    <AppPagination :page="meta.current_page" :last-page="meta.last_page" :total="meta.total" @update:page="p => { page = p }" />

    <AppModal v-model:show="showModal" :title="editing ? 'Edit Project' : 'New Project'" max-width="max-w-2xl">
      <form class="p-6 space-y-4" @submit.prevent="save">
        <div>
          <label class="label">Title</label>
          <input v-model="form.title" class="input" required />
          <p class="text-[11px] text-body/40 mt-1">Slug: <span class="font-mono">{{ slugPreview }}</span></p>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="label">Category</label>
            <select v-model="form.project_category_id" class="input">
              <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
            </select>
          </div>
          <div>
            <label class="label">Client</label>
            <input v-model="form.client" class="input" />
          </div>
          <div>
            <label class="label">Year</label>
            <input v-model="form.year" class="input" type="number" />
          </div>
          <div>
            <label class="label">Location</label>
            <input v-model="form.location" class="input" />
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="label">Status</label>
            <select v-model="form.status" class="input">
              <option value="published">Published</option>
              <option value="draft">Draft</option>
            </select>
          </div>
          <div>
            <label class="label">Publish Date</label>
            <input v-model="form.published_at" type="datetime-local" class="input" :disabled="form.status === 'draft'" />
          </div>
        </div>

        <div>
          <label class="label">Short Description</label>
          <textarea v-model="form.short_desc" class="input" rows="3" required />
        </div>
        <div>
          <label class="label">Full Description</label>
          <textarea v-model="form.long_desc" class="input" rows="5" required />
        </div>
        <div>
          <label class="label">Featured Image{{ editing ? ' (keep empty to retain)' : '' }}</label>
          <input type="file" accept="image/*" class="input" @change="imageFile = ($event.target as HTMLInputElement).files?.[0] ?? null" />
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <div class="flex items-center justify-between mb-1">
              <label class="label !mb-0">Meta Title</label>
              <span :class="['text-[11px] tabular-nums', metaTitleColor(form.meta_title.length)]">
                {{ form.meta_title.length }}/60
              </span>
            </div>
            <input v-model="form.meta_title" class="input" maxlength="100" />
          </div>
          <div>
            <div class="flex items-center justify-between mb-1">
              <label class="label !mb-0">Meta Description</label>
              <span :class="['text-[11px] tabular-nums', metaDescColor(form.meta_description.length)]">
                {{ form.meta_description.length }}/160
              </span>
            </div>
            <textarea v-model="form.meta_description" class="input" rows="2" maxlength="300" />
          </div>
        </div>

        <div v-if="error" class="text-red-400 text-sm">{{ error }}</div>
        <div class="flex justify-end gap-3">
          <button type="button" class="btn-ghost" @click="showModal = false">Cancel</button>
          <button type="submit" class="btn-primary" :disabled="saving">{{ saving ? 'Saving…' : 'Save' }}</button>
        </div>
      </form>
    </AppModal>
  </div>
</template>
