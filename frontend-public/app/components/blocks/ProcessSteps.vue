<script setup lang="ts">
const props = defineProps<{ data: Record<string, unknown> }>()

interface Step { title: string; description: string; icon?: string }

const heading = (props.data.heading as string | undefined) ?? 'How We Work'
const subheading = props.data.subheading as string | undefined
const steps: Step[] = (props.data.steps as Step[] | undefined) ?? [
  { title: 'Discovery', description: 'We learn about your business, goals, and challenges to build the right solution.', icon: 'i-heroicons-magnifying-glass' },
  { title: 'Planning', description: 'We design a roadmap with clear milestones, timelines, and deliverables.', icon: 'i-heroicons-clipboard-document-list' },
  { title: 'Build', description: 'Our team executes with agile sprints, weekly check-ins, and transparent progress.', icon: 'i-heroicons-code-bracket' },
  { title: 'Launch', description: 'We deploy, test, and hand over with thorough documentation and training.', icon: 'i-heroicons-rocket-launch' },
]
</script>

<template>
  <section class="py-20 bg-surface">
    <div class="container mx-auto px-4">
      <div class="text-center mb-14">
        <h2 class="text-3xl font-bold text-heading mb-3">{{ heading }}</h2>
        <p v-if="subheading" class="text-body max-w-xl mx-auto">{{ subheading }}</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 relative">
        <div
          v-for="(step, i) in steps"
          :key="i"
          class="relative bg-bg rounded-2xl p-6 border border-border text-center"
        >
          <div class="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <Icon v-if="step.icon" :name="step.icon" class="w-7 h-7 text-primary" />
            <span v-else class="text-primary text-xl font-bold">{{ i + 1 }}</span>
          </div>
          <div class="absolute -top-3 -left-3 w-7 h-7 bg-primary rounded-full flex items-center justify-center text-white text-xs font-bold">{{ i + 1 }}</div>
          <h3 class="text-heading font-semibold mb-2">{{ step.title }}</h3>
          <p class="text-body text-sm leading-relaxed">{{ step.description }}</p>
        </div>
      </div>
    </div>
  </section>
</template>
