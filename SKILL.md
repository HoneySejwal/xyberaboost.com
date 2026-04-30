---
name: elitelift-frontend-redesign-tailwind
description: Redesign and modernize the EliteLift Gaming frontend in Laravel Blade without changing backend behavior. Use when Codex needs to create a fresh premium look, explore new visual directions across repeated redesign passes, rebuild pages with Tailwind CSS, add tasteful animations, generate supporting images, and write matching content while preserving all backend contracts, routes, form fields, request payloads, session/auth behavior, locale/currency behavior, and server-rendered Blade logic.
---

# EliteLift Frontend Redesign Tailwind

Redesign the frontend of EliteLift Gaming so it feels premium, modern, and visually fresh without breaking backend functionality.

## Project Scope

This is a frontend rebuild of an existing Laravel application.

Allowed work:
- `resources/views/frontend/`
- `resources/views/user/`
- related layout files inside `resources/views/`
- `public/css/`
- `public/js/`
- `public/images/`
- `resources/sass/`
- `resources/lang/`
- `tailwind.config.js`
- `vite.config.js`
- `package.json`

Do not edit anything else unless the user explicitly approves it.

## Backend Safety Rule

Treat the backend as untouchable unless the user explicitly approves a backend change.

Do not change:
- Controllers
- Routes
- Middleware
- Models
- Migrations
- Database structure
- Payment gateway logic
- Admin panel behavior
- Email logic
- Validation behavior
- Session/auth flow
- Business logic

Exception:
- Only make backend changes already explicitly approved by the user

If a requested redesign would require a backend change, stop and ask first.

## Stack Rules

Keep:
- Laravel 10
- Blade templates
- jQuery where the current site already depends on it
- Vue 2 where already used
- CSRF-protected forms
- Session auth
- Existing middleware behavior
- Existing controllers/routes/models

Use:
- Tailwind CSS via local build
- Vite instead of Laravel Mix
- Design tokens from the Luminous Veil design system in `tailwind.config.js`
- Material Symbols Outlined via Google Fonts CDN
- Alpine.js or vanilla JS for new interactive UI behavior

Do not use:
- Bootstrap
- Framer Motion
- React just for animation
- New backend dependencies unless explicitly approved

## Brand Rules

Always follow the project brand rules and terminology.

Required global content:
- Footer copyright must be exactly: `© 2026 EliteLift Gaming. All Rights Reserved.`
- Logo path: `public/images/logo.png`
- Newsletter wording must be exactly: `Subscribe to our newsletter`

Use the EliteLift Gaming ELG shield emblem in header and footer where appropriate.

## Reference Reading Order

Before redesigning, read project references in this order:
1. `production-schema-findings.md`
2. `spec.md`
3. `brand-rules.md`
4. files under `/designs/`

When conflicts exist between `production-schema-findings.md` and `spec.md`, trust `production-schema-findings.md`.

## Redesign Modes

Use one of these modes based on the user’s request.

### Exploration Mode

Use this when the user asks for:
- a new look
- a fresh redesign
- another concept
- a totally different direction
- a modern refresh
- a redesign again

In Exploration Mode:
- create a distinctly new visual direction
- change layout composition
- vary hero structure
- vary section rhythm
- vary card treatments
- vary background style
- vary accent usage
- vary typography treatment
- vary animation style
- vary supporting image direction

Do not repeat the previous design language too closely unless required by the approved references.

### Refinement Mode

Use this when the user asks to:
- improve the current design
- polish the current page
- keep the same style but make it better
- iterate on the approved direction

In Refinement Mode:
- keep the overall direction
- improve quality, clarity, and hierarchy
- refine spacing, cards, CTA emphasis, and motion
- avoid changing the approved core look too drastically

### Mode Selection Rule

If the user clearly asks for a fresh look, default to Exploration Mode.
If the user asks for improvement of an approved direction, use Refinement Mode.

## Exploration Variety Rule

When doing repeated redesigns, do not generate the same page structure every time.

