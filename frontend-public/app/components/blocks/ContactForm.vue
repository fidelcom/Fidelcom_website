<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

const heading = (props.data.heading as string | undefined) ?? 'Get In Touch'
const subheading = props.data.subheading as string | undefined

const api = useApi()
const form = reactive({ name: '', email: '', phone: '', subject: '', message: '', type: 'general' })
const loading = ref(false)
const sent = ref(false)
const error = ref<string | null>(null)

async function submit() {
  if (loading.value) return
  loading.value = true
  error.value = null
  try {
    await api.post('/inquiries', form)
    sent.value = true
  } catch {
    error.value = 'Something went wrong. Please try again or email us directly.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <section class="py-20">
    <div class="container mx-auto px-4">
      <div class="max-w-2xl mx-auto">
        <div class="text-center mb-10">
          <h2 class="text-3xl font-bold text-heading mb-3">{{ heading }}</h2>
          <p v-if="subheading" class="text-body">{{ subheading }}</p>
        </div>

        <div v-if="sent" class="bg-green-500/10 border border-green-500/30 rounded-2xl p-8 text-center">
          <Icon name="i-heroicons-check-circle" class="w-12 h-12 text-green-400 mx-auto mb-3" />
          <h3 class="text-heading font-semibold text-xl mb-2">Message Sent!</h3>
          <p class="text-body">We'll get back to you within 24 hours.</p>
        </div>

        <form v-else class="space-y-5" @submit.prevent="submit">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
              <label class="block text-sm font-medium text-heading mb-1.5">Name <span class="text-red-400">*</span></label>
              <input v-model="form.name" type="text" required placeholder="John Doe" class="w-full bg-surface border border-border rounded-xl px-4 py-2.5 text-heading placeholder-body/50 focus:outline-none focus:border-primary transition-colors" />
            </div>
            <div>
              <label class="block text-sm font-medium text-heading mb-1.5">Email <span class="text-red-400">*</span></label>
              <input v-model="form.email" type="email" required placeholder="you@example.com" class="w-full bg-surface border border-border rounded-xl px-4 py-2.5 text-heading placeholder-body/50 focus:outline-none focus:border-primary transition-colors" />
            </div>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div>
              <label class="block text-sm font-medium text-heading mb-1.5">Phone</label>
              <input v-model="form.phone" type="tel" placeholder="+234 800 000 0000" class="w-full bg-surface border border-border rounded-xl px-4 py-2.5 text-heading placeholder-body/50 focus:outline-none focus:border-primary transition-colors" />
            </div>
            <div>
              <label class="block text-sm font-medium text-heading mb-1.5">Subject</label>
              <input v-model="form.subject" type="text" placeholder="How can we help?" class="w-full bg-surface border border-border rounded-xl px-4 py-2.5 text-heading placeholder-body/50 focus:outline-none focus:border-primary transition-colors" />
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-heading mb-1.5">Message <span class="text-red-400">*</span></label>
            <textarea v-model="form.message" required rows="5" placeholder="Tell us about your project…" class="w-full bg-surface border border-border rounded-xl px-4 py-2.5 text-heading placeholder-body/50 focus:outline-none focus:border-primary transition-colors resize-none" />
          </div>

          <p v-if="error" class="text-red-400 text-sm">{{ error }}</p>

          <button type="submit" :disabled="loading" class="w-full bg-primary text-white py-3 rounded-xl font-semibold hover:bg-primary-alt transition-colors disabled:opacity-60">
            {{ loading ? 'Sending…' : 'Send Message' }}
          </button>
        </form>
      </div>
    </div>
  </section>
</template>
