# Project Analysis — Session 1
**Date:** 2026-04-21
**Purpose:** Persistent memory for all future sessions. Read this at the start of every session before touching any files.

---

## A) Project Summary

We are rebuilding the frontend of **EliteLift Gaming** (operated by NexteraDigital), an existing Laravel 10 game boosting site, as a purely visual redesign of Blade templates — no backend changes except the one explicitly permitted exception listed below. **Path A** (server-rendered Blade with redirects and Flash messages) was chosen because the entire auth/cart/payment flow is tightly coupled to Laravel's session cookies, CSRF tokens, and redirect responses; decoupling it into a SPA would require backend changes that are out of scope. What we change: HTML/CSS/JS inside `resources/views/frontend/`, `resources/views/user/`, `public/css/`, `public/js/`, `public/images/`, `resources/sass/`, `resources/lang/`, `tailwind.config.js`, `vite.config.js`, `package.json`. What we do not touch: controllers, routes, models, migrations, the payment gateway flow, or the admin panel (except the one permitted exception). The design language comes from Stitch exports called the "Luminous Veil" system — a dark glassmorphism, cyan-glow gaming aesthetic — translated from the Tailwind-based exports into a local Tailwind + Vite build.

**Permitted backend exception (explicitly authorised by user 2026-04-21):**
Add nullable `categories.hero_image` column via migration. Update admin category `store()` / `update()` controller methods to handle upload. Add "Hero Image" upload field to admin category Blade form. Frontend uses `$category->hero_image` with CSS atmospheric fallback when null.

---

## B) Backend Contracts That Cannot Break

1. **`quant[1]`** — POST `/add-to-cart` must send the field exactly as `quant[1]` (PHP array-indexed). Not `quantity`, not `quant`. The controller reads `$request->quant[1]` directly.

2. **Synthetic `product_id = 1000`** — Points purchase uses this hardcoded ID. POST `/points-add-to-cart` with fields `slug`, `quant[]`, `price`, `points`. Cart mixing rule: cannot mix product_id=1000 rows with regular product rows.

3. **CSRF meta tag + `@csrf` in every form** — `<meta name="csrf-token">` must be in `<head>`. Every form must contain `@csrf`. Axios reads the meta tag for AJAX. Never remove either.

4. **POST `/contact`** — Not `/contact/message`. The legacy endpoint ends with `exit()` and returns no response. Only use `/contact`.

5. **Checkout form field names** — POST `/cart/order` requires exactly: `first_name`, `last_name`, `address1`, `address2`, `phone`, `city`, `post_code`, `email`, `state`, `country` (cannot be `0` or empty), `coupon`, `captcha`, `shipping`, `card_number`, `expiry_month`, `expiry_year`, `cvv`, `name`, `card_type`. Do not rename any field.

6. **Laravel session cookies** — Custom `user` middleware checks `session('user')` (not `Auth::check()`). Session must be present for all `user`-guarded routes. Guest cart uses `session('guest')` random integer — do not clear or interfere.

7. **Register form** — POST `/user/register` with `name` (letters/spaces only, max 40), `email`, `password`, `password_confirmation`, `captcha`. Registration may be blocked if ≥2 users created in last 24 hours — handle that flash gracefully.

8. **Blade directives** — Never remove or alter `@csrf`, `@auth`, `@guest`, `@if`, `@foreach`, `@yield`, `@section`, `@include`, or form action attributes. Only change surrounding markup and classes.

---

## C) Design Language — Luminous Veil System

### Source material
The design system is documented in `/designs/stitch_epic_gaming_hub/lumina_etheris/DESIGN.md` (titled "# Design System Document", creative north star named "The Luminous Veil"). Six Stitch page exports provide HTML + screenshots:
- `home_lumina_etheris_1/` — Homepage part 1
- `home_lumina_etheris_2/` — Homepage part 2
- `etheris_the_lost_light_details/` — Product detail
- `game_library_lumina_etheris/` — Game catalog / library
- `about_us_lumina_etheris/` — About Us
- `contact_us_lumina_etheris/` — Contact
- `privacy_policy_lumina_etheris/` — Privacy Policy

