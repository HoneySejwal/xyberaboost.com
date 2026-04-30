# Brand and UI Rules

These rules come from the client brief. Every page must comply. A validation script should check them automatically before deploy.

## 1. Terminology (strict find-and-replace)

Across all user-facing text — UI copy, buttons, labels, emails, flash messages, page titles, nav:

| Wrong | Correct |
|---|---|
| "Redeem" (in purchase context) | "Purchase" |
| "Credits" (in user account context) | "Points" |
| "Available Credits" | "Available Points" |
| "Wallet" | "Account" |
| "All points will be directly deposited into your wallet" | "All points will be directly deposited into your account" |

**Backend note:** The word "Redeem" appears in backend contexts (`/pointsredeem` route, `status = 'Redeemed'`). Do NOT change backend values. Only user-facing UI text.

## 2. Game and service descriptions

- **Never repeat the game name at the start of its own description.**
  - ❌ "State of Survival: In State of Survival, humanity faces..."
  - ✅ "Dominate a zombie-infested wasteland as you rebuild civilization..."

- **Never repeat the service name inside its own description.**
  - ❌ "Earn consistent rewards with the Genshin Impact (Mobile) - Genshin Impact (Mobile) Daily & Weekly Commissions service."
  - ✅ "Earn consistent rewards from daily and weekly commissions without the grind."

- **Page `<title>` tags must match page content.**
  - ❌ `<title>All Games List</title>` on a page showing one specific game
  - ✅ `<title>Genshin Impact — Boosting Services</title>` — or use the product's `meta_title` field

## 3. Pricing rules

- Target base cost per service: **30 to 40 points** inclusive
- Training add-on hours: **20 points per hour**

Existing catalog data has prices outside this range (real DB: 18–92 USD range). Pending client clarification, enforce as:
- **Hard rule** for NEW service data added after redesign
- **Soft warning** for EXISTING service data — flag in validation but don't fail

## 4. Currency formatting

| Currency | Format | Example |
|---|---|---|
| USD | `$1,234.56` (2 decimals, comma thousands) | $1,500.00 |
| HKD | `HK$1,234.56` (2 decimals, comma thousands) | HK$1,500.00 |
| **JPY** | **`¥1,234` — NO decimals, comma thousands** | **¥1,500** |

JPY must never show decimal places. Enforce via a helper function, not by hoping templates do it right.

## 5. Checkout page

- **Do NOT display a "Subtotal" row.**
- Display: line items → discounts → shipping → **Total**.

## 6. Homepage disclaimer

Must display this exact line in visible body content (not just footer):

> "Purchased points can only be used on this website."

Ideally near the points purchase form or as a banner above/below it.

## 7. CTAs and links

- No `#` placeholder links. Every CTA must go to a real, specific page.
- Before deploy, crawl every page and flag 404s, redirect loops, and dead CTAs.

## 8. Reviews

- Do NOT render user reviews anywhere on the site.
- Remove review submission forms and review lists from product pages and blog.
- Backend review routes stay; the UI just doesn't surface them.

## 9. Footer copyright

```
© 2026 NexteraDigital. All Rights Reserved.
```

Confirm final client name before launch. Never ship a `<Company Name>` placeholder.

## 10. Newsletter signup

Must use exactly one of these two wordings (pick one and use site-wide):

- "Subscribe to our newsletter"
- "Subscribe for more updates"

## 11. Sign Up / Register page

### 11.1 "Already have an account" prompt — exact wording:

```
Already have an account? [Sign In]
```

`[Sign In]` is a link to the login page. Not "Log in", not "Login".

### 11.2 Terms & Conditions agreement — exact wording:

```
I agree with the [Terms & Conditions]
```

The word "**the**" must be present. Many AI-generated forms drop it. Check specifically.

## 12. Legal pages (Terms, Refund, Delivery, Privacy)

Each must have:
- h2 sub-headers, h3 sub-sub-headers
- Bullet points for multi-item lists
- Consistent alignment within sections
- No repeated content across pages
- Correct, current business terms
- Clean spelling, grammar, punctuation

Manually review every legal page before launch. These are the most common pages for typos and placeholder content to ship unnoticed.

## 13. Copy quality

Before deploy, every page checked for:
- Spelling errors
- Grammar
- Consistent punctuation
- Sparing use of `!` (no more than one per page section)
- Proper capitalization of game names and proper nouns
- Consistent alignment and spacing

Run copy through Grammarly or LanguageTool before final review.

## 14. Page `<title>` tags

Audit every page's browser tab label. Common failure: a specific-game page with `<title>All Games List</title>`. For product pages, prefer using the DB's `meta_title` field.

## 15. Order PDF

`/order/pdf/{id}` is intentionally public (sent via email). Do not add an auth check. Do not display a prominent "Download PDF" CTA on logged-out pages — surface only through email links.

## 16. Placeholder brand replacement

Every instance of "Lumina Etheris" from the Stitch design source must be replaced with "EliteLift Gaming" in the final site. The validation script should include a check that grep finds zero instances of "Lumina Etheris" across all Blade templates, CSS, and JS.

---

## Validation script (build early)

A PHP or Node CLI script that:

1. Greps views for forbidden user-facing terms: "Credits", "Wallet", "Redeem" (in purchase context)
2. Confirms signup page has "Already have an account? " and "I agree with the " verbatim
3. Confirms checkout does not contain a "Subtotal" row
4. Confirms homepage contains the disclaimer string
5. Checks every service's `base_points` against 30–40 range; separates existing-data WARN from new-data ERROR
6. Confirms JPY display uses a `formatJPY()` helper, not raw `number_format` with decimals
7. Lists every `<title>` tag across all pages for manual review
8. Greps all Blade templates, CSS, and JS for "Lumina Etheris" — must return zero results

Run before every deploy.
