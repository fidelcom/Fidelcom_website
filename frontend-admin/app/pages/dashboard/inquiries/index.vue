<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })
const api = useApi()

const items = ref<any[]>([])
const loading = ref(false)
const page = ref(1)
const meta = ref({ total: 0, last_page: 1, current_page: 1 })
const filter = ref<'all' | 'contact' | 'quote'>('all')

async function load() {
  loading.value = true
  try {
    const res = await api.get<{ data: any[]; meta: any }>('/api/v1/admin/inquiries', { page: page.value, type: filter.value === 'all' ? undefined : filter.value })
    items.value = res.data
    meta.value = res.meta
  } finally {
    loading.value = false }
}

async function updateStatus(id: string, status: string) {
  await api.patch(`/api/v1/admin/inquiries/${id}/status`, { status })
  load()
}

async function deleteInquiry(id: string) {
  if (confirm('Delete this inquiry?')) {
    await api.delete(`/api/v1/admin/inquiries/${id}`)
    load()
  }
}

async function exportCSV() {
  const url = `${useRuntimeConfig().public.apiBase}/api/v1/admin/inquiries/export`
  window.open(url, '_blank')
}

watch([page, filter], () => load())
onMounted(() => load())

const statusColors: Record<string, string> = {
  new: 'text-blue-400', in_progress: 'text-yellow-400', resolved: 'text-green-400',
}
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-heading">Inquiries</h1>
      <button class="btn-ghost" @click="exportCSV">Export CSV</button>
    </div>

    <div class="flex gap-2 mb-4">
      <button v-for="f in ['all', 'contact', 'quote']" :key="f"
        :class="['btn-ghost capitalize', filter === f && 'bg-primary/20 text-primary']"
        @click="filter = f as any"
      >{{ f }}</button>
    </div>

    <div class="overflow-x-auto rounded-xl border border-border">
      <table class="w-full text-sm">
        <thead class="bg-surface-alt text-body uppercase text-xs tracking-wider">
          <tr>
            <th class="px-4 py-3 text-left">Type</th>
            <th class="px-4 py-3 text-left">Name</th>
            <th class="px-4 py-3 text-left">Email</th>
            <th class="px-4 py-3 text-left">Subject / Service</th>
            <th class="px-4 py-3 text-left">Status</th>
            <th class="px-4 py-3 text-left">Date</th>
            <th class="px-4 py-3 text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="loading"><td colspan="7" class="px-4 py-8 text-center text-body">Loading…</td></tr>
          <tr v-else-if="!items.length"><td colspan="7" class="px-4 py-8 text-center text-body">No inquiries</td></tr>
          <tr v-for="row in items" v-else :key="row.composite_id" class="border-t border-border hover:bg-surface-alt/40">
            <td class="px-4 py-3">
              <span :class="row.type === 'contact' ? 'text-primary' : 'text-accent'" class="text-xs font-medium uppercase">{{ row.type }}</span>
            </td>
            <td class="px-4 py-3 text-body">{{ row.name }}</td>
            <td class="px-4 py-3 text-body">{{ row.email }}</td>
            <td class="px-4 py-3 text-body">{{ row.subject ?? row.service_type ?? '—' }}</td>
            <td class="px-4 py-3">
              <select
                :value="row.status"
                :class="['bg-transparent text-xs font-medium', statusColors[row.status] ?? 'text-body']"
                @change="updateStatus(row.composite_id, ($event.target as HTMLSelectElement).value)"
              >
                <option value="new">New</option>
                <option value="in_progress">In Progress</option>
                <option value="resolved">Resolved</option>
              </select>
            </td>
            <td class="px-4 py-3 text-body text-xs">{{ new Date(row.created_at).toLocaleDateString() }}</td>
            <td class="px-4 py-3 text-right">
              <button class="btn-danger text-xs" @click="deleteInquiry(row.composite_id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <AppPagination :page="meta.current_page" :last-page="meta.last_page" :total="meta.total" @update:page="p => { page = p }" />
  </div>
</template>
