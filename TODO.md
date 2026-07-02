# TODO - Virtual Tour Next.js Rewrite

## Blocker
- [x] ~~Prisma 7 SQLite datasource URL~~ -> fixed: added `@prisma/adapter-better-sqlite3`
- [ ] **Verify build succeeds** after adapter fix (`npm run build`)

## Core Setup
- [ ] Install shadcn/ui components: `button` (done), `input`, `form`, `card`, `dialog`, `table`, `dropdown-menu`, `avatar`, `badge`
- [ ] Create `src/components/providers.tsx` (SessionProvider)
- [ ] Integrate SessionProvider into root layout
- [ ] Create API route: `src/app/api/auth/[...nextauth]/route.ts`
- [ ] Create `.env.example`

## Auth Pages
- [ ] Login page: `src/app/(auth)/login/page.tsx`
- [ ] Register page: `src/app/(auth)/register/page.tsx`

## Public Pages
- [x] Landing page (`src/app/(public)/page.tsx`)
- [x] Public layout with navbar + footer
- [ ] Wiki index page: `src/app/(public)/wiki/page.tsx`
- [ ] Wiki article page: `src/app/(public)/wiki/[slug]/page.tsx`
- [ ] Tour viewer page: `src/app/(public)/tour/[slug]/page.tsx` (Pannellum wrapper)

## Admin Pages
- [ ] Admin layout: `src/app/(admin)/layout.tsx` (sidebar + auth guard)
- [ ] Admin dashboard: `src/app/(admin)/page.tsx`
- [ ] CRUD Venues: `src/app/(admin)/venues/`
- [ ] CRUD Scenes: `src/app/(admin)/scenes/`
- [ ] CRUD Hotspots: `src/app/(admin)/hotspots/`
- [ ] CRUD Categories: `src/app/(admin)/categories/`
- [ ] CRUD Wiki Categories: `src/app/(admin)/wiki-categories/`
- [ ] CRUD Wiki Articles: `src/app/(admin)/wiki-articles/`
- [ ] CRUD Users: `src/app/(admin)/users/`
- [ ] Site Settings: `src/app/(admin)/settings/`

## API Routes
- [ ] `src/app/api/venues/route.ts`
- [ ] `src/app/api/venues/[id]/route.ts`
- [ ] `src/app/api/storage/upload/route.ts`

## Data
- [ ] Seed script: `prisma/seed.ts`

## Storage
- [x] R2 client: `src/lib/storage.ts`

## Dev Notes
- Prisma 7: generated client at `node_modules/.prisma/client/index.js`
- Prisma 7 requires `{ adapter }` in `new PrismaClient()` — empty constructor fails
- SQLite adapter: `@prisma/adapter-better-sqlite3`
- NextAuth v5: `next-auth@beta`, JWT type augmentation uses `@auth/core/jwt`
- Tailwind v4: CSS-based config in `globals.css`
- DB file: `prisma/dev.db`
