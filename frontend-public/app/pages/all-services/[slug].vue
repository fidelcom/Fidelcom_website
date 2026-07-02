<script setup lang="ts">
const route = useRoute()
const api = useApi()
const { assetUrl } = useAssetUrl()

const { data: service, error } = await useAsyncData(`service-${route.params.slug}`, async () => {
  const res = await api.get<{ data: { id: number; title: string; slug: string; body: string; excerpt: string; image: string | null; icon: string | null; meta_title: string | null; meta_description: string | null } }>(`/services/${route.params.slug}`)
  return res.data
})

if (error.value) throw createError({ statusCode: 404, message: 'Service not found' })

const ogImageUrl = computed(() => service.value?.image ? assetUrl(service.value.image) : undefined)

const { href: canonicalUrl, origin } = useRequestURL()

useSeoMeta({
  title: service.value?.meta_title ?? `${service.value?.title} | Fidelcom Systems`,
  description: service.value?.meta_description ?? service.value?.excerpt ?? '',
  ogTitle: service.value?.meta_title ?? service.value?.title,
  ogDescription: service.value?.meta_description ?? service.value?.excerpt,
  ogType: 'website',
  ogImage: ogImageUrl.value,
  twitterCard: 'summary_large_image',
})

useHead({
  link: [{ rel: 'canonical', href: canonicalUrl }],
  script: computed(() => service.value ? [{
    type: 'application/ld+json',
    innerHTML: JSON.stringify({
      '@context': 'https://schema.org',
      '@type': 'Service',
      name: service.value!.title,
      description: service.value!.meta_description ?? service.value!.excerpt ?? '',
      provider: {
        '@type': 'Organization',
        name: 'Fidelcom Systems',
        url: origin,
      },
      url: canonicalUrl,
      areaServed: { '@type': 'Country', name: 'Nigeria' },
    }),
  }] : []),
})

// Quote form
const { data: settings } = useNuxtData<{ phone: string; email: string }>('settings')

const budgetOptions = [
  'Under ₦500,000',
  '₦500,000 – ₦1,000,000',
  '₦1,000,000 – ₦3,000,000',
  '₦3,000,000 – ₦10,000,000',
  'Above ₦10,000,000',
  "Let's discuss",
]

const form = reactive({
  name: '',
  email: '',
  phone: '',
  company: '',
  budget: '',
  message: '',
})

const loading = ref(false)
const sent = ref(false)
const formError = ref<string | null>(null)
const quoteSection = useTemplateRef<HTMLElement>('quoteSection')

function scrollToQuote() {
  quoteSection.value?.scrollIntoView({ behavior: 'smooth', block: 'start' })
}

