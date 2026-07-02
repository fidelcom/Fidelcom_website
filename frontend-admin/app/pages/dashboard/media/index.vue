<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })
const api = useApi()
const toast = useToast()
const { assetUrl } = useAssetUrl()
const { resizeImage } = useImageResize()
const items = ref<{ id: number; url: string; filename: string; alt_text: string; size: number; width: number; height: number }[]>([])
const loading = ref(false)
const uploading = ref(false)
const selected = ref<null | typeof items.value[0]>(null)
const altText = ref('')

async function load() {
  loading.value = true
  items.value = await api.get<{ data: any[] }>('/admin/media').then(r => r.data).finally(() => loading.value = false)
}

async function upload(e: Event) {
  const files = (e.target as HTMLInputElement).files
  if (!files?.length) return
  uploading.value = true
  let uploaded = 0
  for (const file of Array.from(files)) {
    const fd = new FormData()
    fd.append('file', await resizeImage(file, 1920, 1080))
    const ok = await api.post('/admin/media/upload', fd).then(() => true).catch(() => false)
    if (ok) uploaded++
  }
  uploading.value = false
  if (uploaded) toast.success(`${uploaded} file${uploaded > 1 ? 's' : ''} uploaded`)
  load()
}

async function saveAlt() {
  if (!selected.value) return
  await api.patch(`/admin/media/${selected.value.id}`, { alt_text: altText.value })
  selected.value.alt_text = altText.value
  selected.value = null
  toast.success('Alt text saved')
}

async function deleteMedia(id: number) {
  if (confirm('Delete this file?')) {
    await api.delete(`/admin/media/${id}`)
    toast.success('File deleted')
    load()
    if (selected.value?.id === id) selected.value = null
  }
}

function selectMedia(item: typeof items.value[0]) {
  selected.value = item
  altText.value = item.alt_text ?? ''
}

onMounted(() => load())
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-heading">Media Library</h1>
      <label class="btn-primary cursor-pointer">
        {{ uploading ? 'Uploading…' : '+ Upload' }}
        <input type="file" accept="image/*" multiple class="hidden" @change="upload" />
      </label>
    </div>

    <div class="flex gap-6">
      <div class="flex-1">
        <div v-if="loading" class="text-body text-sm">Loading…</div>
        <div v-else class="grid grid-cols-3 md:grid-cols-5 lg:grid-cols-7 gap-3">
          <div
            v-for="m in items"
            :key="m.id"
            :class="['group relative rounded-xl overflow-hidden bg-surface aspect-square cursor-pointer ring-2 transition-all', selected?.id === m.id ? 'ring-primary' : 'ring-transparent hover:ring-primary/50']"
            @click="selectMedia(m)"
          >
            <img :src="assetUrl(m.url)" :alt="m.alt_text || m.filename" class="w-full h-full object-cover" />
          </div>
        </div>
      </div>

      <aside v-if="selected" class="w-64 flex-shrink-0">
        <div class="bg-surface rounded-xl p-4 space-y-3 sticky top-4">
          <img :src="assetUrl(selected.url)" :alt="selected.alt_text" class="w-full rounded-lg object-contain max-h-40" />
          <p class="text-body text-xs break-all">{{ selected.filename }}</p>
          <p class="text-body text-xs">{{ selected.width }}×{{ selected.height }}px · {{ (selected.size / 1024).toFixed(0) }}KB</p>
          <div>
            <label class="label">Alt Text</label>
            <input v-model="altText" class="input" />
          </div>
          <div class="flex gap-2">
            <button class="btn-primary flex-1 text-xs" @click="saveAlt">Save</button>
            <button class="btn-danger flex-1 text-xs" @click="deleteMedia(selected!.id)">Delete</button>
          </div>
        </div>
      </aside>
    </div>
  </div>
</template>
