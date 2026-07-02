<script setup lang="ts">
definePageMeta({ layout: 'dashboard' })
const api = useApi()
const menus = ref<{ id: number; name: string; location: string; items: any[] }[]>([])
const loading = ref(true)
const saving = ref(false)
const activeMenu = ref<typeof menus.value[0] | null>(null)
const editItems = ref<{ label: string; url: string; target: string; children: { label: string; url: string; target: string }[] }[]>([])

async function load() {
  loading.value = true
  menus.value = await api.get<{ data: any[] }>('/admin/menus').then(r => r.data).finally(() => loading.value = false)
}

function selectMenu(m: typeof menus.value[0]) {
  activeMenu.value = m
  editItems.value = m.items.map(i => ({
    label: i.label, url: i.url, target: i.target ?? '_self',
    children: (i.children ?? []).map((c: any) => ({ label: c.label, url: c.url, target: c.target ?? '_self' })),
  }))
}

function addItem() { editItems.value.push({ label: '', url: '/', target: '_self', children: [] }) }
function removeItem(i: number) { editItems.value.splice(i, 1) }
function addChild(i: number) { editItems.value[i].children.push({ label: '', url: '/', target: '_self' }) }
function removeChild(i: number, j: number) { editItems.value[i].children.splice(j, 1) }

async function save() {
  if (!activeMenu.value) return
  saving.value = true
  await api.patch(`/admin/menus/${activeMenu.value.id}/items`, { items: editItems.value })
  saving.value = false
  load()
}

onMounted(() => load())
</script>

<template>
  <div>
    <h1 class="text-2xl font-bold text-heading mb-6">Menus</h1>

    <div class="flex gap-6">
      <!-- Menu list -->
      <div class="w-48 flex-shrink-0 space-y-2">
        <button
          v-for="m in menus"
          :key="m.id"
          :class="['w-full text-left px-4 py-2 rounded-xl text-sm transition-colors', activeMenu?.id === m.id ? 'bg-primary/20 text-primary font-medium' : 'text-body hover:bg-surface-alt hover:text-heading']"
          @click="selectMenu(m)"
        >{{ m.name }}</button>
      </div>

      <!-- Menu editor -->
      <div class="flex-1">
        <div v-if="!activeMenu" class="text-body text-sm p-8 bg-surface rounded-xl text-center">Select a menu to edit</div>

        <div v-else>
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-heading font-semibold">{{ activeMenu.name }}</h2>
            <div class="flex gap-2">
              <button class="btn-ghost text-xs" @click="addItem">+ Add Item</button>
              <button class="btn-primary text-xs" :disabled="saving" @click="save">{{ saving ? 'Savingâ€¦' : 'Save Menu' }}</button>
            </div>
          </div>

          <div class="space-y-3">
            <div v-for="(item, i) in editItems" :key="i" class="bg-surface rounded-xl p-4 space-y-3">
              <div class="flex gap-3 items-center">
                <input v-model="item.label" placeholder="Label" class="input flex-1" />
                <input v-model="item.url" placeholder="URL (/about)" class="input flex-1" />
                <select v-model="item.target" class="input w-24"><option value="_self">Same tab</option><option value="_blank">New tab</option></select>
                <button class="btn-danger text-xs" @click="removeItem(i)">âœ•</button>
              </div>

              <!-- Children -->
              <div v-if="item.children.length" class="pl-6 space-y-2">
                <div v-for="(child, j) in item.children" :key="j" class="flex gap-3 items-center">
                  <input v-model="child.label" placeholder="Label" class="input flex-1" />
                  <input v-model="child.url" placeholder="URL" class="input flex-1" />
                  <button class="btn-danger text-xs" @click="removeChild(i, j)">âœ•</button>
                </div>
              </div>
              <button class="text-xs text-body hover:text-primary transition-colors pl-6" @click="addChild(i)">+ Add sub-item</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
