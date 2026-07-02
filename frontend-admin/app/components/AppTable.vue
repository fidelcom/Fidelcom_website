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
      <thead>
        <tr class="border-b border-border bg-surface-alt">
          <th
            v-for="col in cols"
            :key="col.key"
            :class="['px-4 py-3 text-left text-[11px] font-semibold text-body/60 uppercase tracking-[0.08em]', col.class]"
          >
            {{ col.label }}
          </th>
          <th class="px-4 py-3 text-right text-[11px] font-semibold text-body/60 uppercase tracking-[0.08em]">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="loading">
          <td :colspan="cols.length + 1" class="px-4 py-12 text-center">
            <div class="flex flex-col items-center gap-3 text-body/50">
              <div class="w-5 h-5 border-2 border-primary border-t-transparent rounded-full animate-spin" />
              <span class="text-sm">Loading…</span>
            </div>
          </td>
        </tr>
        <tr v-else-if="!rows.length">
          <td :colspan="cols.length + 1" class="px-4 py-14 text-center">
            <div class="flex flex-col items-center gap-2 text-body/40">
              <Icon name="i-heroicons-inbox" class="w-8 h-8" />
              <span class="text-sm">No records found</span>
            </div>
          </td>
        </tr>
        <tr
          v-for="(row, i) in rows"
          v-else
          :key="(row.id as number) ?? i"
          class="border-t border-border hover:bg-surface-alt/60 transition-colors duration-100"
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
