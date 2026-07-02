import type { User } from '../../../shared/types/api'

export function useAuth() {
  const config = useRuntimeConfig()
  const apiBase = config.public.apiBase as string
  // Derive Laravel root from apiBase (e.g. http://localhost:8001/api/v1 → http://localhost:8001)
  const laravelBase = apiBase.replace(/\/api\/v\d+\/?$/, '')

  const user = useState<User | null>('auth:user', () => null)
  const loading = ref(false)
  const error = ref<string | null>(null)

  const isAuthenticated = computed(() => !!user.value)

  async function login(email: string, password: string): Promise<boolean> {
    loading.value = true
    error.value = null
    try {
      await $fetch('/sanctum/csrf-cookie', { baseURL: laravelBase, credentials: 'include' })
      const res = await $fetch<{ data: User }>('/auth/login', {
        baseURL: apiBase,
        method: 'POST',
        body: { email, password },
        credentials: 'include',
        headers: { Accept: 'application/json' },
      })
      user.value = res.data
      return true
    } catch {
      error.value = 'Invalid email or password.'
      return false
    } finally {
      loading.value = false
    }
  }

  async function logout() {
    try {
      await $fetch('/auth/logout', {
        baseURL: apiBase,
        method: 'POST',
        credentials: 'include',
        headers: { Accept: 'application/json' },
      })
    } finally {
      user.value = null
      await navigateTo('/login')
    }
  }

  async function fetchUser() {
    try {
      const res = await $fetch<{ data: User }>('/auth/user', {
        baseURL: apiBase,
        credentials: 'include',
        headers: { Accept: 'application/json' },
      })
      user.value = res.data
    } catch {
      user.value = null
    }
  }

  return { user, loading, error, isAuthenticated, login, logout, fetchUser }
}
