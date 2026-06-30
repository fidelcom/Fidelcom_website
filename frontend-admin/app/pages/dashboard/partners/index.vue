<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })
const { items, loading, saving, error, load, create, update, remove } = useCrud<{ id: number; name: string; image: string; url: string }>('/api/v1/admin/partners')
const showModal = ref(false)
const editing = ref<null | any>(null)
const form = reactive({ name: '', url: '' })
const imageFile = ref<File | null>(null)

function openCreate() { editing.value = null; Object.assign(form, { name: '', url: '' }); imageFile.value = null; showModal.value = true }
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
      <h1 class="text-2xl font-bold text-heading">Partners</h1>
      <button class="btn-primary" @click="openCreate">+ Add Partner</button>
    </div>
    <div class="grid grid-cols-3 md:grid-cols-5 gap-4 mb-6">
      <div v-for="p in items" :key="p.id" class="bg-surface rounded-xl p-4 flex flex-col items-center gap-3">
        <img :src="p.image" :alt="p.name" class="h-12 object-contain" />
        <p class="text-body text-xs text-center">{{ p.name }}</p>
        <div class="flex gap-2 mt-auto">
          <button class="btn-ghost text-xs" @click="openEdit(p)">Edit</button>
          <button class="btn-danger text-xs" @click="confirm('Delete?') && remove(p.id)">Del</button>
        </div>
      </div>
    </div>
    <AppModal v-model:show="showModal" :title="editing ? 'Edit Partner' : 'New Partner'">
      <form class="p-6 space-y-4" @submit.prevent="save">
        <div><label class="label">Name</label><input v-model="form.name" class="input" required /></div>
        <div><label class="label">Website URL</label><input v-model="form.url" class="input" placeholder="https://…" /></div>
        <div><label class="label">Logo{{ editing ? ' (leave empty to keep current)' : '' }}</label><input type="file" accept="image/*" class="input" @change="imageFile = ($event.target as HTMLInputElement).files?.[0] ?? null" /></div>
        <div v-if="error" class="text-red-400 text-sm">{{ error }}</div>
        <div class="flex justify-end gap-3"><button type="button" class="btn-ghost" @click="showModal = false">Cancel</button><button type="submit" class="btn-primary" :disabled="saving">{{ saving ? 'Saving…' : 'Save' }}</button></div>
      </form>
    </AppModal>
  </div>
</template>
