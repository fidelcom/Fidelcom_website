export function useAssetUrl() {
  const config = useRuntimeConfig()

  const backendOrigin = (config.public.apiBase as string)
    .replace(/\/api\/v1\/?$/, '')
    .replace(/\/$/, '')

  function assetUrl(path: string | null | undefined): string {
    if (!path) return ''
    if (/^https?:\/\//.test(path)) return path
    const normalized = path.startsWith('/') ? path.slice(1) : path
    return `${backendOrigin}/${normalized}`
  }

  return { assetUrl }
}
