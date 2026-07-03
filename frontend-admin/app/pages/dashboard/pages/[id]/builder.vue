<script setup lang="ts">
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
const editData = ref<Record<string, unknown>>({})

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
  { type: 'case_study',    label: 'Case Study' },
]

async function load() {
  loading.value = true
  try {
    const res = await api.get<{ data: any }>(`/admin/pages/${pageId}`)
    page.value = res.data
    blocks.value = (res.data.blocks ?? []).sort((a: any, b: any) => a.position - b.position)
  } finally { loading.value = false }
}

async function refreshBlocks() {
  const res = await api.get<{ data: any }>(`/admin/pages/${pageId}`)
  page.value = res.data
  blocks.value = (res.data.blocks ?? []).sort((a: any, b: any) => a.position - b.position)
}

async function addBlock(type: string) {
  const defaultData: Record<string, Record<string, unknown>> = {
    hero:          { heading: 'New Heading', subheading: '', button_label: 'Learn More', button_url: '/' },
    slider:        { slider_ids: '', autoplay: true, autoplay_speed: 5000 },
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
    contact_form:  { heading: 'Get In Touch', subheading: '' },
    process_steps: { heading: 'How We Work' },
    content:       { heading: '', body: '' },
    case_study:    { heading: 'Case Studies', style: 'featured', limit: 3 },
  }

  saving.value = true
  try {
    await api.post<{ data: any }>(`/admin/pages/${pageId}/blocks`, {
      block_type: type,
      position: blocks.value.length,
      data: defaultData[type] ?? {},
    })
    showAddModal.value = false
    await refreshBlocks()
  } finally {
    saving.value = false
  }
}

async function moveBlock(index: number, dir: -1 | 1) {
  const target = index + dir
  if (target < 0 || target >= blocks.value.length) return
  const arr = [...blocks.value]
  ;[arr[index], arr[target]] = [arr[target], arr[index]]
  blocks.value = arr.map((b, i) => ({ ...b, position: i }))
  const order = blocks.value.map((b, i) => ({ id: b.id, position: i }))
  await api.post(`/admin/pages/${pageId}/blocks/reorder`, { order })
}

function openEdit(block: typeof blocks.value[0]) {
  editingBlock.value = block
  editData.value = { ...block.data }
  showEditModal.value = true
}

async function saveBlock() {
  if (!editingBlock.value) return
  saving.value = true
  try {
    const res = await api.patch<{ data: any }>(`/admin/blocks/${editingBlock.value.id}`, { data: editData.value })
    if (res.data) {
      const idx = blocks.value.findIndex(b => b.id === editingBlock.value!.id)
      if (idx !== -1) blocks.value[idx].data = res.data.data
      showEditModal.value = false
    }
  } finally { saving.value = false }
}

async function deleteBlock(id: number) {
  if (!confirm('Remove this block?')) return
  try {
    await api.delete(`/admin/blocks/${id}`)
    await refreshBlocks()
  } catch {
    blocks.value = blocks.value.filter(b => b.id !== id)
  }
}

const editingLabel = computed(() =>
  BLOCK_TYPES.find(t => t.type === editingBlock.value?.block_type)?.label ?? editingBlock.value?.block_type ?? ''
)

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
      <span :class="page?.status === 'published' ? 'text-green-400' : 'text-amber-400'" class="text-xs font-medium capitalize">
        {{ page?.status }}
      </span>
    </div>

    <div v-if="loading" class="text-body">Loading blocks…</div>

    <div v-else class="flex gap-6">
      <div class="flex-1">
        <div v-if="!blocks.length" class="bg-surface rounded-xl p-12 text-center text-body">
          No blocks yet. Add your first block →
        </div>

        <div class="space-y-3">
          <div
            v-for="(block, index) in blocks"
            :key="block.id"
            class="bg-surface rounded-xl p-4 flex items-center gap-4 group border border-transparent hover:border-border transition-colors"
          >
            <div class="flex flex-col gap-1 flex-shrink-0">
              <button
                class="text-body hover:text-primary disabled:opacity-30 transition-colors"
                :disabled="index === 0"
                @click="moveBlock(index, -1)"
                title="Move up"
              >▲</button>
              <button
                class="text-body hover:text-primary disabled:opacity-30 transition-colors"
                :disabled="index === blocks.length - 1"
                @click="moveBlock(index, 1)"
                title="Move down"
              >▼</button>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-heading text-sm font-medium">{{ BLOCK_TYPES.find(t => t.type === block.block_type)?.label ?? block.block_type }}</p>
              <p class="text-body text-xs truncate">{{ JSON.stringify(block.data).slice(0, 80) }}…</p>
            </div>
            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
              <button class="btn-ghost text-xs" @click="openEdit(block)">Edit</button>
              <button class="btn-danger text-xs" @click="deleteBlock(block.id)">Remove</button>
            </div>
          </div>
        </div>

        <button
          class="mt-4 w-full rounded-xl border-2 border-dashed border-border text-body text-sm py-4 hover:border-primary hover:text-primary transition-colors"
          @click="showAddModal = true"
        >
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

    <!-- Edit block modal -->
    <AppModal v-model:show="showEditModal" :title="`Edit: ${editingLabel}`" max-width="max-w-xl">
      <div class="p-6 space-y-4">
        <BlockEditor
          v-if="editingBlock"
          :block-type="editingBlock.block_type"
          :model-value="editData"
          @update:model-value="editData = $event"
        />
        <div class="flex justify-end gap-3 pt-2 border-t border-border">
          <button type="button" class="btn-ghost" @click="showEditModal = false">Cancel</button>
          <button class="btn-primary" :disabled="saving" @click="saveBlock">
            {{ saving ? 'Saving…' : 'Save Block' }}
          </button>
        </div>
      </div>
    </AppModal>
  </div>
</template>