The fictional brand "Lumina Etheris" appears throughout — replace every instance with "EliteLift Gaming" (see brand-rules.md §16).

### Color Palette

| CSS custom property | Hex | Role |
|---|---|---|
| `--surface` / `--background` | `#0f0b22` | Master background — deep ink purple |
| `--surface-container-low` | `#140f29` | Card backgrounds, subtle lifts |
| `--surface-container` | `#1a1532` | Glass panels, modal cards |
| `--surface-container-high` | `#201b3a` | Elevated containers |
| `--surface-container-highest` | `#272143` | Highest surface level |
| `--surface-bright` | `#2d274b` | Bright surface accents |
| `--surface-container-lowest` | `#000000` | Pure black, deepest recesses |
| `--primary` | `#99f7ff` | Cyan accent — "spirit light" |
| `--primary-container` | `#00f1fe` | Brighter cyan — CTA gradient endpoint |
| `--on-primary` | `#005f64` | Dark teal — text on primary buttons |
| `--secondary` | `#e669ff` | Magenta/purple accent |
| `--secondary-container` | `#a000c0` | Deep purple |
| `--tertiary` | `#8aefff` | Lighter cyan |
| `--on-surface` | `#e9e1ff` | Primary text — lavender white |
| `--on-surface-variant` | `#aea7c6` | Muted text — muted lavender |
| `--outline` | `#77728e` | Standard borders |
| `--outline-variant` | `#49445f` | Ghost borders |
| `--error` | `#ff716c` | Error states |

### Typography

| Role | Family | Notes |
|---|---|---|
| Headlines / nav / buttons / labels | **Space Grotesk** | Google Fonts, weights 300–900 |
| Body / functional text | **Manrope** | Google Fonts, weights 300–800 |

Scale:
- Hero h1: 70–96px, `font-black`, `tracking-tight` or `tracking-tighter`, `leading-[0.9]`
- Section h2: 36–48px, `font-bold`–`font-black`, `tracking-tight`
- Sub-header h3: 24–36px, `font-black`
- Body: 18–20px, `leading-relaxed` (1.625)
- Nav links: `text-sm`, `uppercase`, `tracking-[0.1em]`, Space Grotesk (active: `font-bold`)
- Badges / labels: 10–12px, `uppercase`, `tracking-[0.2em]`–`tracking-[0.3em]`

### Spacing Scale
- Section vertical padding: 128px
- Container horizontal padding: 32–48px
- Card interior: 32–40px
- Component gaps: 16–32px
- Header-to-content margin: 64px

### Button Styles
- **Primary:** `border-radius: 9999px` (pill), gradient `#99f7ff → #00f1fe` at 135°, text `#005f64`, Space Grotesk bold uppercase, `box-shadow: 0 0 15px rgba(153,247,255,0.4)` (spirit glow), `hover: scale(1.05)`
- **Secondary/Ghost:** Pill, no fill, `border: 1px solid rgba(153,247,255,0.2–0.3)`, text `#99f7ff`, `hover: background rgba(153,247,255,0.1)`
- Padding: small `px-6 py-2`, large `px-10 py-4`

### Form Input Styles
- Underline-only or `background: #000000` fill — no 4-sided boxes
- Focus state: bottom border transforms to `#99f7ff` glow
- Text: `#e9e1ff` on dark background

### Card / Container Styles
- No hard borders — hierarchy via background color shifts only
- `border-radius: 0.75rem`
- Background: `#140f29` to `#1a1532`
- Ghost border fallback: `border: 1px solid rgba(255,255,255,0.05)`
- Hover: `backdrop-filter: blur(20px)`, `box-shadow: 0 20px 40px rgba(0,0,0,0.4)`
- Art overflow: game art may break card boundary (mask-out effect)

