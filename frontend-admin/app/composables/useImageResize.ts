export function useImageResize() {
  async function resizeImage(
    file: File,
    maxWidth: number,
    maxHeight: number,
    quality = 0.85,
  ): Promise<File> {
    // Skip GIFs (preserve animation) and SVGs
    if (!file.type.startsWith('image/') || file.type === 'image/gif' || file.type === 'image/svg+xml') {
      return file
    }

    return new Promise((resolve) => {
      const img = new Image()
      const url = URL.createObjectURL(file)

      img.onload = () => {
        URL.revokeObjectURL(url)

        let { width, height } = img

        // Never upscale
        if (width <= maxWidth && height <= maxHeight) {
          resolve(file)
          return
        }

        const ratio = Math.min(maxWidth / width, maxHeight / height)
        width = Math.round(width * ratio)
        height = Math.round(height * ratio)

        const canvas = document.createElement('canvas')
        canvas.width = width
        canvas.height = height
        canvas.getContext('2d')!.drawImage(img, 0, 0, width, height)

        // Preserve PNG transparency; everything else → JPEG
        const outType = file.type === 'image/png' ? 'image/png' : 'image/jpeg'
        canvas.toBlob(
          (blob) => {
            if (!blob) { resolve(file); return }
            resolve(new File([blob], file.name, { type: outType, lastModified: Date.now() }))
          },
          outType,
          outType === 'image/jpeg' ? quality : undefined,
        )
      }

      img.onerror = () => { URL.revokeObjectURL(url); resolve(file) }
      img.src = url
    })
  }

  return { resizeImage }
}
