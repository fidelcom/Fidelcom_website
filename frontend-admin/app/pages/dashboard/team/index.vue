<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })
const { items, loading, saving, error, load, create, update, remove } = useCrud<{ id: number; name: string; position: string; image: string }>('/api/v1/admin/team')
const showModal = ref(false)
const editing = ref<null | any>(null)
const form = reactive({ name: '', position: '', facebook: '', twitter: '', linkedin: '', instagram: '' })
const imageFile = ref<File | null>(null)

function openCreate() { editing.value = null; Object.assign(form, { name: '', position: '', facebook: '', twitter: '', linkedin: '', instagram: '' }); imageFile.value = null; showModal.value = true }
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
      <h1 class="text-2xl font-bold text-heading">Team</h1>
      <button class="btn-primary" @click="openCreate">+ Add Member</button>
    </div>
    <AppTable :cols="[{ key: 'name', label: 'Name' }, { key: 'position', label: 'Position' }]" :rows="items" :loading="loading">
      <template #name="{ row }">
        <div class="flex items-center gap-3">
          <img v-if="(row as any).image" :src="(row as any).image" class="w-8 h-8 rounded-full object-cover" />
          <span>{{ (row as any).name }}</span>
        </div>
      </template>
      <template #actions="{ row }">
        <button class="btn-ghost text-xs mr-2" @click="openEdit(row)">Edit</button>
        <button class="btn-danger text-xs" @click="confirm('Delete?') && remove((row as any).id)">Delete</button>
      </template>
    </AppTable>
    <AppModal v-model:show="showModal" :title="editing ? 'Edit Member' : 'New Member'">
      <form class="p-6 space-y-4" @submit.prevent="save">
        <div class="grid grid-cols-2 gap-4">
          <div><label class="label">Name</label><input v-model="form.name" class="input" required /></div>
          <div><label class="label">Position</label><input v-model="form.position" class="input" required /></div>
        </div>
        <div><label class="label">Photo{{ editing ? ' (leave empty to keep current)' : '' }}</label><input type="file" accept="image/*" class="input" @change="imageFile = ($event.target as HTMLInputElement).files?.[0] ?? null" /></div>
        <div class="grid grid-cols-2 gap-4">
          <div><label class="label">Facebook URL</label><input v-model="form.facebook" class="input" placeholder="https://…" /></div>
          <div><label class="label">Twitter/X URL</label><input v-model="form.twitter" class="input" placeholder="https://…" /></div>
          <div><label class="label">LinkedIn URL</label><input v-model="form.linkedin" class="input" placeholder="https://…" /></div>
          <div><label class="label">Instagram URL</label><input v-model="form.instagram" class="input" placeholder="https://…" /></div>
        </div>
        <div v-if="error" class="text-red-400 text-sm">{{ error }}</div>
        <div class="flex justify-end gap-3"><button type="button" class="btn-ghost" @click="showModal = false">Cancel</button><button type="submit" class="btn-primary" :disabled="saving">{{ saving ? 'Saving…' : 'Save' }}</button></div>
      </form>
    </AppModal>
  </div>
</template>
