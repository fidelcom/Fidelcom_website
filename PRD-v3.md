# Product Requirements Document — Fidelcom v3

**Branch:** v3  
**Date:** 2026-07-02  
**Status:** Complete — ready to merge to main

---

## Overview

v3 delivers a full-stack overhaul of the Fidelcom monorepo across three apps (backend API, admin CMS, public marketing site). The headline change is a ground-up EPAM-inspired redesign of the public frontend, paired with backend performance and slug infrastructure improvements, and a hardened admin CMS.

---

## 1. Backend — Laravel API

### 1.1 Database Migrations
| Migration | Purpose |
|---|---|
| `add_slug_to_categories_tables` | Adds `slug` column to blog_categories and project_categories |
| `make_slugs_non_nullable` | Enforces NOT NULL on all slug columns |
| `add_performance_indexes` | Composite indexes on frequently filtered columns |
| `add_status_to_posts_and_projects` | `status` enum (`draft` / `published`) for content control |

### 1.2 New Public API Controllers
- **`BlogCategoryController`** — public listing of blog categories (`GET /categories`)
- **`ProjectCategoryController`** — public listing of project categories (`GET /project-categories`)

### 1.3 Model & Query Improvements
- N+1 query fixes across all models (eager loading via `with()`)
- `ImageService` refactored for WebP generation and consistent storage paths
- All models audited for hidden/fillable/cast correctness

### 1.4 Infrastructure
- CORS config updated for `localhost:3002` (public frontend) and `localhost:3001` (admin)
- API routes reorganised; new public endpoints registered
- `FidelcomContentSeeder` added — seeds realistic demo content for all CMS entities

---

## 2. Frontend Admin — Nuxt 4 CMS

### 2.1 Auth System
- Replaced Pinia `auth.ts` store with a `useAuth` composable (Sanctum session-based)
- `auth.global.ts` middleware updated to use composable
- Login page cleaned up

### 2.2 New Composables
| Composable | Purpose |
|---|---|
| `useAuth` | Login, logout, fetchUser, isAuthenticated |
| `useToast` | App-wide toast notification state |
| `useAssetUrl` | Resolves backend media paths to full URLs |
| `useImageResize` | Client-side image compression before upload |

### 2.3 New Components
- **`AppToast`** — global toast notification overlay
- **`AppModal`** — improved confirm/delete modal
- **`AppPagination`** — server-side pagination component
- **`AppTable`** — sortable, loading-aware data table

### 2.4 Page Builder
- `pages/[id]/builder.vue` — visual drag-and-drop block ordering with live preview

### 2.5 CMS Pages Updated
Blog categories, projects, project categories, services, sliders, team, testimonials, partners, gallery, FAQs, menus, inquiries, media, settings — all pages updated with consistent CRUD patterns, search, and pagination.

---

## 3. Frontend Public — Nuxt 4 Marketing Site

### 3.1 EPAM-Inspired Redesign

#### SiteHeader
- Full edge-to-edge layout (no max-width container on the row)
- 64 px hamburger zone (left edge) + 64 px search zone (right edge) with `border-r` / `border-l` separators
- Scroll-aware: transparent → `bg-black/96 backdrop-blur-md` after 40 px
- Slide-down nav drawer

#### Slider (Hero)
- Full-viewport (`h-screen -mt-[72px]`) with canvas particle animation (90 glowing dots, `requestAnimationFrame`)
- Two-directional gradient overlay (protects header + anchors text)
- Headline: `clamp(2.2rem, 4.5vw, 4.5rem)` weight-300
- Bottom-right counter + circular arrow buttons + progress bar

#### Stats
- `220vh` sticky scroll section — numbers expand from `2rem` → `7rem` as user scrolls through
- Gradient numbers: `linear-gradient(135deg, #00d4ff, #5237f9)` with `-webkit-background-clip: text`
- Labels fade in at progress > 0.4

#### ServicesGrid
- 4-column Accenture-style card grid
- Full-bleed `object-cover` image cards + gradient scrim
- Solid brand/dark colour fallback cards
- Hover: description panel slides up from bottom (`translate-y-full → 0`, `cubic-bezier(0.16,1,0.3,1)`)

#### CaseStudy *(new)*
- Two-column layout: 48 % full-bleed image | 52 % dark text panel
- "CASE STUDY" label in primary colour, uppercase, wide tracking
- Category tags row, large bold underlined project title
- "Read More" + arrow CTA in primary colour
- Prev/Next cycling through up to 5 projects with crossfade transition
- Block type `case_study` registered in `BlockRenderer.vue` and `shared/types/api.ts`

### 3.2 New Pages
| Route | Purpose |
|---|---|
| `/login` | Minimal Sanctum session login (matches dark brand aesthetic) |
| `/request-quote` | Quote request form |

### 3.3 Auth System
- `useAuth` composable: `login()`, `logout()`, `fetchUser()`, `isAuthenticated`
- Fetches Sanctum CSRF cookie before POST; `credentials: 'include'` on all auth requests
- `middleware/auth.ts` — page-level guard (`definePageMeta({ middleware: 'auth' })`)

### 3.4 New Components
- **`CookieConsent`** — GDPR cookie banner
- **`Breadcrumbs`** — auto-generated from route path
- **`error.vue`** — custom error page (404 / 500)

### 3.5 Colour System
> **Brand primary `#5237f9` is the immutable core of the colour system — never changed.**

---

## 4. Shared

- `shared/types/api.ts` — `BlockType` union extended with `'case_study'`
- `User` interface confirmed: `id`, `name`, `email`, `role` (`admin | subadmin | analyst | user`)

---

## 5. Post-Merge Requirements

### Backend
```env
SANCTUM_STATEFUL_DOMAINS=localhost:3002,localhost:3001
SESSION_DOMAIN=localhost
```

### Videos (frontend-public/public/videos/)
Place these files before production deploy (free sources: pexels.com, mixkit.co, coverr.co):
- `hero-bg.mp4`
- `cta-bg.mp4`

### Fonts
Dev server restart required after `nuxt.config.ts` change — Sora 300/400 weights load on next start.

---

## 6. Out of Scope (Next Phase)
- Production deployment & environment variables
- Email notifications for quote requests
- CMS role-based permissions UI
- SEO sitemap auto-generation
