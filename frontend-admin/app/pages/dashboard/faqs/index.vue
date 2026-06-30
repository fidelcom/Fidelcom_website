<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })
const { items, loading, saving, error, load, create, update, remove } = useCrud<{ id: number; question: string; answer: string }>('/api/v1/admin/faqs')
const showModal = ref(false)
const editing = ref<null | { id: number }>(null)
const form = reactive({ question: '', answer: '' })

function openCreate() { editing.value = null; Object.assign(form, { question: '', answer: '' }); showModal.value = true }
function openEdit(row: any) { editing.value = row; Object.assign(form, row); showModal.value = true }
async function save() {
  const r = editing.value ? await update(editing.value.id, form) : await create(form)
  if (r) { showModal.value = false; load() }
}
onMounted(() => load())
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-heading">FAQs</h1>
      <button class="btn-primary" @click="openCreate">+ Add FAQ</button>
    </div>
    <AppTable :cols="[{ key: 'question', label: 'Question' }, { key: 'answer', label: 'Answer' }]" :rows="items" :loading="loading">
      <template #answer="{ row }">{{ (row as any).answer?.slice(0, 80) }}…</template>
      <template #actions="{ row }">
        <button class="btn-ghost text-xs mr-2" @click="openEdit(row)">Edit</button>
        <button class="btn-danger text-xs" @click="confirm('Delete?') && remove((row as any).id)">Delete</button>
      </template>
    </AppTable>
    <AppModal v-model:show="showModal" :title="editing ? 'Edit FAQ' : 'New FAQ'" max-width="max-w-2xl">
      <form class="p-6 space-y-4" @submit.prevent="save">
        <div><label class="label">Question</label><input v-model="form.question" class="input" required /></div>
        <div><label class="label">Answer</label><textarea v-model="form.answer" class="input" rows="5" required /></div>
        <div v-if="error" class="text-red-400 text-sm">{{ error }}</div>
        <div class="flex justify-end gap-3"><button type="button" class="btn-ghost" @click="showModal = false">Cancel</button><button type="submit" class="btn-primary" :disabled="saving">{{ saving ? 'Saving…' : 'Save' }}</button></div>
      </form>
    </AppModal>
  </div>
</template>
