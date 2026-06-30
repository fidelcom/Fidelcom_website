<script setup lang="ts">
const props = defineProps<{ page: number; lastPage: number; total: number }>()
const emit = defineEmits<{ 'update:page': [number] }>()
</script>

<template>
  <div class="flex items-center justify-between py-3 text-sm text-body">
    <span>{{ total }} total</span>
    <div class="flex gap-2">
      <button
        class="px-3 py-1 rounded border border-border hover:border-primary disabled:opacity-40 transition-colors"
        :disabled="page <= 1"
        @click="emit('update:page', page - 1)"
      >Prev</button>
      <span class="px-3 py-1">{{ page }} / {{ lastPage }}</span>
      <button
        class="px-3 py-1 rounded border border-border hover:border-primary disabled:opacity-40 transition-colors"
        :disabled="page >= lastPage"
        @click="emit('update:page', page + 1)"
      >Next</button>
    </div>
  </div>
</template>
