# TODO - Virtual Tour Next.js Rewrite

## Blocker
- [x] ~~Prisma 7 SQLite datasource URL~~ -> fixed: added `@prisma/adapter-better-sqlite3`
- [x] ~~Verify build succeeds~~ after adapter fix (`npm run build`)

## Core Setup
- [x] Install shadcn/ui components: `button` (done), `input`, `form`, `card`, `dialog`, `table`, `dropdown-menu`, `avatar`, `badge`
- [x] Create `src/components/providers.tsx` (SessionProvider)
- [x] Integrate SessionProvider into root layout
- [x] Create API route: `src/app/api/auth/[...nextauth]/route.ts`
- [x] Create `.env.example`

## Auth Pages
- [x] Login page: `src/app/(auth)/login/page.tsx`
- [x] Register page: `src/app/(auth)/register/page.tsx`

## Public Pages
- [x] Landing page (`src/app/(public)/page.tsx`)
- [x] Public layout with navbar + footer
- [x] Wiki index page: `src/app/(public)/wiki/page.tsx`
- [x] Wiki article page: `src/app/(public)/wiki/[slug]/page.tsx`
- [x] Tour viewer page: `src/app/(tour)/tour/[slug]/page.tsx` (Pannellum wrapper)

## Admin Pages
- [x] Admin layout: `src/app/(admin)/layout.tsx` (sidebar + auth guard)
- [x] Admin dashboard: `src/app/(admin)/dashboard/page.tsx`
- [x] CRUD Venues: `src/app/(admin)/dashboard/venues/`
- [x] CRUD Scenes: `src/app/(admin)/dashboard/scenes/`
- [x] CRUD Hotspots: `src/app/(admin)/dashboard/hotspots/`
- [x] CRUD Categories: `src/app/(admin)/dashboard/categories/`
- [x] CRUD Wiki Categories: `src/app/(admin)/dashboard/wiki-categories/`
- [x] CRUD Wiki Articles: `src/app/(admin)/dashboard/wiki-articles/`
- [x] CRUD Users: `src/app/(admin)/dashboard/users/`
- [x] Site Settings: `src/app/(admin)/dashboard/settings/`

## API Routes
- [x] `src/app/api/venues/route.ts`
- [x] `src/app/api/venues/[id]/route.ts`
- [x] `src/app/api/storage/upload/route.ts`

## Data
- [x] Seed script: `prisma/seed.ts` — admin@tambawu.id / password123

## Storage
- [x] R2 client: `src/lib/storage.ts`

## Security
- [x] AUTH_SECRET added to .env
- [x] Proxy middleware (`src/proxy.ts`) for `/dashboard/*` auth protection
- [x] Input validation (zod) on login, register, and API routes

## Dev Notes
- Prisma 7: generated client at `node_modules/.prisma/client/index.js`
- Prisma 7 requires `{ adapter }` in `new PrismaClient()` — empty constructor fails
- SQLite adapter: `@prisma/adapter-better-sqlite3`
- NextAuth v5: `next-auth@beta`, JWT type augmentation uses `@auth/core/jwt`
- Tailwind v4: CSS-based config in `globals.css`
- DB file: `prisma/dev.db`
- Next.js 16: middleware renamed to proxy (`src/proxy.ts`)
- Seed: `npm run db:seed` or `npx prisma db seed`
- Admin login: admin@tambawu.id / password123
