<script setup lang="ts">
const props = defineProps<{
  blockType: string
  modelValue: Record<string, unknown>
}>()

const emit = defineEmits<{
  'update:modelValue': [data: Record<string, unknown>]
}>()

type FieldType = 'text' | 'textarea' | 'url' | 'number' | 'boolean' | 'select'

interface SelectOption { value: string; label: string }

interface FieldDef {
  key: string
  label: string
  type: FieldType
  options?: SelectOption[]
  min?: number
  max?: number
  hint?: string
}

const SCHEMAS: Record<string, FieldDef[]> = {
  hero: [
    { key: 'heading',      label: 'Heading',      type: 'text' },
    { key: 'subheading',   label: 'Subheading',   type: 'textarea' },
    { key: 'button_label', label: 'Button Label', type: 'text' },
    { key: 'button_url',   label: 'Button URL',   type: 'url' },
  ],
  slider: [
    { key: 'autoplay',       label: 'Autoplay',           type: 'boolean' },
    { key: 'autoplay_speed', label: 'Autoplay Speed (ms)', type: 'number', min: 1000, max: 30000 },
    { key: 'slider_ids',     label: 'Slider IDs',          type: 'text', hint: 'Comma-separated IDs from the Sliders section, or leave blank to use all.' },
  ],
  content: [
    { key: 'heading', label: 'Heading', type: 'text' },
    { key: 'body',    label: 'Body',    type: 'textarea' },
  ],
  stats: [
    { key: 'heading', label: 'Heading', type: 'text' },
    { key: 'source',  label: 'Data Source', type: 'select', options: [{ value: 'db', label: 'Database (live counts)' }] },
  ],
  services_grid: [
    { key: 'heading', label: 'Heading', type: 'text' },
    { key: 'limit',   label: 'Limit',   type: 'number', min: 1, max: 24 },
    { key: 'style',   label: 'Style',   type: 'select', options: [{ value: 'card-grid', label: 'Card Grid' }, { value: 'list', label: 'List' }] },
  ],
  projects_grid: [
    { key: 'heading', label: 'Heading', type: 'text' },
    { key: 'limit',   label: 'Limit',   type: 'number', min: 1, max: 24 },
    { key: 'style',   label: 'Style',   type: 'select', options: [{ value: 'grid', label: 'Grid' }, { value: 'list', label: 'List' }] },
  ],
  testimonials: [
    { key: 'heading', label: 'Heading', type: 'text' },
    { key: 'limit',   label: 'Limit',   type: 'number', min: 1, max: 20 },
    { key: 'style',   label: 'Style',   type: 'select', options: [{ value: 'slider', label: 'Slider' }, { value: 'grid', label: 'Grid' }] },
  ],
  blog_posts: [
    { key: 'heading', label: 'Heading', type: 'text' },
    { key: 'limit',   label: 'Limit',   type: 'number', min: 1, max: 12 },
    { key: 'style',   label: 'Style',   type: 'select', options: [{ value: 'card', label: 'Card' }, { value: 'list', label: 'List' }] },
  ],
  team: [
    { key: 'heading', label: 'Heading', type: 'text' },
    { key: 'limit',   label: 'Limit',   type: 'number', min: 1, max: 20 },
  ],
  faqs: [
    { key: 'heading', label: 'Heading', type: 'text' },
    { key: 'limit',   label: 'Limit',   type: 'number', min: 1, max: 30 },
    { key: 'style',   label: 'Style',   type: 'select', options: [{ value: 'accordion', label: 'Accordion' }, { value: 'list', label: 'List' }] },
  ],
  cta_banner: [
    { key: 'heading',      label: 'Heading',      type: 'text' },
    { key: 'body',         label: 'Body Text',    type: 'textarea' },
    { key: 'button_label', label: 'Button Label', type: 'text' },
    { key: 'button_url',   label: 'Button URL',   type: 'url' },
    { key: 'bg_color',     label: 'Background',   type: 'select', options: [
      { value: 'primary', label: 'Primary (violet)' },
      { value: 'dark',    label: 'Dark' },
      { value: 'light',   label: 'Light' },
    ]},
  ],
  gallery: [
    { key: 'heading', label: 'Heading', type: 'text' },
    { key: 'limit',   label: 'Limit',   type: 'number', min: 1, max: 48 },
  ],
  partners: [
    { key: 'heading', label: 'Heading', type: 'text' },
    { key: 'style',   label: 'Style',   type: 'select', options: [{ value: 'logo-strip', label: 'Logo Strip' }, { value: 'grid', label: 'Grid' }] },
  ],
  contact_form: [
    { key: 'heading',    label: 'Heading',    type: 'text' },
    { key: 'subheading', label: 'Subheading', type: 'text' },
  ],
  process_steps: [
    { key: 'heading', label: 'Heading', type: 'text' },
  ],
  case_study: [
    { key: 'heading', label: 'Heading', type: 'text' },
    { key: 'limit',   label: 'Limit',   type: 'number', min: 1, max: 12 },
    { key: 'style',   label: 'Style',   type: 'select', options: [{ value: 'featured', label: 'Featured' }, { value: 'grid', label: 'Grid' }] },
  ],
}

