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
  <section class="py-24 bg-surface border-t border-border">
    <div class="w-full max-w-[1400px] mx-auto px-6 md:px-12 xl:px-16">

      <div class="text-center mb-16">
        <p class="text-primary text-xs font-semibold uppercase tracking-[0.15em] mb-4">Our Process</p>
        <h2
          class="text-white font-black leading-[0.92] tracking-[-0.03em]"
          style="font-family: var(--font-display); font-size: clamp(2rem, 4vw, 3.25rem); text-wrap: balance;"
        >{{ heading }}</h2>
        <p v-if="subheading" class="text-body mt-4 max-w-xl mx-auto leading-relaxed">{{ subheading }}</p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-0">
        <div
          v-for="(step, i) in steps"
          :key="i"
          :class="['p-8 border-t border-border', i > 0 ? 'md:border-l' : '']"
        >
          <!-- Step number + connector line -->
          <div class="flex items-center gap-4 mb-6">
            <span
              class="text-white font-black leading-none tabular-nums"
              style="font-family: var(--font-display); font-size: 3rem; opacity: 0.12;"
            >{{ String(i + 1).padStart(2, '0') }}</span>
            <div v-if="step.icon" class="w-10 h-10 border border-primary/20 bg-primary/8 flex items-center justify-center flex-shrink-0">
              <Icon :name="step.icon" class="w-5 h-5 text-primary" />
            </div>
          </div>
          <h3 class="text-white font-bold text-lg mb-3">{{ step.title }}</h3>
          <p class="text-body text-sm leading-relaxed">{{ step.description }}</p>
        </div>
      </div>
    </div>
  </section>
</template>
