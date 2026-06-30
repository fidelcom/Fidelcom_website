import { defineStore } from 'pinia'
import type { User } from '../../../shared/types/api'

interface LoginPayload {
  email: string
  password: string
}

export const useAuthStore = defineStore('auth', () => {
  const user = ref<User | null>(null)
  const isAuthenticated = computed(() => user.value !== null)

  const { get, post } = useApi()

  async function fetchUser() {
    try {
      const res = await get<{ data: User }>('/auth/user')
      user.value = res.data
    } catch {
      user.value = null
    }
  }

  async function login(payload: LoginPayload) {
    await post('/auth/login', payload)
    await fetchUser()
  }

  async function logout() {
    await post('/auth/logout')
    user.value = null
    await navigateTo('/auth/login')
  }

  return { user, isAuthenticated, fetchUser, login, logout }
})
