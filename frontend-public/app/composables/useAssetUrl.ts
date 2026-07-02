/**
 * Resolve API image paths to absolute URLs.
 *
 * The backend stores image paths as relative strings like:
 *   "storage/services/image.jpg"   (seeded via Storage::disk('public'))
 *   "upload/services/123.jpg"      (uploaded via admin panel)
 *
 * These must be served from the Laravel backend origin, not the Nuxt origin.
 * This composable strips /api/v1 from apiBase to get the backend origin and
 * prefixes any relative path with it, leaving absolute URLs untouched.
 */
export function useAssetUrl() {
  const config = useRuntimeConfig()

  // "http://localhost:8001/api/v1" → "http://localhost:8001"
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
