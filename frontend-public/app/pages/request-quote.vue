<script setup lang="ts">
const api = useApi()

const { data: services } = await useAsyncData('services-list', async () => {
  const res = await api.get<{ data: { id: number; title: string; slug: string }[] }>('/services')
  return res.data ?? []
})

const { data: settings } = useNuxtData<{ phone: string; email: string; address: string }>('settings')

useSeoMeta({
  title: 'Request a Quote | Fidelcom Systems Limited',
  description: 'Tell us about your project and get a tailored quote from Fidelcom Systems Limited. We respond within 24 hours.',
  ogTitle: 'Request a Quote | Fidelcom Systems Limited',
  ogDescription: 'Tell us about your project and get a tailored quote from Fidelcom Systems Limited. We respond within 24 hours.',
})

useHead({
  script: [{
    type: 'application/ld+json',
    innerHTML: JSON.stringify({
      '@context': 'https://schema.org',
      '@type': 'ContactPage',
      name: 'Request a Quote – Fidelcom Systems Limited',
      url: 'https://fidelcom.org/request-quote',
    }),
  }],
})

const budgetOptions = [
  'Under ₦500,000',
  '₦500,000 – ₦1,000,000',
  '₦1,000,000 – ₦3,000,000',
  '₦3,000,000 – ₦10,000,000',
  'Above ₦10,000,000',
  'Let\'s discuss',
]

const form = reactive({
  name: '',
  email: '',
  phone: '',
  company: '',
  service: '',
  budget: '',
  message: '',
})

const loading = ref(false)
const sent = ref(false)
const error = ref<string | null>(null)

