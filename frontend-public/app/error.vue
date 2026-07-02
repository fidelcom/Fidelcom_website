<script setup lang="ts">
const props = defineProps<{ error: { statusCode: number; statusMessage?: string; message?: string } }>()

const is404 = computed(() => props.error.statusCode === 404)

useSeoMeta({
  title: is404.value ? 'Page Not Found | Fidelcom' : 'Something Went Wrong | Fidelcom',
  robots: 'noindex',
})

function handleError() {
  clearError({ redirect: '/' })
}
</script>

<template>
  <NuxtLayout>
    <div class="min-h-[70vh] flex items-center justify-center px-4">
      <div class="text-center max-w-lg">
        <p class="text-primary font-mono font-bold text-6xl mb-4">{{ error.statusCode }}</p>

        <h1 class="text-3xl font-bold text-heading mb-4">
          {{ is404 ? 'Page Not Found' : 'Something Went Wrong' }}
        </h1>

        <p class="text-body mb-8 leading-relaxed">
          {{ is404
            ? "We couldn't find the page you were looking for. It may have been moved or deleted."
            : "An unexpected error occurred. Our team has been notified. Please try again in a moment."
          }}
        </p>

        <div class="flex flex-wrap gap-3 justify-center">
          <button
            class="bg-primary text-white px-6 py-3 rounded-xl font-medium hover:bg-primary-alt transition-colors"
            @click="handleError"
          >
            Go Home
          </button>
          <NuxtLink
            to="/contact-us"
            class="border border-border text-heading px-6 py-3 rounded-xl font-medium hover:border-primary transition-colors"
          >
            Contact Us
          </NuxtLink>
        </div>
      </div>
    </div>
  </NuxtLayout>
</template>
