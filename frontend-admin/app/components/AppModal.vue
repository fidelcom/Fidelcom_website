<script setup lang="ts">
defineProps<{ title: string; show: boolean; maxWidth?: string }>()
const emit = defineEmits<{ 'update:show': [boolean] }>()
</script>

<template>
  <Teleport to="body">
    <Transition name="modal">
      <div
        v-if="show"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        @click.self="emit('update:show', false)"
      >
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" />
        <div
          :class="['relative bg-surface border border-border rounded-2xl shadow-2xl shadow-black/40 w-full overflow-hidden flex flex-col max-h-[90vh]', maxWidth ?? 'max-w-xl']"
        >
          <div class="flex items-center justify-between px-6 py-4 border-b border-border flex-shrink-0">
            <h2 class="text-heading font-semibold text-base">{{ title }}</h2>
            <button
              class="w-7 h-7 rounded-lg flex items-center justify-center text-body hover:text-heading hover:bg-surface-alt transition-all"
              aria-label="Close"
              @click="emit('update:show', false)"
            >
              <Icon name="i-heroicons-x-mark" class="w-4 h-4" />
            </button>
          </div>
          <div class="overflow-y-auto flex-1">
            <slot />
          </div>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<style scoped>
.modal-enter-active, .modal-leave-active { transition: opacity 0.18s ease; }
.modal-enter-from, .modal-leave-to { opacity: 0; }
</style>
