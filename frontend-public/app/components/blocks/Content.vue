<script setup lang="ts">
defineProps<{ data: Record<string, unknown> }>()
</script>

<template>
  <section class="py-20">
    <!-- Block: Content — implementation pending (Phase 3) -->
    <div class="container mx-auto px-4">
      <slot />
    </div>
  </section>
</template>
