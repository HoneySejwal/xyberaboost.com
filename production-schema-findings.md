# Production Schema Findings

Supplements `spec.md` with findings from the production SQL dump (`nexteradigital.sql`). Where this file and `spec.md` conflict, trust this file.

## Client name

**NexteraDigital** (from the SQL filename). Use in the copyright footer:

```
© 2026 NexteraDigital. All Rights Reserved.
```

Confirm with client before launch.

## Fields that exist in production but the spec flagged as "unknown"

### products

Confirmed present:

| Field | Type | Notes |
|---|---|---|
| `title_jp` | varchar(200) nullable | Japanese title |
| `summary_jp` | text nullable | Japanese summary |
| `description_jp` | text nullable | Japanese description |
| `meta_title` | text nullable | Render in `<title>` where useful |
| `meta_description` | text nullable | Render in `<meta name="description">` |
| `meta_keyword` | text nullable | Render in `<meta name="keywords">` |
| `price_jp` | double(8,2) nullable | JPY price |
| `price_hk` | double(8,2) default 0.00 | HKD price |
| `extra_description` | text nullable | HTML list format (`<li>...</li>`) |
| `extra_description_jp` | text nullable | Japanese extra description |

### carts

Confirmed present:

| Field | Type |
|---|---|
| `currency` | varchar(10) nullable |
| `price_jp` | double(8,2) nullable |
| `price_hk` | double(8,2) not null |
| `amount_jp` | double(16,2) not null |
| `amount_hk` | double(8,2) not null |

### orders

Confirmed present:

| Field | Type | Notes |
|---|---|---|
| `trans_id` | varchar(250) nullable | Payment transaction ID |
| `currency` | varchar(10) nullable | |
| `sub_total_jp` | double(8,2) default 0.00 | |
| `total_amount_jp` | double(8,2) nullable | |
| `status` | varchar(20) | Any string (not an enum) |
| `payment_method` | enum | Includes `credit_card` (extended from migration) |
| `payment_status` | varchar(20) | Any string (not an enum) |

### users

Confirmed present: `phone`, `address`, `city`, `state`, `country` (all nullable).

## Fields added by custom backend work (not in SQL dump but present in production)

The backend team has added these fields to production outside the standard migrations. Treat all of these as working. Use them in Blade templates as the current code does:

- `users.points`
- `carts.hours` (training add-on hours)
- `carts.points` (points granted by product 1000)
- `orders.sub_total_hk`
- `orders.total_amount_hk`
- `orders.city`
- `orders.state`

**Do not remove references to these fields.**

## Product fields to ignore on this site

These exist in the DB (they come from a shared codebase template used across multiple business types) but aren't used on this game boosting site:

- `duration`
- `skill_level`, `skill_level_jp`
- `lectures`
- `language`, `language_jp`
- `genres`

Wherever existing Blade templates reference these, remove the references.

## Real catalog data

Production DB already contains game boosting content:
- 26+ games with full English + Japanese text (title, summary, description, extra_description, meta fields)
- 200+ services with prices in USD / JPY / HKD
- 10+ real users

**You are redesigning a site with real content already in the DB.** You don't need to generate content from scratch.

Observations from real data:
- USD ↔ JPY ratio locked at 1:160, USD ↔ HKD at 1:8. These are stored at entry time, not live exchange rates. Don't try to "fix" this.
- Service prices range roughly 18–92 USD. This is outside the client brief's "30–40 points per service" target — see `brand-rules.md` section 3.

## Resolved open questions (from spec.md section 10)

| # | Resolution |
|---|---|
| 1 | Unknown fields all work in production (mix of standard schema + custom backend additions). |
| 2 | Order/payment status columns accept extended values the code writes. Don't rely on migration enum constraints. |
| 3 | Instructor pages not live. Ignore. |
| 4 | Use `/contact` (POST). Ignore `/contact/message`. |
| 5 | Path A — preserve server-rendered Blade flow. |
| 6 | Implicit `Auth::routes()` endpoints left as-is. Fix broken links during QA if any appear. |
| 7 | Payment gateway callback preserved exactly as-is. |
| 8 | Order PDF public by design (emailed to user). No auth check. Don't add a prominent download CTA on logged-out pages. |
| 9 | Legacy `/contact/message` ignored; new frontend uses `/contact`. |
| 10 | Points thresholds stay hardcoded. |
| 11 | `/cart/payment` is the canonical finalization endpoint. |
| 12 | File manager routes admin-only; not touched by this redesign. |

## One remaining clarification for the client (non-blocking)

**Pricing rule scope:** The "30–40 points per service" rule doesn't match existing catalog pricing (18–92 USD range). Ask the client:

> Does the 30–40 points rule apply to existing services already in the DB, or only to new services added going forward?

Default position until answered: soft warning for existing data, hard rule for new data.
