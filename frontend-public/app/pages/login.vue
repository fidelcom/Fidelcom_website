<script setup lang="ts">
definePageMeta({ layout: false })

useHead({ title: 'Login — Fidelcom' })

const { login, loading, error, isAuthenticated } = useAuth()

onMounted(async () => {
  if (isAuthenticated.value) await navigateTo('/')
})

const email = ref('')
const password = ref('')
const showPassword = ref(false)

async function handleSubmit() {
  const ok = await login(email.value, password.value)
  if (ok) await navigateTo('/')
}
</script>

<template>
  <div class="min-h-screen bg-black flex flex-col items-center justify-center px-4">

    <!-- Subtle grid texture -->
    <div
      class="pointer-events-none fixed inset-0 opacity-[0.025]"
      style="background-image: repeating-linear-gradient(0deg, #fff 0, #fff 1px, transparent 1px, transparent 60px), repeating-linear-gradient(90deg, #fff 0, #fff 1px, transparent 1px, transparent 60px);"
    />

    <div class="relative w-full max-w-[400px]">

      <!-- Logo -->
      <NuxtLink to="/" class="flex items-center gap-3 justify-center mb-10 group">
        <div class="w-8 h-8 bg-primary flex items-center justify-center group-hover:bg-primary/80 transition-colors">
          <span class="text-white font-black text-sm leading-none" style="font-family: var(--font-display);">F</span>
        </div>
        <span class="text-white font-semibold text-lg tracking-[-0.01em]" style="font-family: var(--font-display);">Fidelcom</span>
      </NuxtLink>

      <!-- Card -->
      <div class="border border-white/[0.08] bg-white/[0.02] p-8">
        <h1 class="text-white font-bold text-xl mb-1 tracking-[-0.02em]">Sign in</h1>
        <p class="text-white/35 text-sm mb-8">Enter your credentials to continue.</p>

        <form class="flex flex-col gap-5" @submit.prevent="handleSubmit">

          <!-- Error message -->
          <div v-if="error" class="bg-red-500/10 border border-red-500/20 text-red-400 text-sm px-4 py-3">
            {{ error }}
          </div>

          <!-- Email -->
          <div class="flex flex-col gap-1.5">
            <label for="email" class="text-white/50 text-[11px] uppercase tracking-[0.12em] font-semibold">Email</label>
            <input
              id="email"
              v-model="email"
              type="email"
              autocomplete="email"
              required
              placeholder="you@example.com"
              class="w-full bg-white/[0.04] border border-white/[0.08] text-white placeholder-white/20 px-4 py-3 text-sm outline-none focus:border-primary/50 focus:bg-white/[0.06] transition-all"
            />
          </div>

          <!-- Password -->
          <div class="flex flex-col gap-1.5">
            <label for="password" class="text-white/50 text-[11px] uppercase tracking-[0.12em] font-semibold">Password</label>
            <div class="relative">
              <input
                id="password"
                v-model="password"
                :type="showPassword ? 'text' : 'password'"
                autocomplete="current-password"
                required
                placeholder="••••••••"
                class="w-full bg-white/[0.04] border border-white/[0.08] text-white placeholder-white/20 px-4 py-3 pr-11 text-sm outline-none focus:border-primary/50 focus:bg-white/[0.06] transition-all"
              />
              <button
                type="button"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-white/25 hover:text-white/60 transition-colors"
                :aria-label="showPassword ? 'Hide password' : 'Show password'"
                @click="showPassword = !showPassword"
              >
                <Icon :name="showPassword ? 'i-heroicons-eye-slash' : 'i-heroicons-eye'" class="w-4 h-4" />
              </button>
            </div>
          </div>

          <!-- Submit -->
          <button
            type="submit"
            :disabled="loading"
            class="w-full bg-primary text-white text-sm font-semibold py-3.5 hover:bg-primary/85 transition-colors tracking-wide disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2 mt-1"
          >
            <Icon v-if="loading" name="i-heroicons-arrow-path" class="w-4 h-4 animate-spin" />
            {{ loading ? 'Signing in…' : 'Sign in' }}
          </button>

        </form>
      </div>

      <!-- Back to site -->
      <div class="text-center mt-6">
        <NuxtLink to="/" class="text-white/25 text-xs hover:text-white/50 transition-colors tracking-wide">
          ← Back to site
        </NuxtLink>
      </div>
    </div>
  </div>
</template>
