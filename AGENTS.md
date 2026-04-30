# Project Context for Codex

## What we're doing

We are redesigning the frontend of an existing Laravel application (a game boosting site — EliteLift Gaming, operated by NexteraDigital). The backend is untouchable except for explicitly permitted exceptions listed below. This is a visual rebuild of the Blade views only.

**Footer copyright:** © 2026 EliteLift Gaming. All Rights Reserved.
**Logo:** `public/images/logo.png` — EliteLift Gaming ELG shield emblem. Use in header and footer.
**Newsletter wording (site-wide, no deviations):** "Subscribe to our newsletter"

**Stack we are keeping:** Laravel 10, Blade templates, jQuery (for existing JS — points calculator etc.), Vue 2, CSRF-protected forms, session auth, currency/locale middleware, existing controllers/routes/models.

**CSS/JS stack change:** Bootstrap 4.5 is REMOVED. Replaced with Tailwind CSS (local build, not CDN) configured via Vite (replacing Laravel Mix). Tailwind configured with design tokens from the Luminous Veil design system in `tailwind.config.js`. Icons: Material Symbols Outlined via Google Fonts CDN. New interactive components use Alpine.js or vanilla JS.

**What we are changing:** HTML, CSS, and interactive JS inside `resources/views/frontend/`, `resources/views/user/`, and related layout/asset files.

**What we are NOT changing:** Controllers, routes, middleware, models, migrations, the database, the payment gateway flow, the admin panel, or any backend business logic.

If a prompt would require a backend change, STOP and ask the user first.

## Reference documents (read in this order)

1. **`production-schema-findings.md`** — ground truth from the production SQL dump. Read first. Where it conflicts with `spec.md`, trust this file.
2. **`spec.md`** — backend contract: routes, models, auth, business rules, gotchas.
3. **`brand-rules.md`** — client terminology and UI rules. Non-negotiable.
4. **`/designs/`** — Stitch exports for homepage and a few other pages. These define the visual language.

## Tech constraints

- Keep Blade. Keep jQuery where existing JS uses it (e.g. points calculator); new interactive components use Alpine.js or vanilla JS.
- Keep the CSRF token meta tag and `@csrf` in every form.
- Keep all existing route paths, form field names, and request shapes — the backend expects them exactly.
- CSS: Tailwind CSS compiled via Vite (local build, not CDN). Design tokens in `tailwind.config.js` from the Luminous Veil system. No Bootstrap.

## Design approach

Stitch designs exist for homepage and a few pages. These define the visual system (colors, type, spacing, component styles).

For undesigned pages:
1. Propose a layout in plain text or ASCII first
2. Wait for user approval
3. Then build, using the same visual language as the designed pages

Never invent new visual patterns without sign-off.

## Preserving form contracts (critical)

Every form submits to an existing backend route. Do not rename fields or change methods. Examples:

- Login: POST `/user/login` with `email`, `password` + CSRF
- Register: POST `/user/register` with `name`, `email`, `password`, `password_confirmation`, `captcha` + CSRF
- Add to cart: POST `/add-to-cart` — note the unusual `quant[1]` array field, preserve it
- Points purchase: POST `/points-add-to-cart` with `slug`, `quant[]`, `price`, `points`
- Checkout: POST `/cart/order` — fields per `spec.md` section 3.6 exactly
- Contact: POST `/contact` (NOT the legacy `/contact/message`)

When rewriting a Blade template, read the existing one first and copy the form field structure before changing the visual design.

## Product fields to render on this site

Render these for the game boosting catalog:
- `title`, `title_jp`
- `slug`
- `summary`, `summary_jp`
- `description`, `description_jp`
- `extra_description`, `extra_description_jp` (stored as HTML `<li>` lists)
- `meta_title`, `meta_description`, `meta_keyword` (for SEO)
- `photo`, `price`, `price_jp`, `price_hk`
- `stock`, `status`, `condition`, `is_featured`
- `cat_id`, `child_cat_id`, `brand_id`

Ignore these (they exist from a shared codebase template but aren't used for this site):
- `duration`, `skill_level`, `skill_level_jp`, `lectures`, `language`, `language_jp`, `genres`

If an existing Blade template renders these, remove the references during redesign.

## Session workflow rules (saves credits)

1. One page (or one component) per session. Close and start fresh for the next task.
2. Before writing any code, list the files you plan to create or modify. Wait for user confirmation.
3. Read the existing Blade file before rewriting it. Preserve `@csrf`, `@auth`, `@guest`, `@if`, `@foreach`, `@yield`, `@section`, `@include`, and form action attributes. Only change markup and classes.
4. Mentally run the brand rules check before presenting output. Fix violations before showing.
5. Only edit files inside `resources/views/` (including `resources/views/user/`), `public/css/`, `public/js/`, `public/images/`, `resources/sass/`, `resources/lang/`, `tailwind.config.js`, `vite.config.js`, and `package.json`. Do not touch anything else without explicit permission.

## Out of scope

- Admin panel under `/admin` (except the one permitted exception below)
- Controllers, routes, middleware, models, migrations (except the one permitted exception below)
- Payment gateway integration
- Email sending logic
- Package dependency changes
- Any database changes (except the one permitted exception below)

## Explicitly permitted backend exceptions

The following backend changes have been explicitly approved by the user and are in scope:

1. **`categories.hero_image` field** — Add a nullable `hero_image` column to the `categories` table via migration. Update the admin category `store()` and `update()` controller methods to handle the upload (same pattern as existing `photo` field). Add a "Hero Image" upload field to the admin category create/edit Blade form. On the frontend, use `$category->hero_image` in hero sections with a CSS atmospheric fallback when null.

## Resolved open questions (from spec.md section 10)

- **Q1 (unknown fields):** All handled by backend team's custom work. `users.points`, `carts.hours`, `carts.points`, `sub_total_hk`, `total_amount_hk`, `orders.city`, `orders.state` all work in production. Use them in Blade as the current code does.
- **Q2 (enum drift):** Production columns accept the extended status values. Don't rely on migration enums.
- **Q3 (instructor pages):** Not live. Ignore.
- **Q4 (contact):** Use `/contact`, not `/contact/message`.
- **Q5 (architecture):** Path A — preserve server-rendered Blade with redirects and flash messages.
- **Q6 (implicit auth routes):** Keep as-is. Fix any broken links discovered during QA.
- **Q7–Q12:** Keep as-is.
