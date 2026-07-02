<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })
const api = useApi()
const toast = useToast()
const items = ref<{ id: number; name: string; slug: string }[]>([])
const loading = ref(true)
const showModal = ref(false)
const saving = ref(false)
const editing = ref<{ id: number; name: string; slug: string } | null>(null)
const name = ref('')
const error = ref<string | null>(null)

async function load() {
  loading.value = true
  items.value = await api.get<{ data: { id: number; name: string; slug: string }[] }>('/admin/project-categories').then(r => r.data).finally(() => loading.value = false)
}

function openCreate() { editing.value = null; name.value = ''; error.value = null; showModal.value = true }
function openEdit(item: typeof items.value[0]) { editing.value = item; name.value = item.name; error.value = null; showModal.value = true }

async function save() {
  if (!name.value.trim()) return
  saving.value = true; error.value = null
  try {
    if (editing.value) {
      await api.patch(`/admin/project-categories/${editing.value.slug}`, { name: name.value })
      toast.success('Category updated')
    } else {
      await api.post('/admin/project-categories', { name: name.value })
      toast.success('Category created')
    }
    showModal.value = false; load()
  } catch { error.value = 'Name may already exist.'; toast.error('Name may already exist.') }
  finally { saving.value = false }
}

async function remove(item: typeof items.value[0]) {
  if (!confirm('Delete this category? Projects in it must be reassigned first.')) return
  try {
    await api.delete(`/admin/project-categories/${item.slug}`)
    toast.success('Category deleted')
    load()
  } catch { toast.error('Cannot delete — category has projects.') }
}

onMounted(() => load())
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-heading">Project Categories</h1>
      <button class="btn-primary" @click="openCreate">+ New Category</button>
    </div>

    <div v-if="loading" class="text-body">Loading…</div>
    <div v-else-if="!items.length" class="text-body text-center py-20">No categories yet.</div>

    <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
      <div v-for="item in items" :key="item.slug" class="bg-surface rounded-xl p-4 flex items-center justify-between border border-border">
        <span class="text-heading font-medium">{{ item.name }}</span>
        <div class="flex gap-2">
          <button class="btn-ghost text-xs" @click="openEdit(item)">Edit</button>
          <button class="btn-ghost text-xs text-red-400" @click="remove(item)">Delete</button>
        </div>
      </div>
    </div>

    <AppModal v-model:show="showModal" :title="editing ? 'Edit Category' : 'New Category'" max-width="max-w-sm">
      <form class="p-6 space-y-4" @submit.prevent="save">
        <div>
          <label class="label">Name</label>
          <input v-model="name" class="input" required autofocus />
        </div>
        <p v-if="error" class="text-red-400 text-sm">{{ error }}</p>
        <div class="flex justify-end gap-3">
          <button type="button" class="btn-ghost" @click="showModal = false">Cancel</button>
          <button type="submit" class="btn-primary" :disabled="saving">{{ saving ? 'Saving…' : 'Save' }}</button>
        </div>
      </form>
    </AppModal>
  </div>
</template>
