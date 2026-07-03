export function useTheme() {
  const colorMode = useColorMode({
    attribute: 'class',
    initialValue: 'dark',
    storageKey: 'fidelcom-theme',
    modes: {
      dark: 'dark',
      light: 'light',
    },
  })

  const isDark = computed(() => colorMode.value === 'dark')

  function toggle() {
    colorMode.value = isDark.value ? 'light' : 'dark'
  }

  return { isDark, toggle, mode: colorMode }
}
