<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })
const api = useApi()
const { items, loading, saving, error, meta, page, search, load, create, update, remove } = useCrud<{
  id: number; title: string; slug: string; client: string; project_category?: { name: string }
}>('/api/v1/admin/projects')
const showModal = ref(false)
const editing = ref<null | any>(null)
const categories = ref<{ id: number; name: string }[]>([])
const form = reactive({ title: '', project_category_id: 0, short_desc: '', long_desc: '', client: '', year: '', location: '', meta_title: '', meta_description: '' })
const imageFile = ref<File | null>(null)

function openCreate() { editing.value = null; Object.assign(form, { title: '', project_category_id: categories.value[0]?.id ?? 0, short_desc: '', long_desc: '', client: '', year: '', location: '', meta_title: '', meta_description: '' }); imageFile.value = null; showModal.value = true }
function openEdit(row: any) { editing.value = row; Object.assign(form, { ...row, project_category_id: row.project_category?.id ?? 0 }); imageFile.value = null; showModal.value = true }
async function save() {
  const fd = new FormData()
  Object.entries(form).forEach(([k, v]) => fd.append(k, String(v ?? '')))
  if (imageFile.value) fd.append('image', imageFile.value)
  const r = editing.value ? await update(editing.value.id, fd) : await create(fd)
  if (r) { showModal.value = false; load() }
}

onMounted(async () => {
  categories.value = await api.get<{ data: { id: number; name: string }[] }>('/api/v1/admin/project-categories').then(r => r.data).catch(() => [])
  load()
})
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-heading">Projects</h1>
      <button class="btn-primary" @click="openCreate">+ New Project</button>
    </div>
    <div class="mb-4"><input v-model="search" placeholder="Search…" class="input w-64" /></div>
    <AppTable :cols="[{ key: 'title', label: 'Title' }, { key: 'category', label: 'Category' }, { key: 'client', label: 'Client' }]" :rows="items" :loading="loading">
      <template #category="{ row }">{{ (row as any).project_category?.name ?? '—' }}</template>
      <template #actions="{ row }">
        <button class="btn-ghost text-xs mr-2" @click="openEdit(row)">Edit</button>
        <button class="btn-danger text-xs" @click="confirm('Delete?') && remove((row as any).id)">Delete</button>
      </template>
    </AppTable>
    <AppPagination :page="meta.current_page" :last-page="meta.last_page" :total="meta.total" @update:page="p => { page = p }" />
    <AppModal v-model:show="showModal" :title="editing ? 'Edit Project' : 'New Project'" max-width="max-w-2xl">
      <form class="p-6 space-y-4" @submit.prevent="save">
        <div><label class="label">Title</label><input v-model="form.title" class="input" required /></div>
        <div class="grid grid-cols-2 gap-4">
          <div><label class="label">Category</label>
            <select v-model="form.project_category_id" class="input">
              <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
            </select>
          </div>
          <div><label class="label">Client</label><input v-model="form.client" class="input" /></div>
          <div><label class="label">Year</label><input v-model="form.year" class="input" type="number" /></div>
          <div><label class="label">Location</label><input v-model="form.location" class="input" /></div>
        </div>
        <div><label class="label">Short Description</label><textarea v-model="form.short_desc" class="input" rows="3" required /></div>
        <div><label class="label">Full Description</label><textarea v-model="form.long_desc" class="input" rows="5" required /></div>
        <div><label class="label">Featured Image{{ editing ? ' (keep empty to retain)' : '' }}</label><input type="file" accept="image/*" class="input" @change="imageFile = ($event.target as HTMLInputElement).files?.[0] ?? null" /></div>
        <div class="grid grid-cols-2 gap-4">
          <div><label class="label">Meta Title</label><input v-model="form.meta_title" class="input" /></div>
          <div><label class="label">Meta Description</label><input v-model="form.meta_description" class="input" /></div>
        </div>
        <div v-if="error" class="text-red-400 text-sm">{{ error }}</div>
        <div class="flex justify-end gap-3"><button type="button" class="btn-ghost" @click="showModal = false">Cancel</button><button type="submit" class="btn-primary" :disabled="saving">{{ saving ? 'Saving…' : 'Save' }}</button></div>
      </form>
    </AppModal>
  </div>
</template>
