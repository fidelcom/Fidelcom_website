export default defineEventHandler(async () => {
  const config = useRuntimeConfig()
  const apiBase = config.public.apiBase || 'http://localhost:8001/api/v1'
  const siteUrl = 'https://fidelcom.org'

  const staticPages = [
    { loc: '/', priority: '1.0', changefreq: 'weekly' },
    { loc: '/about-us', priority: '0.8', changefreq: 'monthly' },
    { loc: '/all-services', priority: '0.9', changefreq: 'weekly' },
    { loc: '/portfolio', priority: '0.9', changefreq: 'weekly' },
    { loc: '/blog', priority: '0.8', changefreq: 'daily' },
    { loc: '/contact-us', priority: '0.7', changefreq: 'monthly' },
    { loc: '/request-quote', priority: '0.8', changefreq: 'monthly' },
  ]

  const urls: { loc: string; lastmod?: string; priority: string; changefreq: string }[] = [...staticPages]

  try {
    const [postsRes, projectsRes, servicesRes] = await Promise.all([
      $fetch<{ data: { slug: string; published_at: string }[] }>(`${apiBase}/posts`).catch(() => null),
      $fetch<{ data: { slug: string; updated_at: string }[] }>(`${apiBase}/projects`).catch(() => null),
      $fetch<{ data: { slug: string; updated_at: string }[] }>(`${apiBase}/services`).catch(() => null),
    ])

    if (postsRes?.data) {
      for (const post of postsRes.data) {
        urls.push({ loc: `/blog/${post.slug}`, lastmod: post.published_at?.slice(0, 10), priority: '0.7', changefreq: 'monthly' })
      }
    }
    if (projectsRes?.data) {
      for (const project of projectsRes.data) {
        urls.push({ loc: `/portfolio/${project.slug}`, lastmod: project.updated_at?.slice(0, 10), priority: '0.7', changefreq: 'monthly' })
      }
    }
    if (servicesRes?.data) {
      for (const service of servicesRes.data) {
        urls.push({ loc: `/all-services/${service.slug}`, lastmod: service.updated_at?.slice(0, 10), priority: '0.8', changefreq: 'monthly' })
      }
    }
  } catch {}

  const xml = `<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
${urls.map(u => `  <url>
    <loc>${siteUrl}${u.loc}</loc>${u.lastmod ? `\n    <lastmod>${u.lastmod}</lastmod>` : ''}
    <changefreq>${u.changefreq}</changefreq>
    <priority>${u.priority}</priority>
  </url>`).join('\n')}
</urlset>`

  return new Response(xml, {
    headers: { 'Content-Type': 'application/xml; charset=utf-8' },
  })
})