async function submit() {
  if (loading.value) return
  loading.value = true
  formError.value = null
  try {
    await api.post('/inquiries/quote', {
      ...form,
      service: service.value?.title ?? '',
    })
    sent.value = true
  } catch {
    formError.value = 'Something went wrong. Please try again or contact us directly.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div>
    <Breadcrumbs :crumbs="[{ label: 'Services', to: '/all-services' }, { label: service?.title ?? 'Service' }]" />

    <div class="py-16">
      <div class="container mx-auto px-4 max-w-4xl">
        <div v-if="service">

          <!-- Service header -->
          <div class="flex items-center gap-4 mb-6">
            <div v-if="service.icon" class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center flex-shrink-0">
              <Icon :name="service.icon" class="w-7 h-7 text-primary" />
            </div>
            <h1 class="text-4xl font-bold text-heading">{{ service.title }}</h1>
          </div>
          <p class="text-body text-xl leading-relaxed mb-8">{{ service.excerpt }}</p>
          <img v-if="service.image" :src="assetUrl(service.image)" :alt="service.title" class="w-full rounded-2xl mb-10 object-cover max-h-80" />

          <!-- Body content -->
          <!-- eslint-disable-next-line vue/no-v-html -->
          <div class="prose max-w-none text-body [&_a]:text-primary [&_h2]:text-heading [&_h3]:text-heading leading-relaxed" v-html="service.body" />

          <!-- CTA banner → scrolls to the inline form -->
          <div class="mt-14 p-8 bg-primary rounded-2xl text-center">
            <h2 class="text-white text-2xl font-bold mb-3">Ready to get started with {{ service.title }}?</h2>
            <p class="text-white/80 mb-6 max-w-xl mx-auto">
              Tell us about your project and we'll put together a tailored proposal within 24 hours — no obligation.
            </p>
            <button
              class="bg-white text-primary px-6 py-3 rounded-xl font-semibold hover:bg-white/90 transition-colors"
              @click="scrollToQuote"
            >
              Request a Quote
            </button>
          </div>

        </div>
      </div>
    </div>

    <!-- Inline quote section -->
    <section ref="quoteSection" class="py-20 bg-surface border-t border-border" aria-label="Request a quote">
      <div class="container mx-auto px-4 max-w-5xl">

        <div class="mb-10">
          <p class="text-primary text-sm font-medium uppercase tracking-wider mb-2">Get a tailored quote</p>
          <h2 class="text-3xl font-bold text-heading mb-3">{{ service?.title }} — Request a Quote</h2>
          <p class="text-body max-w-xl">Fill in your details below. The service is already set — just tell us about your project and we'll be in touch within 24 hours.</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-12">

          <!-- Form -->
          <div class="lg:col-span-2">

            <!-- Success -->
            <div v-if="sent" class="bg-green-500/10 border border-green-500/30 rounded-2xl p-10 text-center">
              <Icon name="i-heroicons-check-circle" class="w-14 h-14 text-green-400 mx-auto mb-4" />
              <h3 class="text-heading font-bold text-2xl mb-2">Quote Request Sent!</h3>
              <p class="text-body mb-1">We've received your request for <strong class="text-heading">{{ service?.title }}</strong>.</p>
              <p class="text-body">We'll be in touch within <strong class="text-heading">24 hours</strong> with a tailored proposal.</p>
            </div>

            <form v-else class="space-y-5" @submit.prevent="submit">

              <!-- Service field — locked -->
              <div>
                <label class="block text-sm font-medium text-heading mb-1.5">Service</label>
                <div class="flex items-center gap-2 w-full bg-bg border border-border rounded-xl px-4 py-2.5 text-heading text-sm">
                  <Icon v-if="service?.icon" :name="service.icon" class="w-4 h-4 text-primary flex-shrink-0" />
                  <span class="flex-1">{{ service?.title }}</span>
                  <Icon name="i-heroicons-lock-closed" class="w-3.5 h-3.5 text-body/50 flex-shrink-0" />
                </div>
              </div>

              <!-- Personal details -->
              <div class="grid sm:grid-cols-2 gap-5">
                <div>
                  <label class="block text-sm font-medium text-heading mb-1.5">Full Name <span class="text-red-400">*</span></label>
                  <input v-model="form.name" type="text" required placeholder="Jane Okonkwo" class="field" />
                </div>
                <div>
                  <label class="block text-sm font-medium text-heading mb-1.5">Email Address <span class="text-red-400">*</span></label>
                  <input v-model="form.email" type="email" required placeholder="jane@company.com" class="field" />
                </div>
                <div>
                  <label class="block text-sm font-medium text-heading mb-1.5">Phone Number <span class="text-red-400">*</span></label>
                  <input v-model="form.phone" type="tel" required placeholder="+234 800 000 0000" class="field" />
                </div>
                <div>
                  <label class="block text-sm font-medium text-heading mb-1.5">Company / Organisation</label>
                  <input v-model="form.company" type="text" placeholder="Acme Ltd (optional)" class="field" />
                </div>
              </div>

              <div>
                <label class="block text-sm font-medium text-heading mb-1.5">Estimated Budget</label>
                <select v-model="form.budget" class="field">
                  <option value="">Not sure yet</option>
                  <option v-for="opt in budgetOptions" :key="opt" :value="opt">{{ opt }}</option>
                </select>
              </div>

              <div>
                <label class="block text-sm font-medium text-heading mb-1.5">Project Description <span class="text-red-400">*</span></label>
                <textarea
                  v-model="form.message"
                  required
                  rows="5"
                  placeholder="Describe your goals, timeline, or any specific requirements…"
                  class="field resize-none"
                />
                <p class="text-xs text-body mt-1.5">The more detail you share, the more accurate our quote will be.</p>
              </div>

              <p v-if="formError" class="text-red-400 text-sm bg-red-400/10 border border-red-400/30 rounded-xl px-4 py-3">{{ formError }}</p>

              <button
                type="submit"
                :disabled="loading"
                class="w-full bg-primary text-white py-3.5 rounded-xl font-semibold hover:bg-primary-alt transition-colors disabled:opacity-60 flex items-center justify-center gap-2"
              >
                <Icon v-if="loading" name="i-heroicons-arrow-path" class="w-4 h-4 animate-spin" />
                {{ loading ? 'Sending…' : 'Submit Quote Request' }}
              </button>

              <p class="text-xs text-body text-center">
                No obligation. We'll review your request and respond within 24 hours.
              </p>
            </form>
          </div>

          <!-- Sidebar -->
          <aside class="space-y-5">
            <div class="bg-bg rounded-2xl border border-border p-5">
              <h3 class="text-heading font-semibold mb-4 text-sm uppercase tracking-wide">What happens next?</h3>
              <ol class="space-y-4">
                <li class="flex gap-3">
                  <span class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center text-primary text-xs font-bold flex-shrink-0 mt-0.5">1</span>
                  <div>
                    <p class="text-heading text-sm font-medium">We review your request</p>
                    <p class="text-body text-xs mt-0.5">Our team reads every submission within a few hours.</p>
                  </div>
                </li>
                <li class="flex gap-3">
                  <span class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center text-primary text-xs font-bold flex-shrink-0 mt-0.5">2</span>
                  <div>
                    <p class="text-heading text-sm font-medium">We reach out within 24 hours</p>
                    <p class="text-body text-xs mt-0.5">A team member will contact you to discuss your project in detail.</p>
                  </div>
                </li>
                <li class="flex gap-3">
                  <span class="w-5 h-5 bg-primary/10 rounded-full flex items-center justify-center text-primary text-xs font-bold flex-shrink-0 mt-0.5">3</span>
                  <div>
                    <p class="text-heading text-sm font-medium">You receive a tailored proposal</p>
                    <p class="text-body text-xs mt-0.5">Clear scope, timeline, and investment — no surprises.</p>
                  </div>
                </li>
              </ol>
            </div>

            <div v-if="settings?.phone || settings?.email" class="bg-bg rounded-2xl border border-border p-5 space-y-3">
              <h3 class="text-heading font-semibold text-sm uppercase tracking-wide">Prefer to talk?</h3>
              <a v-if="settings?.phone" :href="`tel:${settings.phone}`" class="flex items-center gap-2.5 text-sm text-body hover:text-primary transition-colors">
                <Icon name="i-heroicons-phone" class="w-4 h-4 text-primary" />
                {{ settings.phone }}
              </a>
              <a v-if="settings?.email" :href="`mailto:${settings.email}`" class="flex items-center gap-2.5 text-sm text-body hover:text-primary transition-colors">
                <Icon name="i-heroicons-envelope" class="w-4 h-4 text-primary" />
                {{ settings.email }}
              </a>
            </div>
          </aside>
        </div>
      </div>
    </section>
  </div>
</template>

<style scoped>
@reference "../../assets/css/main.css";
.field {
  @apply w-full bg-bg border border-border rounded-xl px-4 py-2.5 text-heading placeholder-body/50
         focus:outline-none focus:border-primary transition-colors text-sm;
}
</style>