const fields = computed(() => SCHEMAS[props.blockType] ?? [])

const local = reactive<Record<string, unknown>>({})

watch(() => props.modelValue, (val) => {
  Object.assign(local, val)
}, { immediate: true })

function set(key: string, value: unknown) {
  local[key] = value
  emit('update:modelValue', { ...local })
}

function getStr(key: string): string {
  return String(local[key] ?? '')
}
function getNum(key: string, fallback: number): number {
  const v = local[key]
  return typeof v === 'number' ? v : typeof v === 'string' ? Number(v) || fallback : fallback
}
function getBool(key: string): boolean {
  return Boolean(local[key])
}
</script>

<template>
  <div class="space-y-4">
    <div v-if="!fields.length" class="text-body text-sm py-4 text-center">
      No editable fields for block type <code class="font-mono bg-surface-alt px-1 rounded">{{ blockType }}</code>.
    </div>

    <template v-for="field in fields" :key="field.key">
      <!-- Boolean (checkbox) -->
      <div v-if="field.type === 'boolean'" class="flex items-center gap-3">
        <input
          :id="`bf-${field.key}`"
          type="checkbox"
          :checked="getBool(field.key)"
          class="w-4 h-4 accent-primary"
          @change="set(field.key, ($event.target as HTMLInputElement).checked)"
        />
        <label :for="`bf-${field.key}`" class="label !mb-0 cursor-pointer">{{ field.label }}</label>
      </div>

      <!-- Select -->
      <div v-else-if="field.type === 'select'">
        <label :for="`bf-${field.key}`" class="label">{{ field.label }}</label>
        <select
          :id="`bf-${field.key}`"
          :value="getStr(field.key)"
          class="input"
          @change="set(field.key, ($event.target as HTMLSelectElement).value)"
        >
          <option v-for="opt in field.options" :key="opt.value" :value="opt.value">{{ opt.label }}</option>
        </select>
      </div>

      <!-- Number -->
      <div v-else-if="field.type === 'number'">
        <label :for="`bf-${field.key}`" class="label">{{ field.label }}</label>
        <input
          :id="`bf-${field.key}`"
          type="number"
          :value="getNum(field.key, field.min ?? 0)"
          :min="field.min"
          :max="field.max"
          class="input"
          @input="set(field.key, Number(($event.target as HTMLInputElement).value))"
        />
      </div>

      <!-- Textarea -->
      <div v-else-if="field.type === 'textarea'">
        <label :for="`bf-${field.key}`" class="label">{{ field.label }}</label>
        <textarea
          :id="`bf-${field.key}`"
          :value="getStr(field.key)"
          rows="4"
          class="input"
          @input="set(field.key, ($event.target as HTMLTextAreaElement).value)"
        />
        <p v-if="field.hint" class="text-[11px] text-body/40 mt-1">{{ field.hint }}</p>
      </div>

      <!-- Text / URL (default) -->
      <div v-else>
        <label :for="`bf-${field.key}`" class="label">{{ field.label }}</label>
        <input
          :id="`bf-${field.key}`"
          :type="field.type === 'url' ? 'url' : 'text'"
          :value="getStr(field.key)"
          class="input"
          @input="set(field.key, ($event.target as HTMLInputElement).value)"
        />
        <p v-if="field.hint" class="text-[11px] text-body/40 mt-1">{{ field.hint }}</p>
      </div>
    </template>
  </div>
</template>
