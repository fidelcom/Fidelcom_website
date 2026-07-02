<script setup lang="ts">
import { VueDraggable } from 'vue-draggable-plus'
definePageMeta({ layout: 'dashboard' })

const route = useRoute()
const api = useApi()
const pageId = route.params.id as string

const page = ref<{ id: number; title: string; slug: string; status: string } | null>(null)
const blocks = ref<{ id: number; block_type: string; position: number; data: Record<string, unknown> }[]>([])
const loading = ref(true)
const saving = ref(false)

const showAddModal = ref(false)
const showEditModal = ref(false)
const editingBlock = ref<typeof blocks.value[0] | null>(null)
const editData = ref<string>('')

const BLOCK_TYPES = [
  { type: 'hero',          label: 'Hero Banner' },
  { type: 'slider',        label: 'Slider' },
  { type: 'content',       label: 'Rich Content' },
  { type: 'stats',         label: 'Stats' },
  { type: 'services_grid', label: 'Services Grid' },
  { type: 'projects_grid', label: 'Projects Grid' },
  { type: 'testimonials',  label: 'Testimonials' },
  { type: 'blog_posts',    label: 'Blog Posts' },
  { type: 'team',          label: 'Team' },
  { type: 'faqs',          label: 'FAQs' },
  { type: 'cta_banner',    label: 'CTA Banner' },
  { type: 'gallery',       label: 'Gallery' },
  { type: 'partners',      label: 'Partners / Logos' },
  { type: 'contact_form',  label: 'Contact Form' },
  { type: 'process_steps', label: 'Process Steps' },
]

async function load() {
  loading.value = true
  try {
    const res = await api.get<{ data: any }>(`/admin/pages/${pageId}`)
    page.value = res.data
    blocks.value = (res.data.blocks ?? []).sort((a: any, b: any) => a.position - b.position)
  } finally { loading.value = false }
}

async function addBlock(type: string) {
  const defaultData: Record<string, Record<string, unknown>> = {
    hero:          { heading: 'New Heading', subheading: '', button_label: 'Learn More', button_url: '/' },
    slider:        { slider_ids: [], autoplay: true, autoplay_speed: 5000 },
    stats:         { heading: 'Our Impact', source: 'db' },
    services_grid: { heading: 'Our Services', style: 'card-grid', limit: 6 },
    projects_grid: { heading: 'Our Portfolio', style: 'grid', limit: 6 },
    testimonials:  { heading: 'What Clients Say', style: 'slider', limit: 6 },
    blog_posts:    { heading: 'Latest Insights', style: 'card', limit: 3 },
    team:          { heading: 'Our Team', limit: 8 },
    faqs:          { heading: 'FAQs', limit: 5, style: 'accordion' },
    cta_banner:    { heading: 'Ready to Start?', body: '', button_label: 'Contact Us', button_url: '/contact-us', bg_color: 'primary' },
    gallery:       { heading: 'Gallery', limit: 12 },
    partners:      { heading: 'Trusted By', style: 'logo-strip' },
    contact_form:  { heading: 'Get In Touch' },
    process_steps: { heading: 'How We Work' },
    content:       { heading: '', body: '' },
  }

  saving.value = true
  const res = await api.post<{ data: any }>(`/admin/pages/${pageId}/blocks`, {
    block_type: type,
    position: blocks.value.length,
    data: defaultData[type] ?? {},
  })
  if (res.data) { blocks.value.push(res.data); showAddModal.value = false }
  saving.value = false
}

async function onDragEnd() {
  const order = blocks.value.map((b, i) => ({ id: b.id, position: i }))
  await api.post(`/admin/pages/${pageId}/blocks/reorder`, { order })
  blocks.value.forEach((b, i) => b.position = i)
}

function openEdit(block: typeof blocks.value[0]) {
  editingBlock.value = block
  editData.value = JSON.stringify(block.data, null, 2)
  showEditModal.value = true
}

