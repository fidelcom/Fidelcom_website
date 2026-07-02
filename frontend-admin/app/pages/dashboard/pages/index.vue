<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })
const { items, loading, saving, error, load, create, update, remove } = useCrud<{
  id: number; title: string; slug: string; status: string; published_at: string | null
}>('/admin/pages')
const showModal = ref(false)
const editing = ref<null | any>(null)
const form = reactive({ title: '', slug: '', status: 'draft', meta_title: '', meta_description: '' })

function openCreate() { editing.value = null; Object.assign(form, { title: '', slug: '', status: 'draft', meta_title: '', meta_description: '' }); showModal.value = true }
function openEdit(row: any) { editing.value = row; Object.assign(form, row); showModal.value = true }

async function save() {
  const r = editing.value ? await update(editing.value.id, form) : await create(form)
  if (r) { showModal.value = false; load() }
}

onMounted(() => load())
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-heading">Pages</h1>
      <button class="btn-primary" @click="openCreate">+ New Page</button>
    </div>
    <AppTable
      :cols="[{ key: 'title', label: 'Title' }, { key: 'slug', label: 'Slug' }, { key: 'status', label: 'Status' }]"
      :rows="items"
      :loading="loading"
    >
      <template #status="{ row }">
        <span :class="(row as any).status === 'published' ? 'text-green-400' : 'text-yellow-400'">
          {{ (row as any).status }}
        </span>
      </template>
      <template #actions="{ row }">
        <NuxtLink :to="`/dashboard/pages/${(row as any).id}/builder`" class="btn-ghost text-xs mr-2">Builder</NuxtLink>
        <button class="btn-ghost text-xs mr-2" @click="openEdit(row)">Edit</button>
        <button class="btn-danger text-xs" @click="confirm('Delete?') && remove((row as any).id)">Delete</button>
      </template>
    </AppTable>
    <AppModal v-model:show="showModal" :title="editing ? 'Edit Page' : 'New Page'">
      <form class="p-6 space-y-4" @submit.prevent="save">
        <div><label class="label">Title</label><input v-model="form.title" class="input" required /></div>
        <div><label class="label">Slug</label><input v-model="form.slug" class="input" placeholder="home, about-usâ€¦" required /></div>
        <div>
          <label class="label">Status</label>
          <select v-model="form.status" class="input"><option value="draft">Draft</option><option value="published">Published</option></select>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div><label class="label">Meta Title</label><input v-model="form.meta_title" class="input" /></div>
          <div><label class="label">Meta Description</label><input v-model="form.meta_description" class="input" /></div>
        </div>
        <div v-if="error" class="text-red-400 text-sm">{{ error }}</div>
        <div class="flex justify-end gap-3"><button type="button" class="btn-ghost" @click="showModal = false">Cancel</button><button type="submit" class="btn-primary" :disabled="saving">{{ saving ? 'Savingâ€¦' : 'Save' }}</button></div>
      </form>
    </AppModal>
  </div>
</template>
