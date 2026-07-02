<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })

import type { Inquiry } from '../../../../../shared/types/api'

const api = useApi()

const items = ref<Inquiry[]>([])
const loading = ref(false)
const page = ref(1)
const meta = ref({ total: 0, last_page: 1, current_page: 1 })
const filter = ref<'all' | 'contact' | 'quote'>('all')

async function load() {
  loading.value = true
  try {
    const res = await api.get<{ data: Inquiry[]; meta: any }>('/admin/inquiries', {
      page: page.value,
      type: filter.value === 'all' ? undefined : filter.value,
    })
    items.value = res.data
    meta.value = res.meta
  } finally {
    loading.value = false
  }
}

async function updateStatus(id: number, status: string) {
  await api.patch(`/admin/inquiries/${id}/status`, { status })
  load()
}

async function deleteInquiry(id: number) {
  if (confirm('Delete this inquiry?')) {
    await api.delete(`/admin/inquiries/${id}`)
    load()
  }
}

async function exportCSV() {
  const url = `${useRuntimeConfig().public.apiBase}/admin/inquiries/export`
  window.open(url, '_blank')
}

watch([page, filter], () => load())
onMounted(() => load())

const STATUS_COLORS: Record<string, string> = {
  new:         'text-blue-400',
  in_progress: 'text-amber-400',
  resolved:    'text-green-400',
}
const STATUS_LABELS: Record<string, string> = {
  new:         'New',
  in_progress: 'In Progress',
  resolved:    'Resolved',
}
</script>

<template>
  <div>
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-2xl font-bold text-heading">Inquiries</h1>
      <button class="btn-ghost" @click="exportCSV">Export CSV</button>
    </div>

    <div class="flex gap-2 mb-4">
      <button
        v-for="f in ['all', 'contact', 'quote']"
        :key="f"
        :class="['btn-ghost capitalize', filter === f && 'bg-primary/20 text-primary']"
        @click="filter = f as typeof filter"
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
          <tr v-if="loading">
            <td colspan="7" class="px-4 py-8 text-center text-body">Loading…</td>
          </tr>
          <tr v-else-if="!items.length">
            <td colspan="7" class="px-4 py-8 text-center text-body">No inquiries found.</td>
          </tr>
          <tr
            v-for="row in items"
            v-else
            :key="row.id"
            class="border-t border-border hover:bg-surface-alt/40"
          >
            <td class="px-4 py-3">
              <span :class="row.source === 'contact' ? 'text-primary' : 'text-accent'" class="text-xs font-semibold uppercase">
                {{ row.source }}
              </span>
            </td>
            <td class="px-4 py-3 text-body">{{ row.name }}</td>
            <td class="px-4 py-3 text-body">
              <a :href="`mailto:${row.email}`" class="hover:text-primary transition-colors">{{ row.email }}</a>
            </td>
            <td class="px-4 py-3 text-body">{{ row.subject ?? row.service ?? '—' }}</td>
            <td class="px-4 py-3">
              <select
                :value="row.status"
                :class="['bg-transparent text-xs font-medium', STATUS_COLORS[row.status] ?? 'text-body']"
                @change="updateStatus(row.id, ($event.target as HTMLSelectElement).value)"
              >
                <option v-for="(label, val) in STATUS_LABELS" :key="val" :value="val">{{ label }}</option>
              </select>
            </td>
            <td class="px-4 py-3 text-body text-xs tabular-nums">{{ new Date(row.created_at).toLocaleDateString() }}</td>
            <td class="px-4 py-3 text-right">
              <button class="btn-danger text-xs" @click="deleteInquiry(row.id)">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <AppPagination :page="meta.current_page" :last-page="meta.last_page" :total="meta.total" @update:page="p => { page = p }" />
  </div>
</template>
