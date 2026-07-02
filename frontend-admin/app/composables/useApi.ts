import type { ApiError } from '../../../shared/types/api'

function getXsrfToken(): string {
  if (import.meta.server) return ''
  const match = document.cookie.match(/(?:^|;\s*)XSRF-TOKEN=([^;]*)/)
  return match?.[1] ? decodeURIComponent(match[1]) : ''
}

export function useApi() {
  const config = useRuntimeConfig()
  const baseURL = config.public.apiBase as string

  async function request<T>(
    path: string,
    options: Parameters<typeof $fetch>[1] = {}
  ): Promise<T> {
    const xsrf = getXsrfToken()
    return $fetch<T>(path, {
      baseURL,
      credentials: 'include',
      headers: {
        Accept: 'application/json',
        ...(xsrf ? { 'X-XSRF-TOKEN': xsrf } : {}),
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

    patch: <T>(path: string, body?: unknown) =>
      request<T>(path, { method: 'PATCH', body }),

    put: <T>(path: string, body?: unknown) =>
      request<T>(path, { method: 'PUT', body }),

    delete: <T>(path: string) =>
      request<T>(path, { method: 'DELETE' }),
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
