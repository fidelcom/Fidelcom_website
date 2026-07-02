<script setup lang="ts">
const props = defineProps<{ page: number; lastPage: number; total: number }>()
const emit = defineEmits<{ 'update:page': [number] }>()
</script>

<template>
  <div v-if="lastPage > 1 || total > 0" class="flex items-center justify-between py-3 text-sm">
    <span class="text-body/60 text-xs tabular-nums">{{ total }} record{{ total !== 1 ? 's' : '' }}</span>
    <div class="flex items-center gap-1.5">
      <button
        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-border text-body text-xs hover:border-primary/50 hover:text-heading disabled:opacity-30 transition-all"
        :disabled="page <= 1"
        @click="emit('update:page', page - 1)"
      >
        <Icon name="i-heroicons-chevron-left" class="w-3.5 h-3.5" /> Prev
      </button>
      <span class="px-3 py-1.5 text-body text-xs tabular-nums">{{ page }} / {{ lastPage }}</span>
      <button
        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-border text-body text-xs hover:border-primary/50 hover:text-heading disabled:opacity-30 transition-all"
        :disabled="page >= lastPage"
        @click="emit('update:page', page + 1)"
      >
        Next <Icon name="i-heroicons-chevron-right" class="w-3.5 h-3.5" />
      </button>
    </div>
  </div>
</template>
