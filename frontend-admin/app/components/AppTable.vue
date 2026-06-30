<script setup lang="ts">
defineProps<{
  cols: { key: string; label: string; class?: string }[]
  rows: Record<string, unknown>[]
  loading?: boolean
}>()
</script>

<template>
  <div class="overflow-x-auto rounded-xl border border-border">
    <table class="w-full text-sm">
      <thead class="bg-surface-alt text-body uppercase text-xs tracking-wider">
        <tr>
          <th
            v-for="col in cols"
            :key="col.key"
            :class="['px-4 py-3 text-left font-medium', col.class]"
          >
            {{ col.label }}
          </th>
          <th class="px-4 py-3 text-right">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="loading">
          <td :colspan="cols.length + 1" class="px-4 py-8 text-center text-body">Loading…</td>
        </tr>
        <tr v-else-if="!rows.length">
          <td :colspan="cols.length + 1" class="px-4 py-8 text-center text-body">No records found</td>
        </tr>
        <tr
          v-for="(row, i) in rows"
          v-else
          :key="(row.id as number) ?? i"
          class="border-t border-border hover:bg-surface-alt/50 transition-colors"
        >
          <td
            v-for="col in cols"
            :key="col.key"
            :class="['px-4 py-3 text-body', col.class]"
          >
            <slot :name="col.key" :row="row">{{ row[col.key] }}</slot>
          </td>
          <td class="px-4 py-3 text-right">
            <slot name="actions" :row="row" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