### Distinctive Visual Treatments
| Treatment | CSS value |
|---|---|
| Glassmorphism nav | `background: rgba(15,11,34,0.6); backdrop-filter: blur(20px)` |
| Spirit glow — buttons | `box-shadow: 0 0 15px rgba(153,247,255,0.4)` |
| Spirit glow — cards | `box-shadow: 0 0 25px rgba(153,247,255,0.2)` |
| Gradient text | `color: transparent; background-clip: text; background: linear-gradient(to right, #99f7ff, #e669ff)` |
| Ambient blur orbs | Large `border-radius: 50%` divs: `background: rgba(153,247,255,0.1); filter: blur(120px)` |
| Mist layer | `background: linear-gradient(to bottom, transparent, #0f0b22)` at section bottoms |
| Active nav indicator | 4×4px dot: `background: #00f2ff; border-radius: 50%; box-shadow: 0 0 8px #00f2ff` |
| No-Line Rule | Standard 1px solid borders strictly prohibited for sectioning — use background shifts only |

---

## D) Conflicts, Gaps, and Undesigned Pages

### Stitch vs backend / stack conflicts
1. **Stitch uses Tailwind; project was Bootstrap 4.5.** Resolved: Bootstrap removed, Tailwind local build via Vite adopted. All Stitch Tailwind utilities translate to the same Tailwind classes in the new build.
2. **Stitch uses Material Symbols Outlined.** Resolved: Material Symbols adopted site-wide via Google Fonts CDN. Existing `icofont-*` references removed during redesign.
3. **Stitch designs contain no points-purchase form or currency switcher.** These must be designed using the Luminous Veil visual language — layout proposed and approved in Session 1 (see Section G below).
4. **Stitch uses no flash message styling.** Must design success/error alert components from scratch in the design system.
5. **Bootstrap accordion** (`data-bs-toggle="collapse"`) used on current homepage. Replaced with Alpine.js accordion during redesign.

### Designed elements with no backend equivalent
- "New Adventure Awaits" hero badge → maps to `product.condition = 'hot'` or `is_featured = 1`
- "Scroll to explore" vertical decorative text → purely decorative
- Ambient blur orbs in hero backgrounds → purely decorative CSS

### Pages with Stitch designs
- Homepage (two files: home_lumina_etheris_1 + home_lumina_etheris_2)
- Product detail (etheris_the_lost_light_details)
- Game catalog / library (game_library_lumina_etheris)
- About Us (about_us_lumina_etheris)
- Contact (contact_us_lumina_etheris)
- Privacy Policy (privacy_policy_lumina_etheris)

### Pages NOT in designs (need derived layouts — propose ASCII first)
1. Cart (`/cart`)
2. Gamecart (`/gamecart`) — with training hours add-on
3. Checkout (`/checkout`) — billing form, card fields, captcha, shipping
4. Wishlist (`/wishlist`)
5. Login (`/user/login`)
6. Register (`/user/register`) — exact wording requirements apply
7. Forgot password (`/user/forgetpassword`)
8. Blog list (`/blog`)
9. Blog detail (`/blog-detail/{slug}`) — no comment form
10. Order tracking (`/product/track`)
11. Order success / order failed
12. CMS pages (`/pages/{slug}`)
13. Category pages (`/product-cat/{slug}`, `/product-sub-cat/`)
14. All user account pages — dashboard, profile, orders, reviews, comments, password change
15. FAQs (`/faqs`)
16. Database (`/database`)

---

## E) Brand Rule Compliance — Top Risks

Full rules in `brand-rules.md`. Top five most-likely accidental violations:

