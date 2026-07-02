<script setup lang="ts">
const accepted = useCookie('cookie_consent', {
  maxAge: 60 * 60 * 24 * 365,
  sameSite: 'lax',
})
const visible = ref(!accepted.value)

function accept() {
  accepted.value = 'true'
  visible.value = false
}

function decline() {
  accepted.value = 'false'
  visible.value = false
}
</script>

<template>
  <Transition
    enter-active-class="transition-transform duration-300 ease-out"
    enter-from-class="translate-y-full"
    leave-active-class="transition-transform duration-200 ease-in"
    leave-to-class="translate-y-full"
  >
    <div
      v-if="visible"
      class="fixed bottom-0 left-0 right-0 z-50 bg-surface border-t border-border shadow-2xl"
      role="dialog"
      aria-label="Cookie consent"
    >
      <div class="container mx-auto px-4 py-4 flex flex-col sm:flex-row items-start sm:items-center gap-4">
        <div class="flex-1">
          <p class="text-heading font-medium text-sm mb-1">We use cookies</p>
          <p class="text-body text-xs leading-relaxed">
            This site uses cookies to improve your experience and comply with the Nigeria Data Protection Regulation (NDPR).
            By continuing, you consent to our use of cookies.
          </p>
        </div>
        <div class="flex gap-3 flex-shrink-0">
          <button
            class="px-4 py-2 text-sm rounded-lg border border-border text-body hover:border-primary hover:text-heading transition-colors"
            @click="decline"
          >
            Decline
          </button>
          <button
            class="px-4 py-2 text-sm rounded-lg bg-primary text-white font-medium hover:bg-primary-alt transition-colors"
            @click="accept"
          >
            Accept All
          </button>
        </div>
      </div>
    </div>
  </Transition>
</template>
