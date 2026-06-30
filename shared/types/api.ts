// ── Pagination ────────────────────────────────────────────────────────────────

export interface PaginatedResponse<T> {
  data: T[]
  meta: {
    current_page: number
    last_page: number
    per_page: number
    total: number
    from: number | null
    to: number | null
  }
  links: {
    first: string | null
    last: string | null
    prev: string | null
    next: string | null
  }
}

export interface ApiResponse<T> {
  data: T
}

export interface ApiError {
  error: {
    code: string
    message: string
    details?: Record<string, string[]>
  }
}

// ── Auth ──────────────────────────────────────────────────────────────────────

export interface User {
  id: number
  name: string
  email: string
  role: 'admin' | 'subadmin' | 'analyst' | 'user'
  created_at: string
  updated_at: string
}

// ── Media ─────────────────────────────────────────────────────────────────────

export interface Media {
  id: number
  filename: string
  url: string
  alt_text: string | null
  mime_type: string
  size: number
  width: number | null
  height: number | null
  created_at: string
}

// ── Settings ──────────────────────────────────────────────────────────────────

export interface Settings {
  site_name: string
  phone: string
  email: string
  address: string
  facebook: string | null
  twitter: string | null
  instagram: string | null
  linkedin: string | null
  youtube: string | null
}

// ── Content Types ─────────────────────────────────────────────────────────────

export interface Post {
  id: number
  title: string
  slug: string
  author: string
  short_desc: string
  long_desc: string
  image: string
  meta_title: string | null
  meta_description: string | null
  blog_category: BlogCategory | null
  comments_count?: number
  created_at: string
  updated_at: string
}

export interface BlogCategory {
  id: number
  name: string
  slug: string
  posts_count?: number
}

export interface Project {
  id: number
  title: string
  slug: string
  short_desc: string
  long_desc: string
  client: string | null
  year: string | null
  location: string | null
  image: string
  meta_title: string | null
  meta_description: string | null
  project_category: ProjectCategory | null
  multi_images?: ProjectMultiImage[]
  created_at: string
  updated_at: string
}

export interface ProjectCategory {
  id: number
  name: string
  projects_count?: number
}

export interface ProjectMultiImage {
  id: number
  project_id: number
  image: string
}

export interface Service {
  id: number
  title: string
  slug: string
  short_desc: string
  long_desc: string
  image: string
  meta_title: string | null
  meta_description: string | null
  multi_images?: ServiceMultiImage[]
  created_at: string
  updated_at: string
}

export interface ServiceMultiImage {
  id: number
  service_id: number
  image: string
}

export interface Team {
  id: number
  name: string
  position: string
  image: string
  instagram: string | null
  linkedin: string | null
  twitter: string | null
  facebook: string | null
}

export interface Testimonial {
  id: number
  name: string
  subtitle: string | null
  desc: string
  rating: number | null
  location: string | null
  image: string | null
  approved: boolean
  created_at: string
}

export interface Faq {
  id: number
  question: string
  answer: string
}

export interface Partner {
  id: number
  name: string
  url: string | null
  image: string
}

export interface Slider {
  id: number
  title: string
  project: string
  description: string
  image: string
}

export interface Gallery {
  id: number
  name: string
  image: string
}

export interface Success {
  id: number
  title: string
  value: string
}

export interface Process {
  id: number
  title: string
  desc: string
  image: string
}

// ── Page Builder ──────────────────────────────────────────────────────────────

export type BlockType =
  | 'hero'
  | 'content'
  | 'services_grid'
  | 'projects_grid'
  | 'stats'
  | 'testimonials'
  | 'blog_posts'
  | 'team'
  | 'faqs'
  | 'cta_banner'
  | 'gallery'
  | 'partners'
  | 'contact_form'
  | 'process_steps'
  | 'slider'

export interface Block {
  id: number
  page_id: number
  block_type: BlockType
  position: number
  data: Record<string, unknown>
  created_at: string
  updated_at: string
}

export interface Page {
  id: number
  title: string
  slug: string
  status: 'draft' | 'published'
  published_at: string | null
  meta_title: string | null
  meta_description: string | null
  og_image: Media | null
  blocks: Block[]
  created_at: string
  updated_at: string
}

// ── Inquiries ─────────────────────────────────────────────────────────────────

export interface Inquiry {
  id: number
  source: 'contact' | 'quote'
  name: string
  email: string
  phone: string
  subject: string | null
  service: string | null
  message: string
  status: boolean
  created_at: string
}

// ── Navigation ────────────────────────────────────────────────────────────────

export interface MenuItem {
  id: number
  label: string
  url: string
  target: '_self' | '_blank'
  children?: MenuItem[]
}

export interface Menu {
  location: string
  items: MenuItem[]
}