1. **"Credits" instead of "Points"** — Existing templates say "Available Credits." Every occurrence becomes "Points" or "Account." Backend route `/pointsredeem` and `status='Redeemed'` unchanged.
2. **Reviews on product detail page** — Existing `product_detail.blade.php` has a review form and list. Remove from UI. Backend review routes stay.
3. **Register page exact wording** — "Already have an account? **Sign In**" (not "Log in") and "I agree with **the** Terms & Conditions" (the word "the" is required).
4. **Homepage disclaimer** — "Purchased points can only be used on this website." must appear in visible body content near the points form — not only in footer.
5. **JPY decimal places** — Must render as `¥1,234` (no decimals). Use a `formatJPY()` helper. Any raw `number_format($price, 2)` will render JPY incorrectly.

---

## F) File Structure

Files to create or modify (do not touch anything outside this list without asking):

```
resources/views/frontend/
  layouts/
    master.blade.php          — modify: Vite directives, Google Fonts, CSRF meta, Alpine.js
    head.blade.php            — modify: per-page title, meta description
    header.blade.php          — modify: glassmorphism nav, logo, currency/language switchers, auth state
    footer.blade.php          — modify: © 2026 EliteLift Gaming, newsletter, no-# links
    notification.blade.php    — modify: flash message alert styles
  index.blade.php             — modify: full homepage redesign
  pages/
    about-us.blade.php
    contact.blade.php         — POST /contact only, captcha required
    product-grids.blade.php
    product-lists.blade.php
    product_detail.blade.php  — remove reviews
    cart.blade.php
    gamecart.blade.php
    checkout.blade.php        — critical form contracts
    wishlist.blade.php
    login.blade.php
    register.blade.php        — exact wording required
    forget-pwd-form.blade.php
    faqs.blade.php
    order-track.blade.php
    order-success.blade.php
    order-failed.blade.php
    page.blade.php
    cat-list.blade.php
    blog.blade.php
    blog-detail.blade.php     — remove comment form

resources/views/user/         — all in scope
  (dashboard, profile, orders, reviews, comments, password change)

public/
  css/app.css                 — compiled Tailwind output
  js/main.js                  — modify only if new interactive behaviors needed
  images/logo.png             — EliteLift Gaming logo (user drops this file)

resources/sass/
  app.scss                    — Tailwind directives, any custom CSS layers

tailwind.config.js            — Luminous Veil design tokens, font families, border-radius scale
vite.config.js                — replaces Laravel Mix webpack.mix.js
package.json                  — updated dependencies (Tailwind, Vite, Alpine.js)
```

**Permitted backend files (hero_image exception only):**
```
database/migrations/XXXX_add_hero_image_to_categories_table.php  — new
app/Http/Controllers/Admin/CategoryController.php                  — modify store/update
resources/views/backend/category/create.blade.php                 — add upload field
resources/views/backend/category/edit.blade.php                   — add upload field
```

---

## G) Session 1 Questions — Answers

**Q1 — Tailwind vs Bootstrap:** Bootstrap 4.5 removed entirely. Tailwind CSS local build via Vite (no CDN). Design tokens in `tailwind.config.js`. Tree-shaking enabled by default.

**Q2 — Icon library:** Material Symbols Outlined via Google Fonts CDN in master layout. Remove all `icofont-*` references during redesign.

**Q3 — User account page scope:** `resources/views/user/` IS in scope. CLAUDE.md updated.

**Q4 — Logo:** EliteLift Gaming ELG shield emblem. Path: `public/images/logo.png` (user drops file there). Use in header and footer.

**Q5 — Newsletter wording:** "Subscribe to our newsletter" — site-wide, no deviations.

**Q6 — Hero images:** Option B confirmed. New `categories.hero_image` nullable column, admin upload field, controller update. Frontend uses it with CSS atmospheric fallback when null. Full backend permission granted explicitly.

**Q7 — Homepage points form:** Reviewed existing `index.blade.php`. Form structure documented below. Layout proposed in ASCII and approved. Build in a later session after master layout is done.

---

## H) Homepage Points-Purchase Form — Extracted Structure

From `resources/views/frontend/index.blade.php`:

