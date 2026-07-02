<script setup lang="ts">
const api = useApi()

const { data: faqs } = await useAsyncData('all-faqs', async () => {
  const res = await api.get<{ data: { id: number; question: string; answer: string }[] }>('/faqs')
  return res.data
})

const open = ref<number | null>(null)
function toggle(id: number) { open.value = open.value === id ? null : id }

const { href: canonicalUrl } = useRequestURL()

useSeoMeta({
  title: 'FAQs | Fidelcom Systems',
  description: 'Frequently asked questions about Fidelcom Systems — our services, process, pricing, and more.',
  ogTitle: 'FAQs | Fidelcom Systems',
  ogDescription: 'Frequently asked questions about Fidelcom Systems — our services, process, pricing, and more.',
})

useHead({
  link: [{ rel: 'canonical', href: canonicalUrl }],
  script: computed(() => faqs.value?.length ? [{
    type: 'application/ld+json',
    innerHTML: JSON.stringify({
      '@context': 'https://schema.org',
      '@type': 'FAQPage',
      mainEntity: faqs.value!.map(faq => ({
        '@type': 'Question',
        name: faq.question,
        acceptedAnswer: { '@type': 'Answer', text: faq.answer },
      })),
    }),
  }] : []),
})
</script>

<template>
  <div>
    <section class="py-16 bg-surface border-b border-border">
      <div class="container mx-auto px-4 max-w-3xl">
        <h1 class="text-4xl font-bold text-heading mb-3">Frequently Asked Questions</h1>
        <p class="text-body">Everything you need to know about working with Fidelcom Systems.</p>
      </div>
    </section>

    <section class="py-16">
      <div class="container mx-auto px-4 max-w-3xl">
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
      </div>
    </section>
  </div>
</template>

<style scoped>
.accordion-enter-active, .accordion-leave-active { transition: all 0.25s ease; overflow: hidden; }
.accordion-enter-from, .accordion-leave-to { opacity: 0; max-height: 0; }
.accordion-enter-to, .accordion-leave-from { max-height: 500px; }
</style>
