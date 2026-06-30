export function useCrud<T extends { id: number }>(endpoint: string) {
  const api = useApi()
  const items = ref<T[]>([])
  const loading = ref(false)
  const saving = ref(false)
  const error = ref<string | null>(null)
  const meta = ref({ total: 0, last_page: 1, current_page: 1 })
  const page = ref(1)
  const search = ref('')

  async function load(params?: Record<string, unknown>) {
    loading.value = true
    error.value = null
    try {
      const res = await api.get<{ data: T[]; meta?: typeof meta.value }>(endpoint, {
        page: page.value,
        q: search.value || undefined,
        ...params,
      })
      items.value = res.data
      if (res.meta) meta.value = res.meta
    } catch (e) {
      error.value = 'Failed to load data'
      console.error(e)
    } finally {
      loading.value = false
    }
  }

  async function create(body: FormData | Record<string, unknown>): Promise<T | null> {
    saving.value = true
    error.value = null
    try {
      const res = await api.post<{ data: T }>(endpoint, body)
      return res.data
    } catch (e) {
      error.value = isApiError(e) ? e.data.error.message : 'Failed to create'
      return null
    } finally {
      saving.value = false
    }
  }

  async function update(id: number, body: FormData | Record<string, unknown>): Promise<T | null> {
    saving.value = true
    error.value = null
    try {
      const res = await api.patch<{ data: T }>(`${endpoint}/${id}`, body)
      return res.data
    } catch (e) {
      error.value = isApiError(e) ? e.data.error.message : 'Failed to update'
      return null
    } finally {
      saving.value = false
    }
  }

  async function remove(id: number): Promise<boolean> {
    try {
      await api.delete(`${endpoint}/${id}`)
      items.value = items.value.filter((i) => i.id !== id)
      return true
    } catch (e) {
      error.value = 'Failed to delete'
      return false
    }
  }

  watch([page, search], () => load())

  return { items, loading, saving, error, meta, page, search, load, create, update, remove }
}