Across redesign attempts, vary combinations of:
- hero composition
- content density
- section order
- visual framing
- background atmosphere
- contrast level
- card geometry
- border/shadow treatment
- CTA styling
- image placement
- motion behavior

Keep the brand appropriate and the backend safe, but avoid repeating the same visual solution.

## Primary Goal

Create a complete frontend visual refresh that feels:
- premium
- bold
- game-focused
- conversion-oriented
- modern
- coherent across the site

Improve:
- layout
- spacing
- typography
- color usage
- hierarchy
- section composition
- cards
- forms
- navigation
- trust sections
- CTAs
- mobile responsiveness
- motion and interaction quality
- supporting visuals
- content tone

Do not create generic template-like pages.

## Design System Direction

Follow the visual language from the Stitch exports in `/designs/`.

For pages with existing designs:
- align closely to the provided visual system
- reuse the same color logic, spacing rhythm, card treatment, visual density, and page tone

For pages without designs:
1. propose the layout first in plain text or ASCII
2. if in Exploration Mode, propose a fresh direction that still fits the site
3. wait for user approval
4. then implement using the same overall quality level as the designed pages

Never invent completely new patterns without sign-off for undesigned pages.

## Page-by-Page Workflow

Work on one page or one component per session unless the user explicitly asks for more.

Before writing code:
1. list the files you plan to modify or create
2. wait for user confirmation
3. read the existing Blade file before rewriting it

Preserve all important Blade structures:
- `@csrf`
- `@auth`
- `@guest`
- `@if`
- `@foreach`
- `@yield`
- `@section`
- `@include`
- existing form action attributes

Only change markup, classes, styling, and frontend-safe interaction code.

## Form Contract Preservation

Every form must keep its existing backend contract exactly.

Never change:
- action URLs
- HTTP methods
- input names
- hidden field names
- array field shapes
- CSRF inclusion
- request payload structure

Critical examples:
- Login: `POST /user/login` with `email`, `password` and CSRF
- Register: `POST /user/register` with `name`, `email`, `password`, `password_confirmation`, `captcha` and CSRF
- Add to cart: `POST /add-to-cart` with the existing unusual `quant[1]` field preserved
- Points purchase: `POST /points-add-to-cart` with `slug`, `quant[]`, `price`, `points`
- Checkout: `POST /cart/order` with fields exactly matching `spec.md`
- Contact: `POST /contact` and not `/contact/message`

When redesigning a Blade form:
- read the existing template first
- copy the field structure exactly
- then restyle it

## Product Data Rules

Render these fields where relevant:
- `title`, `title_jp`
- `slug`
- `summary`, `summary_jp`
- `description`, `description_jp`
- `extra_description`, `extra_description_jp`
- `meta_title`, `meta_description`, `meta_keyword`
- `photo`, `price`, `price_jp`, `price_hk`
- `stock`, `status`, `condition`, `is_featured`
- `cat_id`, `child_cat_id`, `brand_id`

Ignore and remove presentation references for these unused fields:
- `duration`
- `skill_level`
- `skill_level_jp`
- `lectures`
- `language`
- `language_jp`
- `genres`

Do not remove backend logic. Only remove irrelevant frontend rendering.

## Tailwind Rules

Use Tailwind CSS as the primary styling system.

Prefer:
- strong spacing rhythm
- layered backgrounds and atmosphere
- expressive hero sections
- premium cards and pricing layouts
- clear typography hierarchy
- intentional mobile adaptations
- reusable patterns across the site
- design tokens defined in `tailwind.config.js`

When needed:
- extend `tailwind.config.js` with colors, shadows, spacing tokens, keyframes, gradients, and animation names that fit the Luminous Veil system

Do not fall back to Bootstrap patterns.

## Animation Rules

Use motion tastefully and with performance in mind.

Prefer:
- fade and slide reveals
- staggered entrances for cards and lists
- hover lift and glow
- smooth accordion, modal, drawer, and dropdown transitions
- subtle background motion
- polished CTA and hero interactions
- lightweight scroll-based reveals only when safe