async function saveBlock() {
  if (!editingBlock.value) return
  try {
    const parsed = JSON.parse(editData.value)
    saving.value = true
    const res = await api.patch<{ data: any }>(`/admin/blocks/${editingBlock.value.id}`, { data: parsed })
    if (res.data) {
      const idx = blocks.value.findIndex(b => b.id === editingBlock.value!.id)
      if (idx !== -1) blocks.value[idx].data = res.data.data
      showEditModal.value = false
    }
  } catch { alert('Invalid JSON') }
  finally { saving.value = false }
}

async function deleteBlock(id: number) {
  if (!confirm('Remove this block?')) return
  await api.delete(`/admin/blocks/${id}`)
  blocks.value = blocks.value.filter(b => b.id !== id)
}

onMounted(() => load())
</script>

<template>
  <div>
    <div class="flex items-center gap-4 mb-6">
      <NuxtLink to="/dashboard/pages" class="btn-ghost text-xs">← Pages</NuxtLink>
      <h1 class="text-2xl font-bold text-heading flex-1">
        {{ page?.title ?? 'Page Builder' }}
        <span class="text-sm font-normal text-body ml-2">/ {{ page?.slug }}</span>
      </h1>
      <span :class="page?.status === 'published' ? 'text-green-400' : 'text-yellow-400'" class="text-xs font-medium">
        {{ page?.status }}
      </span>
    </div>

    <div v-if="loading" class="text-body">Loading blocks…</div>

    <div v-else class="flex gap-6">
      <!-- Block list -->
      <div class="flex-1">
        <div v-if="!blocks.length" class="bg-surface rounded-xl p-12 text-center text-body">
          No blocks yet. Add your first block →
        </div>

        <VueDraggable v-model="blocks" item-key="id" handle=".drag-handle" class="space-y-3" @end="onDragEnd">
          <template #item="{ element: block }">
            <div class="bg-surface rounded-xl p-4 flex items-center gap-4 group border border-transparent hover:border-border transition-colors">
              <Icon name="i-heroicons-bars-2" class="drag-handle w-5 h-5 text-body cursor-grab flex-shrink-0" />
              <div class="flex-1 min-w-0">
                <p class="text-heading text-sm font-medium">{{ BLOCK_TYPES.find(t => t.type === block.block_type)?.label ?? block.block_type }}</p>
                <p class="text-body text-xs truncate">{{ JSON.stringify(block.data).slice(0, 80) }}…</p>
              </div>
              <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <button class="btn-ghost text-xs" @click="openEdit(block)">Edit Data</button>
                <button class="btn-danger text-xs" @click="deleteBlock(block.id)">Remove</button>
              </div>
            </div>
          </template>
        </VueDraggable>

        <button class="mt-4 w-full rounded-xl border-2 border-dashed border-border text-body text-sm py-4 hover:border-primary hover:text-primary transition-colors" @click="showAddModal = true">
          + Add Block
        </button>
      </div>
    </div>

    <!-- Add block modal -->
    <AppModal v-model:show="showAddModal" title="Add Block" max-width="max-w-lg">
      <div class="p-6 grid grid-cols-2 gap-3">
        <button
          v-for="bt in BLOCK_TYPES"
          :key="bt.type"
          class="text-left bg-surface-alt rounded-xl p-4 hover:bg-primary/10 hover:text-primary transition-colors"
          :disabled="saving"
          @click="addBlock(bt.type)"
        >
          <p class="text-heading text-sm font-medium">{{ bt.label }}</p>
          <p class="text-body text-xs">{{ bt.type }}</p>
        </button>
      </div>
    </AppModal>

    <!-- Edit block data modal -->
    <AppModal v-model:show="showEditModal" :title="`Edit: ${editingBlock?.block_type}`" max-width="max-w-2xl">
      <div class="p-6 space-y-4">
        <p class="text-body text-sm">Edit the JSON data for this block. Changes apply to how it renders on the public site.</p>
        <textarea v-model="editData" class="input font-mono text-xs" rows="16" spellcheck="false" />
        <div class="flex justify-end gap-3">
          <button type="button" class="btn-ghost" @click="showEditModal = false">Cancel</button>
          <button class="btn-primary" :disabled="saving" @click="saveBlock">{{ saving ? 'Saving…' : 'Save Block' }}</button>
        </div>
      </div>
    </AppModal>
  </div>
</template>
