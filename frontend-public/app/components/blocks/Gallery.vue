<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

interface GalleryItem { id: number; name: string; image: string; alt_text: string | null }

const heading = props.data.heading as string | undefined
const limit = (props.data.limit as number | undefined) ?? 12
const api = useApi()
const { assetUrl } = useAssetUrl()

const { data: items } = await useAsyncData('gallery-block', async () => {
  const res = await api.get<{ data: GalleryItem[] }>('/gallery', { limit })
  return res.data
})

const lightbox = ref<GalleryItem | null>(null)
const closeBtn = useTemplateRef<HTMLButtonElement>('closeBtn')

function openItem(item: GalleryItem) { lightbox.value = item }
function closeLightbox() { lightbox.value = null }

function onEscKey(e: KeyboardEvent) {
  if (e.key === 'Escape') closeLightbox()
}

watch(lightbox, async (val) => {
  if (val) {
    document.addEventListener('keydown', onEscKey)
    await nextTick()
    closeBtn.value?.focus()
  } else {
    document.removeEventListener('keydown', onEscKey)
  }
})

onUnmounted(() => document.removeEventListener('keydown', onEscKey))
</script>

<template>
  <section class="py-20 bg-surface">
    <div class="container mx-auto px-4">
      <h2 v-if="heading" class="text-3xl font-bold text-heading text-center mb-12">{{ heading }}</h2>
      <div class="columns-2 md:columns-3 lg:columns-4 gap-4 space-y-4">
        <div
          v-for="item in items"
          :key="item.id"
          role="button"
          tabindex="0"
          :aria-label="`View image: ${item.alt_text ?? item.name}`"
          class="break-inside-avoid group cursor-zoom-in rounded-xl overflow-hidden border border-border focus:outline-none focus-visible:ring-2 focus-visible:ring-primary"
          @click="openItem(item)"
          @keydown.enter="openItem(item)"
          @keydown.space.prevent="openItem(item)"
        >
          <img :src="assetUrl(item.image)" :alt="item.alt_text ?? item.name" class="w-full object-cover group-hover:scale-105 transition-transform duration-300" />
        </div>
      </div>
    </div>

    <!-- Lightbox -->
    <Teleport to="body">
      <Transition name="fade">
        <div
          v-if="lightbox"
          role="dialog"
          aria-modal="true"
          :aria-label="lightbox.alt_text ?? lightbox.name"
          class="fixed inset-0 z-50 bg-bg/95 flex items-center justify-center p-4"
          @click.self="closeLightbox"
        >
          <img :src="assetUrl(lightbox.image)" :alt="lightbox.alt_text ?? lightbox.name" class="max-w-full max-h-[90vh] rounded-xl shadow-2xl" />
          <button
            ref="closeBtn"
            aria-label="Close lightbox"
            class="absolute top-4 right-4 w-10 h-10 rounded-full bg-surface flex items-center justify-center text-heading hover:text-primary focus:outline-none focus-visible:ring-2 focus-visible:ring-primary"
            @click="closeLightbox"
          >
            <Icon name="i-heroicons-x-mark" class="w-5 h-5" aria-hidden="true" />
          </button>
        </div>
      </Transition>
    </Teleport>
  </section>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