Use:
- Tailwind transitions and transforms
- Tailwind opacity, blur, scale, translate, and duration utilities
- custom keyframes in `tailwind.config.js` when needed
- Alpine.js or vanilla JS for state-driven interactions

Avoid:
- jarring animation
- overuse of bouncing effects
- distracting constant movement
- slow heavy scroll scripting
- animations that harm readability or usability

Respect reduced motion where practical.

## Content Generation Rules

Generate content that matches the new design and the EliteLift Gaming brand direction.

In Exploration Mode:
- allow the tone and presentation to shift with the concept
- adapt headline style, section naming, and CTA framing to the design direction
- keep the copy aligned with the premium boosting/gaming context

Content may include:
- headlines
- subheadings
- trust copy
- feature blurbs
- CTA text
- category intros
- FAQ copy
- promotional support copy

Content should be:
- crisp
- confident
- premium
- easy to scan
- aligned with gaming/boosting context
- consistent with the current page purpose

Avoid:
- generic AI-sounding copy
- filler text
- unsupported claims
- repetitive hype language

Where backend content is already rendered dynamically, preserve data bindings and only improve surrounding static copy or presentation where safe.

## Image Generation Rules

Generate images when they improve the page design.

Examples:
- hero artwork
- atmospheric background visuals
- category hero banners
- section illustrations
- promotional gaming-themed graphics
- subtle decorative textures or overlays

In Exploration Mode:
- generate visuals that match the new design concept rather than repeating previous visual treatment
- vary composition, mood, lighting, framing, and texture direction while staying on-brand

Generated visuals must:
- match the Stitch-inspired page direction
- fit the page palette and mood
- feel premium and game-focused
- support readability and hierarchy
- stay consistent within the current redesign pass

Use existing assets and brand cues when available:
- logo in `public/images/logo.png`
- existing category/product imagery
- design tone established in `/designs/`

If a category hero image is available via `$category->hero_image`, use it.
If it is null, use a strong CSS atmospheric fallback rather than requiring backend changes.

Do not generate visuals that:
- look like unrelated stock art
- conflict with the brand
- use inconsistent illustration styles
- overpower important text content
- weaken trust or clarity

## SEO and Metadata Rules

If a page already binds SEO fields, preserve them:
- `meta_title`
- `meta_description`
- `meta_keyword`

Do not break existing metadata output.

## Session and Auth Rules

Preserve:
- session-driven behavior
- flash messages
- auth/guest rendering
- locale/currency logic
- existing redirects and server-rendered workflow

Path A architecture applies:
- preserve server-rendered Blade with redirects and flash messages

## Resolved Production Assumptions

Assume these production-backed fields work as currently used in Blade:
- `users.points`
- `carts.hours`
- `carts.points`
- `sub_total_hk`
- `total_amount_hk`
- `orders.city`
- `orders.state`

Do not remove or second-guess them if they appear in existing templates.

## Safe Redesign Checklist

For every page:
- preserve backend contracts exactly
- keep all Blade logic intact
- keep all forms submitting the same payloads
- keep locale and currency output intact
- keep auth conditions intact
- keep error and flash rendering intact
- keep SEO bindings intact
- keep route paths unchanged
- keep data variables unchanged
- improve hierarchy, spacing, visuals, and responsiveness
- add motion only where it helps UX
- generate visuals and content only when they strengthen the design

## Output Expectations

When handling redesign work:
- state which files will be edited before coding
- keep work scoped to one page or one component at a time unless told otherwise
- mention whether the task is being handled in Exploration Mode or Refinement Mode
- mention risky assumptions before implementation if needed
- after implementation, summarize the visual improvements
- confirm backend contracts were preserved
- mention whether new images or generated content were added

## Default Mindset

Work like a senior frontend designer-engineer refreshing a live production Laravel site with strict backend constraints.

Be bold in design.
Be disciplined in implementation.
Make the website feel dramatically better without risking backend behavior.
When asked to redesign again, intentionally produce a fresh direction instead of repeating the previous one.

## If Unsure

If a requested change could affect backend behavior, stop and ask the user before proceeding.
