<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })
const { items, loading, saving, error, load, create, update, remove } = useCrud<{ id: number; name: string; image: string; alt_text: string }>('/admin/gallery', 'Image')
const { resizeImage } = useImageResize()
const { assetUrl } = useAssetUrl()
const showModal = ref(false)
const editing = ref<null | any>(null)
const form = reactive({ name: '', alt_text: '' })
const imageFile = ref<File | null>(null)

function openCreate() { editing.value = null; Object.assign(form, { name: '', alt_text: '' }); imageFile.value = null; showModal.value = true }
function openEdit(row: any) { editing.value = row; Object.assign(form, row); imageFile.value = null; showModal.value = true }
async function save() {
  const fd = new FormData()
  Object.entries(form).forEach(([k, v]) => fd.append(k, String(v ?? '')))
  if (imageFile.value) fd.append('image', await resizeImage(imageFile.value, 1920, 1080))
  const r = editing.value ? await update(editing.value.id, fd) : await create(fd)
  if (r) { showModal.value = false; load() }
}
onMounted(() => load())
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-heading">Gallery</h1>
      <button class="btn-primary" @click="openCreate">+ Upload Image</button>
    </div>
    <div v-if="loading" class="text-body text-sm">Loading…</div>
    <div v-else class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-3">
      <div v-for="img in items" :key="img.id" class="group relative rounded-xl overflow-hidden bg-surface aspect-square">
        <img :src="assetUrl(img.image)" :alt="img.alt_text || img.name" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
          <button class="btn-ghost text-xs text-white" @click="openEdit(img)">Edit</button>
          <button class="btn-danger text-xs" @click="confirm('Delete?') && remove(img.id)">Del</button>
        </div>
        <p v-if="img.name" class="absolute bottom-0 inset-x-0 bg-black/70 text-white text-xs px-2 py-1 truncate">{{ img.name }}</p>
      </div>
    </div>
    <AppModal v-model:show="showModal" :title="editing ? 'Edit Image' : 'Upload Image'">
      <form class="p-6 space-y-4" @submit.prevent="save">
        <div><label class="label">Name / Caption</label><input v-model="form.name" class="input" /></div>
        <div><label class="label">Alt Text</label><input v-model="form.alt_text" class="input" /></div>
        <div><label class="label">Image{{ editing ? ' (leave empty to keep current)' : '' }}</label><input type="file" accept="image/*" class="input" @change="imageFile = ($event.target as HTMLInputElement).files?.[0] ?? null" /></div>
        <div v-if="error" class="text-red-400 text-sm">{{ error }}</div>
        <div class="flex justify-end gap-3"><button type="button" class="btn-ghost" @click="showModal = false">Cancel</button><button type="submit" class="btn-primary" :disabled="saving">{{ saving ? 'Saving…' : 'Save' }}</button></div>
      </form>
    </AppModal>
  </div>
</template>
