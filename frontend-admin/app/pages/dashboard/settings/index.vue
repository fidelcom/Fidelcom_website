<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })
const api = useApi()

// Backend returns: { data: { general: {key:val}, seo: {…}, contact: {…} } }
type SettingsMap = Record<string, Record<string, string>>

const raw = ref<SettingsMap>({})
const form = reactive<SettingsMap>({})
const loading = ref(true)
const saving = reactive<Record<string, boolean>>({})
const savedGroup = ref<string | null>(null)
const toast = useToast()

async function load() {
  loading.value = true
  try {
    const res = await api.get<{ data: SettingsMap }>('/admin/settings')
    raw.value = res.data
    Object.entries(res.data).forEach(([group, settings]) => {
      form[group] = { ...settings }
    })
  } finally {
    loading.value = false
  }
}

async function saveGroup(group: string) {
  saving[group] = true
  try {
    await api.patch('/admin/settings', { [group]: form[group] })
    savedGroup.value = group
    setTimeout(() => { savedGroup.value = null }, 2000)
    toast.success(`${groupLabels[group] ?? group} settings saved`)
  } catch {
    toast.error('Failed to save settings')
  } finally {
    saving[group] = false
  }
}

onMounted(() => load())

const groupLabels: Record<string, string> = {
  general: 'General',
  seo:     'SEO Defaults',
  contact: 'Contact & Social',
}

const groupOrder = ['general', 'seo', 'contact']

const orderedGroups = computed(() =>
  groupOrder
    .filter(g => g in form)
    .concat(Object.keys(form).filter(g => !groupOrder.includes(g)))
)

const fieldLabels: Record<string, string> = {
  site_name: 'Site Name',
  tagline: 'Tagline',
  description: 'Site Description',
  logo: 'Logo URL',
  favicon: 'Favicon URL',
  phone: 'Phone Number',
  email: 'Email Address',
  address: 'Office Address',
  facebook: 'Facebook URL',
  twitter: 'X (Twitter) URL',
  instagram: 'Instagram URL',
  linkedin: 'LinkedIn URL',
  youtube: 'YouTube URL',
  default_title: 'Default Page Title',
  default_desc: 'Default Meta Description',
  og_image: 'Default OG Image URL',
  google_analytics: 'Google Analytics ID',
}

function fieldLabel(key: string): string {
  return fieldLabels[key] ?? key.replace(/_/g, ' ').replace(/\b\w/g, c => c.toUpperCase())
}

function isTextarea(key: string): boolean {
  return ['address', 'default_desc', 'description'].includes(key)
}

function inputType(key: string): string {
  if (key === 'email') return 'email'
  if (key === 'phone') return 'tel'
  if (['facebook', 'twitter', 'instagram', 'linkedin', 'youtube'].includes(key)) return 'url'
  return 'text'
}
</script>

<template>
  <div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-heading mb-6">Settings</h1>

    <div v-if="loading" class="flex items-center gap-2 text-body py-8">
      <span class="w-4 h-4 border-2 border-primary border-t-transparent rounded-full animate-spin" />
      Loading settings…
    </div>

    <template v-else>
      <div
        v-for="group in orderedGroups"
        :key="group"
        class="mb-8 bg-surface rounded-xl border border-border p-6"
      >
        <div class="flex items-center justify-between mb-5">
          <h2 class="text-heading font-semibold">{{ groupLabels[group] ?? group }}</h2>
          <button
            class="btn-primary text-xs px-4 py-1.5 min-w-[72px]"
            :disabled="saving[group]"
            @click="saveGroup(group)"
          >
            <span v-if="savedGroup === group">✓ Saved</span>
            <span v-else-if="saving[group]">Saving…</span>
            <span v-else>Save</span>
          </button>
        </div>

        <div class="space-y-4">
          <div v-for="(_, key) in form[group]" :key="key">
            <label class="label capitalize">{{ fieldLabel(String(key)) }}</label>
            <textarea
              v-if="isTextarea(String(key))"
              v-model="form[group][String(key)]"
              class="input"
              rows="3"
            />
            <input
              v-else
              v-model="form[group][String(key)]"
              :type="inputType(String(key))"
              class="input"
            />
          </div>
          <p v-if="!Object.keys(form[group] ?? {}).length" class="text-body text-sm italic">
            No settings in this group yet.
          </p>
        </div>
      </div>

      <p v-if="!orderedGroups.length" class="text-body text-sm">
        No settings found. Run the database seeder to populate defaults.
      </p>
    </template>
  </div>
</template>
