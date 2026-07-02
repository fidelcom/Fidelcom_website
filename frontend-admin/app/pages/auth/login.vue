<script setup lang="ts">
import { isApiError } from '../../composables/useApi'

definePageMeta({ layout: 'auth' })

const auth = reactive(useAuth())
const form = reactive({ email: '', password: '' })
const error = ref<string | null>(null)
const pending = ref(false)

async function submit() {
  error.value = null
  pending.value = true
  try {
    await auth.login(form)
    await navigateTo('/dashboard')
  } catch (err) {
    if (isApiError(err)) {
      error.value = err.data.error.message
    } else {
      error.value = 'Login failed. Please try again.'
    }
  } finally {
    pending.value = false
  }
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-bg px-4">
    <div class="w-full max-w-sm">
      <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-heading">Fidelcom Admin</h1>
        <p class="text-body text-sm mt-1">Sign in to manage your site</p>
      </div>

      <form class="bg-surface rounded-xl p-8 space-y-5" @submit.prevent="submit">
        <div v-if="error" class="text-red-400 text-sm bg-red-400/10 rounded-lg px-4 py-3">
          {{ error }}
        </div>

        <div class="space-y-1">
          <label for="email" class="text-sm text-heading font-medium">Email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            required
            autocomplete="email"
            class="w-full bg-bg border border-border rounded-lg px-4 py-3 text-heading text-sm focus:outline-none focus:border-primary"
          >
        </div>

        <div class="space-y-1">
          <label for="password" class="text-sm text-heading font-medium">Password</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            required
            autocomplete="current-password"
            class="w-full bg-bg border border-border rounded-lg px-4 py-3 text-heading text-sm focus:outline-none focus:border-primary"
          >
        </div>

        <button
          type="submit"
          :disabled="pending"
          class="w-full bg-primary text-white font-semibold rounded-lg py-3 text-sm hover:bg-primary-alt transition-colors disabled:opacity-60"
        >
          {{ pending ? 'Signing in…' : 'Sign in' }}
        </button>
      </form>
    </div>
  </div>
</template>