```html
<form action="{{route('points-add-to-cart')}}" method="POST">
    @csrf
    <input type="hidden" name="quant[1]" value="1">      {{-- MUST be exactly quant[1] --}}
    <input type="hidden" name="slug" value="points">
    <input type="number" name="price" id="price" min="1" max="9999999" required>
    {{-- Three live display counters (jQuery keyup on #price): --}}
    {{-- #pointst = base points, #bonus_pointst = bonus, #total_pointst = total --}}
    <input type="hidden" name="points" id="total_points">  {{-- computed by JS, submitted --}}
    <button type="submit">Add to Cart</button>
</form>
```

**jQuery calculator logic (currency-aware, must be preserved):**
- Reads `var currency = "{{ session('currency') }}"` baked into page JS
- `basicpoints(price)`: divides by currency rate (HKD/8, JPY/160, USD as-is), floors
- `calpoints(price)`: applies bonus multiplier ladder then divides by rate
  - USD tiers: 1× (<$601), 1.5× ($601–$2,000), 2× ($2,001–$3,200), 5× (>$3,200)
  - JPY tiers: 1× (<¥100,001), 1.5×, 2×, 5× — then divides by 160
  - HKD tiers: 1× (<HK$5,001), 1.5×, 2×, 5× — then divides by 8
- Updates `#pointst`, `#bonus_pointst`, `#total_pointst` counters live on keyup

**Approved homepage layout (ASCII):**
```
┌─────────────────────────────────────────────────────────────────────┐
│  HERO / BANNER                                                       │
│  (YouTube video background or CSS atmospheric glow)                 │
│  Headline · tagline · "Join Us Today" CTA                           │
└─────────────────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────────────────┐
│  GAME CATALOG SECTION                                                │
│  "Our Games" heading                                                 │
│  Expandable category rows (Alpine.js accordion)                     │
│  Category photo + summary + "Explore" button                        │
└─────────────────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────────────────┐
│  POINTS TOP-UP SECTION                   (glass panel on dark bg)   │
│  ┌───────────────────────────────────────────────────────────────┐  │
│  │  [badge: "POINTS SYSTEM"]                                     │  │
│  │  Heading: "Top Up Your Points"  (Space Grotesk, large)        │  │
│  │  Intro copy (from lang strings)                               │  │
│  │  ── Bonus Tier Table ─────────────────────────────────────    │  │
│  │  | Range    | Multiplier | Benefit |  (currency-aware)        │  │
│  │  ── Form ─────────────────────────────────────────────────    │  │
│  │  Enter Amount:                                                 │  │
│  │  ┌──────────────────────────────────┐                         │  │
│  │  │  $  [ price number input       ] │                         │  │
│  │  └──────────────────────────────────┘                         │  │
│  │  ┌────────────┐  ┌────────────┐  ┌────────────┐              │  │
│  │  │  1,200     │  │  + 300     │  │  = 1,500   │              │  │
│  │  │ Base Pts   │  │  Bonus     │  │  Total     │              │  │
│  │  └────────────┘  └────────────┘  └────────────┘              │  │
│  │  [ Add to Cart — primary pill button, spirit glow ]           │  │
│  │  ⚠ "Purchased points can only be used on this website."      │  │
│  └───────────────────────────────────────────────────────────────┘  │
└─────────────────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────────────────┐
│  HOW IT WORKS  (4 steps, horizontal)                                 │
└─────────────────────────────────────────────────────────────────────┘
┌─────────────────────────────────────────────────────────────────────┐
│  FEATURES  (4 cards)                                                 │
└─────────────────────────────────────────────────────────────────────┘
```

---

## I) Source vs. Framing Audit

**Terminology directly from source files:**

