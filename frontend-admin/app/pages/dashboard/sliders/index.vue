<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })
const { items, loading, saving, error, load, create, update, remove } = useCrud<{ id: number; title: string; project: string; image: string }>('/api/v1/admin/sliders')
const showModal = ref(false)
const editing = ref<null | any>(null)
const form = reactive({ title: '', project: '', description: '' })
const imageFile = ref<File | null>(null)

function openCreate() { editing.value = null; Object.assign(form, { title: '', project: '', description: '' }); imageFile.value = null; showModal.value = true }
function openEdit(row: any) { editing.value = row; Object.assign(form, row); imageFile.value = null; showModal.value = true }
async function save() {
  const fd = new FormData()
  Object.entries(form).forEach(([k, v]) => fd.append(k, String(v ?? '')))
  if (imageFile.value) fd.append('image', imageFile.value)
  const r = editing.value ? await update(editing.value.id, fd) : await create(fd)
  if (r) { showModal.value = false; load() }
}
onMounted(() => load())
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-heading">Sliders</h1>
      <button class="btn-primary" @click="openCreate">+ Add Slide</button>
    </div>
    <AppTable :cols="[{ key: 'title', label: 'Title' }, { key: 'project', label: 'Project' }]" :rows="items" :loading="loading">
      <template #title="{ row }">
        <div class="flex items-center gap-3">
          <img v-if="(row as any).image" :src="(row as any).image" class="w-14 h-8 rounded object-cover" />
          <span>{{ (row as any).title }}</span>
        </div>
      </template>
      <template #actions="{ row }">
        <button class="btn-ghost text-xs mr-2" @click="openEdit(row)">Edit</button>
        <button class="btn-danger text-xs" @click="confirm('Delete?') && remove((row as any).id)">Delete</button>
      </template>
    </AppTable>
    <AppModal v-model:show="showModal" :title="editing ? 'Edit Slide' : 'New Slide'">
      <form class="p-6 space-y-4" @submit.prevent="save">
        <div><label class="label">Title</label><input v-model="form.title" class="input" required /></div>
        <div><label class="label">Project / Subtitle</label><input v-model="form.project" class="input" /></div>
        <div><label class="label">Description</label><textarea v-model="form.description" class="input" rows="3" /></div>
        <div><label class="label">Image{{ editing ? ' (leave empty to keep current)' : '' }}</label><input type="file" accept="image/*" class="input" @change="imageFile = ($event.target as HTMLInputElement).files?.[0] ?? null" /></div>
        <div v-if="error" class="text-red-400 text-sm">{{ error }}</div>
        <div class="flex justify-end gap-3"><button type="button" class="btn-ghost" @click="showModal = false">Cancel</button><button type="submit" class="btn-primary" :disabled="saving">{{ saving ? 'Saving…' : 'Save' }}</button></div>
      </form>
    </AppModal>
  </div>
</template>
