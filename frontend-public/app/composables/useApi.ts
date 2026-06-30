import type { ApiError } from '../../../shared/types/api'

export function useApi() {
  const config = useRuntimeConfig()
  const baseURL = config.public.apiBase as string

  async function request<T>(
    path: string,
    options: Parameters<typeof $fetch>[1] = {}
  ): Promise<T> {
    return $fetch<T>(path, {
      baseURL,
      headers: {
        Accept: 'application/json',
        ...(options.headers ?? {}),
      },
      ...options,
    })
  }

  return {
    get: <T>(path: string, params?: Record<string, unknown>) =>
      request<T>(path, { method: 'GET', params }),

    post: <T>(path: string, body?: unknown) =>
      request<T>(path, { method: 'POST', body }),
  }
}

export function isApiError(err: unknown): err is { data: ApiError } {
  return (
    typeof err === 'object' &&
    err !== null &&
    'data' in err &&
    typeof (err as { data: unknown }).data === 'object' &&
    (err as { data: unknown }).data !== null &&
    'error' in ((err as { data: unknown }).data as object)
  )
}