| Term | Source |
|---|---|
| "Luminous Veil" | `DESIGN.md` — Creative North Star name |
| "Design System Document" | `DESIGN.md` — document title |
| "spirit-glow" | HTML class in all Stitch `code.html` files |
| "glassmorphism" | `DESIGN.md` — "The Glass & Gradient Rule: Floating elements must utilize Glassmorphism" |
| "Ghost Border" | `DESIGN.md` — "The 'Ghost Border' Fallback" |
| "No-Line Rule" | `DESIGN.md` — "The 'No-Line' Rule" |
| "Immersive Cards" | `DESIGN.md` — section heading |
| "Translucent Navigation" | `DESIGN.md` — section heading |
| "Voice of Wonder" / "Voice of Clarity" | `DESIGN.md` — typography section headings |
| "spirit light" | `DESIGN.md` — "give buttons a 'spirit light' effect" |
| "mist-layer" | HTML class in Stitch `code.html` files |
| "Lumina Etheris" | Fictional placeholder brand in all Stitch files |
| "Path A" | `CLAUDE.md` — "Path A — preserve server-rendered Blade with redirects" |
| "Session 1 / Session 2" | `first-prompt.md` — explicit session structure |
| "EliteCarryHub" | `spec.md` document title — old project name, superseded by EliteLift Gaming |

**Terminology I created (descriptive framing, not from source):**

| Term | What it is |
|---|---|
| "Option A / B / C" | My labels for the three hero image approaches |
| "ambient blur orbs" | My description of the large decorative `blur-[120px]` divs in hero sections — HTML has them but gives no named concept |
| "atmospheric CSS-only backgrounds" | My description for what I called Option C |
| "backend contract" | Standard industry phrase I used to describe the form/route spec |

---

## J) Key Decisions Log

| Date | Decision |
|---|---|
| 2026-04-21 | Bootstrap 4.5 removed; Tailwind CSS + Vite adopted |
| 2026-04-21 | Material Symbols Outlined adopted; icofont removed |
| 2026-04-21 | `resources/views/user/` added to in-scope editable directories |
| 2026-04-21 | Logo: EliteLift Gaming ELG emblem at `public/images/logo.png` |
| 2026-04-21 | Footer copyright: © 2026 EliteLift Gaming. All Rights Reserved. |
| 2026-04-21 | Newsletter wording: "Subscribe to our newsletter" (site-wide, no deviations) |
| 2026-04-21 | Hero images: Option B — `categories.hero_image` column, backend change explicitly authorised |
| 2026-04-21 | "Lumina Etheris" placeholder → replace with "EliteLift Gaming" everywhere |
| 2026-04-21 | Layout rule: propose ASCII/plain text for every new page or component; wait for approval before writing HTML |

---

## K) Session 2 Starting Point

Before starting Session 2, drop the logo file at `public/images/logo.png`.

Session 2 scope: project foundation — Vite + Tailwind setup, master layout, header, footer.

Paste this prompt to start Session 2:

> Read `project-analysis.md`, `CLAUDE.md`, and `brand-rules.md` before doing anything.
>
> Session 2: Build the project foundation — Vite + Tailwind setup, master layout, header, and footer.
>
> Scope for this session only:
> 1. Replace Laravel Mix with Vite. Replace Bootstrap with Tailwind (local build). Configure `tailwind.config.js` with the Luminous Veil color tokens (all in project-analysis.md Section C), Space Grotesk + Manrope font families, and border-radius scale.
> 2. Rewrite `resources/views/frontend/layouts/master.blade.php` — Vite asset directives, Google Fonts CDN (Space Grotesk + Manrope + Material Symbols Outlined), CSRF meta tag, Alpine.js.
> 3. Rewrite `resources/views/frontend/layouts/header.blade.php` — EliteLift Gaming logo, glassmorphism nav, currency/language switchers, cart icon, auth state (@auth / @guest).
> 4. Rewrite `resources/views/frontend/layouts/footer.blade.php` — © 2026 EliteLift Gaming, newsletter form (POST /subscribe, field: email), links (no # placeholders).
>
> Show me the file list first. Then show ASCII layout for header and footer. Wait for approval before writing any code.
