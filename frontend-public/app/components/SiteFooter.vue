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
  <footer class="bg-black border-t border-[#161616]">

    <!-- CTA strip above footer — EPAM style -->
    <div class="border-b border-[#161616]">
      <div class="w-full max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16 py-14 flex flex-col md:flex-row items-start md:items-center justify-between gap-8">
        <div>
          <h2
            class="text-white font-black leading-[0.92] tracking-[-0.04em] mb-3"
            style="font-family: var(--font-display); font-size: clamp(1.8rem, 4vw, 3rem);"
          >Let's build something great.</h2>
          <p class="text-white/40 text-sm">Ready to accelerate your business with technology?</p>
        </div>
        <NuxtLink
          to="/contact-us"
          class="inline-flex items-center gap-3 bg-primary text-white font-bold text-sm px-8 py-4 hover:bg-primary-alt transition-colors flex-shrink-0 tracking-wide"
        >
          Start a Project <Icon name="i-heroicons-arrow-right" class="w-4 h-4" />
        </NuxtLink>
      </div>
    </div>

    <!-- Main footer grid -->
    <div class="w-full max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16 pt-14 pb-8">

      <div class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-14">

        <!-- Brand -->
        <div class="md:col-span-4">
          <NuxtLink to="/" class="inline-flex items-center gap-3 mb-6">
            <div class="w-8 h-8 bg-primary flex items-center justify-center flex-shrink-0">
              <span class="text-white font-black text-[13px] leading-none" style="font-family: var(--font-display);">F</span>
            </div>
            <span class="text-white font-bold text-[15px] tracking-tight" style="font-family: var(--font-display);">Fidelcom Systems</span>
          </NuxtLink>
          <p class="text-[#555] text-sm leading-relaxed max-w-xs mb-7">
            IT solutions, software development, and digital consulting — helping businesses grow with technology.
          </p>
          <div class="flex gap-2">
            <a v-if="settings?.facebook" :href="settings.facebook" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Facebook">
              <Icon name="i-simple-icons-facebook" class="w-3.5 h-3.5" />
            </a>
            <a v-if="settings?.twitter" :href="settings.twitter" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="X / Twitter">
              <Icon name="i-simple-icons-x" class="w-3.5 h-3.5" />
            </a>
            <a v-if="settings?.instagram" :href="settings.instagram" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="Instagram">
              <Icon name="i-simple-icons-instagram" class="w-3.5 h-3.5" />
            </a>
            <a v-if="settings?.linkedin" :href="settings.linkedin" target="_blank" rel="noopener noreferrer" class="social-link" aria-label="LinkedIn">
              <Icon name="i-simple-icons-linkedin" class="w-3.5 h-3.5" />
            </a>
          </div>
        </div>

        <!-- Company links -->
        <div class="md:col-span-2">
          <h3 class="footer-heading">Company</h3>
          <ul class="space-y-3">
            <li v-for="item in company.data.value?.items" :key="item.id">
              <NuxtLink :to="item.url" class="footer-link">{{ item.label }}</NuxtLink>
            </li>
          </ul>
        </div>

        <!-- Resources links -->
        <div class="md:col-span-2">
          <h3 class="footer-heading">Resources</h3>
          <ul class="space-y-3">
            <li v-for="item in resources.data.value?.items" :key="item.id">
              <NuxtLink :to="item.url" class="footer-link">{{ item.label }}</NuxtLink>
            </li>
          </ul>
        </div>

        <!-- Contact -->
        <div class="md:col-span-4">
          <h3 class="footer-heading">Contact</h3>
          <ul class="space-y-3 text-sm">
            <li v-if="settings?.address" class="flex gap-3 text-[#555]">
              <Icon name="i-heroicons-map-pin" class="w-4 h-4 flex-shrink-0 mt-0.5 text-primary/50" />
              <span>{{ settings.address }}</span>
            </li>
            <li v-if="settings?.phone">
              <a :href="`tel:${settings.phone}`" class="footer-link flex items-center gap-3">
                <Icon name="i-heroicons-phone" class="w-4 h-4 text-primary/50 flex-shrink-0" />
                {{ settings.phone }}
              </a>
            </li>
            <li v-if="settings?.email">
              <a :href="`mailto:${settings.email}`" class="footer-link flex items-center gap-3">
                <Icon name="i-heroicons-envelope" class="w-4 h-4 text-primary/50 flex-shrink-0" />
                {{ settings.email }}
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Bottom bar -->
      <div class="pt-6 border-t border-[#161616] flex flex-col sm:flex-row justify-between gap-3 text-[#444] text-xs">
        <p>© {{ year }} Fidelcom Systems Limited. All rights reserved.</p>
        <p>Lagos, Nigeria</p>
      </div>
    </div>
  </footer>
</template>

<style scoped>
.footer-heading {
  font-size: 10px;
  font-weight: 700;
  color: #333;
  text-transform: uppercase;
  letter-spacing: 0.14em;
  margin-bottom: 1rem;
}
.footer-link {
  font-size: 0.875rem;
  color: #555;
  transition: color 0.15s ease;
}
.footer-link:hover { color: #fff; }
.social-link {
  width: 34px;
  height: 34px;
  border: 1px solid #222;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #444;
  transition: all 0.15s ease;
}
.social-link:hover { border-color: #5237f9; color: #fff; }
</style>
