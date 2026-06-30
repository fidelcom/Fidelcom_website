<script setup lang="ts">
defineProps<{ settings?: { phone?: string; email?: string; address?: string; facebook?: string | null; twitter?: string | null; instagram?: string | null; linkedin?: string | null; youtube?: string | null } | null }>()

const api = useApi()
const [company, resources] = await Promise.all([
  useAsyncData('footer-company', () =>
    api.get<{ data: any[] }>('/menus?location=footer-company').then(r => r.data[0])
  ),
  useAsyncData('footer-resources', () =>
    api.get<{ data: any[] }>('/menus?location=footer-resources').then(r => r.data[0])
  ),
])

const year = new Date().getFullYear()
</script>

<template>
  <footer class="bg-surface border-t border-border">
    <div class="container mx-auto px-4 py-16">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
        <!-- Brand -->
        <div class="md:col-span-1">
          <NuxtLink to="/" class="text-primary font-bold text-xl mb-4 block">Fidelcom</NuxtLink>
          <p class="text-body text-sm leading-relaxed mb-4">IT solutions, software development, and digital consulting in Nigeria and beyond.</p>
          <div class="flex gap-3">
            <a v-if="settings?.facebook" :href="settings.facebook" target="_blank" rel="noopener" class="social-link">
              <Icon name="i-simple-icons-facebook" class="w-4 h-4" />
            </a>
            <a v-if="settings?.twitter" :href="settings.twitter" target="_blank" rel="noopener" class="social-link">
              <Icon name="i-simple-icons-x" class="w-4 h-4" />
            </a>
            <a v-if="settings?.instagram" :href="settings.instagram" target="_blank" rel="noopener" class="social-link">
              <Icon name="i-simple-icons-instagram" class="w-4 h-4" />
            </a>
            <a v-if="settings?.linkedin" :href="settings.linkedin" target="_blank" rel="noopener" class="social-link">
              <Icon name="i-simple-icons-linkedin" class="w-4 h-4" />
            </a>
          </div>
        </div>

        <!-- Company links -->
        <div>
          <h3 class="text-heading font-semibold text-sm mb-4">Company</h3>
          <ul class="space-y-2">
            <li v-for="item in company.data.value?.items" :key="item.id">
              <NuxtLink :to="item.url" class="footer-link">{{ item.label }}</NuxtLink>
            </li>
          </ul>
        </div>

        <!-- Resources links -->
        <div>
          <h3 class="text-heading font-semibold text-sm mb-4">Resources</h3>
          <ul class="space-y-2">
            <li v-for="item in resources.data.value?.items" :key="item.id">
              <NuxtLink :to="item.url" class="footer-link">{{ item.label }}</NuxtLink>
            </li>
          </ul>
        </div>

        <!-- Contact -->
        <div>
          <h3 class="text-heading font-semibold text-sm mb-4">Contact</h3>
          <ul class="space-y-3 text-sm text-body">
            <li v-if="settings?.address" class="flex gap-2">
              <Icon name="i-heroicons-map-pin" class="w-4 h-4 flex-shrink-0 mt-0.5 text-primary" />
              <span>{{ settings.address }}</span>
            </li>
            <li v-if="settings?.phone">
              <a :href="`tel:${settings.phone}`" class="footer-link">{{ settings.phone }}</a>
            </li>
            <li v-if="settings?.email">
              <a :href="`mailto:${settings.email}`" class="footer-link">{{ settings.email }}</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="mt-12 pt-6 border-t border-border flex flex-col sm:flex-row justify-between gap-3 text-body text-xs">
        <p>© {{ year }} Fidelcom Systems Limited. All rights reserved.</p>
        <p>Built with ♥ in Lagos, Nigeria</p>
      </div>
    </div>
  </footer>
</template>

<style scoped>
@reference "../assets/css/main.css";
.footer-link { @apply text-body text-sm hover:text-primary transition-colors; }
.social-link { @apply w-8 h-8 rounded-lg bg-surface-alt flex items-center justify-center text-body hover:text-primary hover:bg-primary/10 transition-colors; }
</style>
