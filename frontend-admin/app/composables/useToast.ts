type Toast = { id: number; type: 'success' | 'error'; message: string }

export function useToast() {
  const toasts = useState<Toast[]>('toasts', () => [])

  function add(type: Toast['type'], message: string, duration = 3500) {
    const id = Date.now() + Math.random()
    toasts.value = [...toasts.value, { id, type, message }]
    setTimeout(() => {
      toasts.value = toasts.value.filter(t => t.id !== id)
    }, duration)
  }

  return {
    toasts,
    success: (msg: string) => add('success', msg),
    error:   (msg: string) => add('error',   msg),
  }
}
