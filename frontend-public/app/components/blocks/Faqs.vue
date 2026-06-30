<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

interface Faq { id: number; question: string; answer: string }

const heading = (props.data.heading as string | undefined) ?? 'Frequently Asked Questions'
const limit = (props.data.limit as number | undefined) ?? 8
const api = useApi()

const { data: faqs } = await useAsyncData('faqs-block', async () => {
  const res = await api.get<{ data: Faq[] }>('/faqs', { limit })
  return res.data
})

const open = ref<number | null>(null)
function toggle(id: number) { open.value = open.value === id ? null : id }
</script>

<template>
  <section class="py-20">
    <div class="container mx-auto px-4 max-w-3xl">
      <h2 class="text-3xl font-bold text-heading text-center mb-12">{{ heading }}</h2>
      <div class="space-y-3">
        <div v-for="faq in faqs" :key="faq.id" class="border border-border rounded-xl overflow-hidden">
          <button
            class="w-full flex items-center justify-between px-5 py-4 text-left text-heading font-medium hover:text-primary transition-colors"
            @click="toggle(faq.id)"
          >
            <span>{{ faq.question }}</span>
            <Icon :name="open === faq.id ? 'i-heroicons-chevron-up' : 'i-heroicons-chevron-down'" class="w-5 h-5 flex-shrink-0 ml-4 text-body" />
          </button>
          <Transition name="accordion">
            <div v-if="open === faq.id" class="px-5 pb-4 text-body leading-relaxed border-t border-border">
              <div class="pt-3">{{ faq.answer }}</div>
            </div>
          </Transition>
        </div>
      </div>
      <div class="text-center mt-10">
        <NuxtLink to="/faqs" class="text-primary font-medium hover:underline">View all FAQs →</NuxtLink>
      </div>
    </div>
  </section>
</template>

<style scoped>
.accordion-enter-active, .accordion-leave-active { transition: all 0.25s ease; overflow: hidden; }
.accordion-enter-from, .accordion-leave-to { opacity: 0; max-height: 0; }
.accordion-enter-to, .accordion-leave-from { max-height: 500px; }
</style>
