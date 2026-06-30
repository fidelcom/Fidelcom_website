<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })
const api = useApi()
const groups = ref<{ group: string; settings: Record<string, string> }[]>([])
const loading = ref(true)
const saving = ref(false)
const saved = ref(false)
const form = reactive<Record<string, Record<string, string>>>({})

async function load() {
  loading.value = true
  try {
    const res = await api.get<{ data: typeof groups.value }>('/api/v1/admin/settings')
    groups.value = res.data
    res.data.forEach(g => { form[g.group] = { ...g.settings } })
  } finally { loading.value = false }
}

async function saveGroup(group: string) {
  saving.value = true
  await api.patch('/api/v1/admin/settings', { group, settings: form[group] })
  saving.value = false
  saved.value = true
  setTimeout(() => saved.value = false, 2000)
}

onMounted(() => load())

const groupLabels: Record<string, string> = {
  general: 'General', seo: 'SEO Defaults', contact: 'Contact & Social',
}
</script>

<template>
  <div class="max-w-2xl">
    <h1 class="text-2xl font-bold text-heading mb-6">Settings</h1>
    <div v-if="loading" class="text-body">Loading…</div>

    <div v-for="g in groups" v-else :key="g.group" class="mb-8 bg-surface rounded-xl p-6">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-heading font-semibold">{{ groupLabels[g.group] ?? g.group }}</h2>
        <button class="btn-primary text-xs" :disabled="saving" @click="saveGroup(g.group)">
          {{ saved ? '✓ Saved' : saving ? 'Saving…' : 'Save' }}
        </button>
      </div>
      <div class="space-y-3">
        <div v-for="(val, key) in g.settings" :key="key">
          <label class="label">{{ String(key).replace(/_/g, ' ') }}</label>
          <input v-if="!['address', 'default_desc'].includes(String(key))" v-model="form[g.group][String(key)]" class="input" />
          <textarea v-else v-model="form[g.group][String(key)]" class="input" rows="3" />
        </div>
      </div>
    </div>
  </div>
</template>
