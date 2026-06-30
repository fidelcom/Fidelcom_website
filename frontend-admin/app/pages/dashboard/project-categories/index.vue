<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })
const api = useApi()
const items = ref<{ id: number; name: string }[]>([])
const loading = ref(true)
const showModal = ref(false)
const saving = ref(false)
const editing = ref<{ id: number; name: string } | null>(null)
const name = ref('')
const error = ref<string | null>(null)

async function load() {
  loading.value = true
  items.value = await api.get<{ data: { id: number; name: string }[] }>('/api/v1/admin/project-categories').then(r => r.data).finally(() => loading.value = false)
}

function openCreate() { editing.value = null; name.value = ''; error.value = null; showModal.value = true }
function openEdit(item: typeof items.value[0]) { editing.value = item; name.value = item.name; error.value = null; showModal.value = true }

async function save() {
  if (!name.value.trim()) return
  saving.value = true; error.value = null
  try {
    if (editing.value) {
      await api.patch(`/api/v1/admin/project-categories/${editing.value.id}`, { name: name.value })
    } else {
      await api.post('/api/v1/admin/project-categories', { name: name.value })
    }
    showModal.value = false; load()
  } catch { error.value = 'Name may already exist.' }
  finally { saving.value = false }
}

async function remove(id: number) {
  if (!confirm('Delete this category? Projects in it must be reassigned first.')) return
  await api.delete(`/api/v1/admin/project-categories/${id}`).catch(() => alert('Cannot delete — category has projects.'))
  load()
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
      <div v-for="item in items" :key="item.id" class="bg-surface rounded-xl p-4 flex items-center justify-between border border-border">
        <span class="text-heading font-medium">{{ item.name }}</span>
        <div class="flex gap-2">
          <button class="btn-ghost text-xs" @click="openEdit(item)">Edit</button>
          <button class="btn-ghost text-xs text-red-400" @click="remove(item.id)">Delete</button>
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
