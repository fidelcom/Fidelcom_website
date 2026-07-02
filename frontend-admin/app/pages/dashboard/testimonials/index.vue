<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })
const api = useApi()
const { items, loading, saving, error, load, create, update, remove } = useCrud<{ id: number; name: string; desc: string; rating: number; approved: boolean }>('/admin/testimonials', 'Testimonial')
const { resizeImage } = useImageResize()
const showModal = ref(false)
const editing = ref<null | any>(null)
const form = reactive({ name: '', subtitle: '', location: '', desc: '', rating: 5, approved: false })
const imageFile = ref<File | null>(null)

function openCreate() { editing.value = null; Object.assign(form, { name: '', subtitle: '', location: '', desc: '', rating: 5, approved: false }); imageFile.value = null; showModal.value = true }
function openEdit(row: any) { editing.value = row; Object.assign(form, row); imageFile.value = null; showModal.value = true }

async function save() {
  const fd = new FormData()
  Object.entries(form).forEach(([k, v]) => fd.append(k, String(v ?? '')))
  if (imageFile.value) fd.append('image', await resizeImage(imageFile.value, 400, 400))
  const r = editing.value ? await update(editing.value.id, fd) : await create(fd)
  if (r) { showModal.value = false; load() }
}

async function approve(id: number) {
  await api.patch(`/admin/testimonials/${id}/approve`)
  load()
}

onMounted(() => load())
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-heading">Testimonials</h1>
      <button class="btn-primary" @click="openCreate">+ Add Testimonial</button>
    </div>
    <AppTable
      :cols="[{ key: 'name', label: 'Name' }, { key: 'desc', label: 'Message' }, { key: 'rating', label: 'Rating' }, { key: 'approved', label: 'Status' }]"
      :rows="items"
      :loading="loading"
    >
      <template #desc="{ row }">{{ (row as any).desc?.slice(0, 60) }}…</template>
      <template #rating="{ row }">{{ '★'.repeat((row as any).rating ?? 5) }}</template>
      <template #approved="{ row }">
        <span :class="(row as any).approved ? 'text-green-400' : 'text-yellow-400'">
          {{ (row as any).approved ? 'Approved' : 'Pending' }}
        </span>
      </template>
      <template #actions="{ row }">
        <button v-if="!(row as any).approved" class="btn-ghost text-xs text-green-400 mr-2" @click="approve((row as any).id)">Approve</button>
        <button class="btn-ghost text-xs mr-2" @click="openEdit(row)">Edit</button>
        <button class="btn-danger text-xs" @click="confirm('Delete?') && remove((row as any).id)">Delete</button>
      </template>
    </AppTable>
    <AppModal v-model:show="showModal" :title="editing ? 'Edit Testimonial' : 'New Testimonial'">
      <form class="p-6 space-y-4" @submit.prevent="save">
        <div><label class="label">Name</label><input v-model="form.name" class="input" required /></div>
        <div class="grid grid-cols-2 gap-4">
          <div><label class="label">Title / Role</label><input v-model="form.subtitle" class="input" /></div>
          <div><label class="label">Location / Company</label><input v-model="form.location" class="input" /></div>
        </div>
        <div><label class="label">Message</label><textarea v-model="form.desc" class="input" rows="4" required /></div>
        <div class="grid grid-cols-2 gap-4">
          <div><label class="label">Rating (1–5)</label><input v-model.number="form.rating" type="number" min="1" max="5" class="input" /></div>
          <div class="flex items-center gap-2 pt-5"><input v-model="form.approved" type="checkbox" class="accent-primary" /><label class="label m-0">Approved</label></div>
        </div>
        <div><label class="label">Photo{{ editing ? ' (leave empty to keep current)' : '' }}</label><input type="file" accept="image/*" class="input" @change="imageFile = ($event.target as HTMLInputElement).files?.[0] ?? null" /></div>
        <div v-if="error" class="text-red-400 text-sm">{{ error }}</div>
        <div class="flex justify-end gap-3"><button type="button" class="btn-ghost" @click="showModal = false">Cancel</button><button type="submit" class="btn-primary" :disabled="saving">{{ saving ? 'Saving…' : 'Save' }}</button></div>
      </form>
    </AppModal>
  </div>
</template>