async function submit() {
  if (loading.value) return
  loading.value = true
  error.value = null
  try {
    await api.post('/inquiries/quote', form)
    sent.value = true
    window.scrollTo({ top: 0, behavior: 'smooth' })
  } catch {
    error.value = 'Something went wrong. Please try again or email us directly.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div>
    <Breadcrumbs :crumbs="[{ label: 'Request a Quote' }]" />

    <!-- Hero -->
    <section class="py-14 bg-surface border-b border-border">
      <div class="container mx-auto px-4 max-w-5xl">
        <div class="flex items-start gap-4">
          <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center flex-shrink-0 mt-1">
            <Icon name="i-heroicons-document-text" class="w-6 h-6 text-primary" />
          </div>
          <div>
            <h1 class="text-4xl font-bold text-heading mb-3">Request a Quote</h1>
            <p class="text-body text-lg max-w-2xl">
              Tell us about your project and we'll put together a tailored proposal. No obligation, no sales pressure — just a clear picture of what's possible.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Content -->
    <section class="py-16">
      <div class="container mx-auto px-4 max-w-5xl">
        <div class="grid lg:grid-cols-3 gap-12">

          <!-- Form -->
          <div class="lg:col-span-2">

            <!-- Success state -->
            <div v-if="sent" class="bg-green-500/10 border border-green-500/30 rounded-2xl p-10 text-center">
              <Icon name="i-heroicons-check-circle" class="w-14 h-14 text-green-400 mx-auto mb-4" />
              <h2 class="text-heading font-bold text-2xl mb-2">Quote Request Received!</h2>
              <p class="text-body mb-6">We'll review your requirements and get back to you within <strong class="text-heading">24 hours</strong> with a tailored proposal.</p>
              <NuxtLink
                to="/"
                class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-xl font-medium hover:bg-primary-alt transition-colors"
              >
                <Icon name="i-heroicons-home" class="w-4 h-4" />
                Back to Home
              </NuxtLink>
            </div>

            <form v-else class="space-y-6" @submit.prevent="submit">
              <!-- Personal details -->
              <fieldset class="space-y-4">
                <legend class="text-heading font-semibold text-lg mb-4 pb-2 border-b border-border w-full">Your Details</legend>
                <div class="grid sm:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-heading mb-1.5">
                      Full Name <span class="text-red-400">*</span>
                    </label>
                    <input
                      v-model="form.name"
                      type="text"
                      required
                      placeholder="Jane Okonkwo"
                      class="input"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-heading mb-1.5">
                      Email Address <span class="text-red-400">*</span>
                    </label>
                    <input
                      v-model="form.email"
                      type="email"
                      required
                      placeholder="jane@company.com"
                      class="input"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-heading mb-1.5">
                      Phone Number <span class="text-red-400">*</span>
                    </label>
                    <input
                      v-model="form.phone"
                      type="tel"
                      required
                      placeholder="+234 800 000 0000"
                      class="input"
                    />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-heading mb-1.5">Company / Organisation</label>
                    <input
                      v-model="form.company"
                      type="text"
                      placeholder="Acme Ltd (optional)"
                      class="input"
                    />
                  </div>
                </div>
              </fieldset>

              <!-- Project details -->
              <fieldset class="space-y-4">
                <legend class="text-heading font-semibold text-lg mb-4 pb-2 border-b border-border w-full">Project Details</legend>
                <div class="grid sm:grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-heading mb-1.5">
                      Service Needed <span class="text-red-400">*</span>
                    </label>
                    <select v-model="form.service" required class="input">
                      <option value="" disabled>Select a service…</option>
                      <option v-if="services?.length" v-for="svc in services" :key="svc.id" :value="svc.title">
                        {{ svc.title }}
                      </option>
                      <option v-else value="Other">Other / Not listed</option>
                      <option value="Other">Other / Not listed</option>
                    </select>
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-heading mb-1.5">Estimated Budget</label>
                    <select v-model="form.budget" class="input">
                      <option value="">Not sure yet</option>
                      <option v-for="opt in budgetOptions" :key="opt" :value="opt">{{ opt }}</option>
                    </select>
                  </div>
                </div>
                <div>
                  <label class="block text-sm font-medium text-heading mb-1.5">
                    Project Description <span class="text-red-400">*</span>
                  </label>
                  <textarea
                    v-model="form.message"
                    required
                    rows="6"
                    placeholder="Describe your project goals, timeline, any specific requirements, or anything else that would help us understand your needs…"
                    class="input resize-none"
                  />
                  <p class="text-xs text-body mt-1.5">The more detail you share, the more accurate our quote will be.</p>
                </div>
              </fieldset>

              <p v-if="error" class="text-red-400 text-sm bg-red-400/10 border border-red-400/30 rounded-xl px-4 py-3">{{ error }}</p>

              <button
                type="submit"
                :disabled="loading"
                class="w-full bg-primary text-white py-3.5 rounded-xl font-semibold hover:bg-primary-alt transition-colors disabled:opacity-60 flex items-center justify-center gap-2"
              >
                <Icon v-if="loading" name="i-heroicons-arrow-path" class="w-4 h-4 animate-spin" />
                {{ loading ? 'Sending…' : 'Submit Quote Request' }}
              </button>

              <p class="text-xs text-body text-center">
                By submitting this form you agree to be contacted by Fidelcom Systems Limited. We never share your data with third parties.
              </p>
            </form>
          </div>

          <!-- Sidebar -->
          <aside class="space-y-6">
            <!-- What to expect -->
            <div class="bg-surface rounded-2xl border border-border p-6">
              <h2 class="text-heading font-semibold mb-4">What happens next?</h2>
              <ol class="space-y-4">
                <li class="flex gap-3">
                  <span class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center text-primary text-xs font-bold flex-shrink-0 mt-0.5">1</span>
                  <div>
                    <p class="text-heading text-sm font-medium">We review your request</p>
                    <p class="text-body text-xs mt-0.5">Our team reads every submission within a few hours.</p>
                  </div>
                </li>
                <li class="flex gap-3">
                  <span class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center text-primary text-xs font-bold flex-shrink-0 mt-0.5">2</span>
                  <div>
                    <p class="text-heading text-sm font-medium">We reach out within 24 hours</p>
                    <p class="text-body text-xs mt-0.5">A member of our team will contact you to discuss the project in more detail.</p>
                  </div>
                </li>
                <li class="flex gap-3">
                  <span class="w-6 h-6 bg-primary/10 rounded-full flex items-center justify-center text-primary text-xs font-bold flex-shrink-0 mt-0.5">3</span>
                  <div>
                    <p class="text-heading text-sm font-medium">You receive a tailored proposal</p>
                    <p class="text-body text-xs mt-0.5">A clear scope, timeline, and investment breakdown — no surprises.</p>
                  </div>
                </li>
              </ol>
            </div>

            <!-- Contact alternatives -->
            <div class="bg-surface rounded-2xl border border-border p-6 space-y-4">
              <h2 class="text-heading font-semibold">Prefer to talk?</h2>
              <a
                v-if="settings?.phone"
                :href="`tel:${settings.phone}`"
                class="flex items-center gap-3 text-sm text-body hover:text-primary transition-colors"
              >
                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                  <Icon name="i-heroicons-phone" class="w-4 h-4 text-primary" />
                </div>
                {{ settings.phone }}
              </a>
              <a
                v-if="settings?.email"
                :href="`mailto:${settings.email}`"
                class="flex items-center gap-3 text-sm text-body hover:text-primary transition-colors"
              >
                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                  <Icon name="i-heroicons-envelope" class="w-4 h-4 text-primary" />
                </div>
                {{ settings.email }}
              </a>
              <NuxtLink
                to="/contact-us"
                class="flex items-center gap-3 text-sm text-body hover:text-primary transition-colors"
              >
                <div class="w-8 h-8 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                  <Icon name="i-heroicons-chat-bubble-left-right" class="w-4 h-4 text-primary" />
                </div>
                Send a general message
              </NuxtLink>
            </div>

            <!-- Trust signals -->
            <div class="bg-primary/5 border border-primary/20 rounded-2xl p-6">
              <ul class="space-y-3">
                <li class="flex items-start gap-2 text-sm text-body">
                  <Icon name="i-heroicons-check-badge" class="w-4 h-4 text-primary flex-shrink-0 mt-0.5" />
                  10+ years delivering digital projects in Nigeria
                </li>
                <li class="flex items-start gap-2 text-sm text-body">
                  <Icon name="i-heroicons-check-badge" class="w-4 h-4 text-primary flex-shrink-0 mt-0.5" />
                  200+ successful projects delivered
                </li>
                <li class="flex items-start gap-2 text-sm text-body">
                  <Icon name="i-heroicons-check-badge" class="w-4 h-4 text-primary flex-shrink-0 mt-0.5" />
                  No obligation — free initial consultation
                </li>
                <li class="flex items-start gap-2 text-sm text-body">
                  <Icon name="i-heroicons-check-badge" class="w-4 h-4 text-primary flex-shrink-0 mt-0.5" />
                  Clear pricing, no hidden fees
                </li>
              </ul>
            </div>
          </aside>

        </div>
      </div>
    </section>
  </div>
</template>

<style scoped>
@reference "../assets/css/main.css";
.input {
  @apply w-full bg-bg border border-border rounded-xl px-4 py-2.5 text-heading placeholder-body/50
         focus:outline-none focus:border-primary transition-colors text-sm;
}
</style>
