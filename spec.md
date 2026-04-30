# EliteCarryHub Frontend Rebuild Specification

## 1. Project Overview

This application is a Laravel-based ecommerce-style site that has been adapted into a points-plus-products flow. Anonymous and authenticated visitors can browse products, categories, blog posts, static CMS pages, and localized/currency-switched content, then either buy points/credits or add game/service products to a cart. Registered users can sign up, log in, manage their profile, place card-based orders, redeem purchased points against products, maintain wishlists, submit product reviews, and comment on blog posts. Administrators manage catalog data, orders, users, site settings, blog content, coupons, shipping methods, banners, messages, and notifications from the `/admin` area. The frontend rebuild must preserve the existing backend contract exactly, including Laravel session auth, CSRF-protected form submissions, guest-cart behavior, currency/language session switches, and the current payment callback flow.

## 2. Tech Stack (Backend)

| Area | Visible implementation |
|---|---|
| Language | PHP `^8.1` in `composer.json` |
| Backend framework | Laravel `v10.48.29` |
| Auth/session | Laravel session auth (`Auth::attempt`, `Auth::logout`, `auth` middleware) plus custom `user` middleware that checks `session('user')`; password reset uses Laravel auth scaffolding + custom routes/controllers |
| Database ORM | Eloquent ORM |
| Database driver support | `config/database.php` supports sqlite/mysql/mariadb/pgsql/sqlsrv; `.env` defines `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` |
| Primary schema sources present in repo | Laravel migrations + `database/e-shop.sql` dump |
| Frontend templating currently used | Blade templates |
| JS bundling | Laravel Mix `5.0.4`, Webpack, Vue `2.6.11` |
| CSS/JS libraries visible | Bootstrap `4.5.0`, jQuery `3.5.1`, Popper.js `1.16.1`, Axios `0.21.1`, Lodash `4.17.19` |
| Realtime/broadcast | `laravel-echo 1.8.0`, `pusher-js 6.0.3`, `pusher/pusher-php-server 7.2.7` |
| PDF generation | `barryvdh/laravel-dompdf v2.2.0` |
| Captcha | `bonecms/laravel-captcha v2.0.3` |
| Social login | `laravel/socialite v5.21.0` |
| PayPal | `srmklive/paypal 3.0.40` |
| Newsletter | `spatie/laravel-newsletter 5.3.1` |
| File manager | `unisharp/laravel-filemanager v2.10.1` |
| Images | `intervention/image 2.7.2` |
| AWS integrations | `aws/aws-sdk-php 3.362.1`; custom `S3Service` reads SMTP credentials from S3 bucket `po-websites` |
| Hosting/infrastructure clues | AWS-aware proxy headers in `TrustProxies`, AWS SDK, S3-backed SMTP credential fetch, SES-style mail configuration, explicit payment env URLs, Pusher/Echo broadcasting. The exact deployment target is not fully determinable from code alone. |

### Third-party services visible in code

- DAS/credit-card payment gateway via env vars `PAYMENT_URL`, `PAYMENT_STATUS_URL`, `USD_DASMID`, `JPY_DASMID`, `SECRET_KEY`, `X_API_KEY`
- PayPal Express Checkout
- Mailchimp newsletter integration
- Pusher broadcast channels
- AWS S3 for SMTP credential retrieval
- Laravel File Manager
- Captcha validation

## 3. API Contract

### Important note about this section

This codebase exposes **mostly web endpoints**, not a dedicated JSON API. Most routes return one of the following:

- a Blade HTML view
- a redirect with Laravel flash messages in session
- a file download
- a small JSON payload for a few AJAX endpoints

The new frontend must therefore preserve:

- CSRF token submission on all state-changing requests
- Laravel session cookies
- flash-message handling if you continue to rely on server redirects
- exact field names used by current controllers

### 3.1 Explicit API routes in `routes/api.php`

| Method | Path | Auth | Request | Response | Errors | Description |
|---|---|---:|---|---|---|---|
| GET | `/api/user` | `auth:api` | none | authenticated user object | 401 if unauthenticated | Default Laravel API route; not otherwise used in the repo. |

### 3.2 Authentication, account, language, currency

| Method | Path | Auth | Request schema | Response schema | Errors | Description |
|---|---|---:|---|---|---|---|
| GET | `/user/login` | No | none | HTML view `frontend.pages.login` | none explicit | Render login page. |
| POST | `/user/login` | No | `email:string`, `password:string` | redirect to `/` or `/checkout`; flash success/error | login failure -> redirect back with flash error `invalid_email_password` | Session login using `Auth::attempt(['email','password','status'=>'active'])`. Also migrates guest cart to authenticated user. |
| GET | `/user/logout` | No (but meaningful only if logged in) | none | redirect to `/`; clears `session('user')`, logs out | none explicit | Log out current user. |
| GET | `/user/register` | No | none | HTML view `frontend.pages.register` | none explicit | Render registration page. |
| POST | `/user/register` | No | `name:string|required|max:40|regex:/^[A-Za-z\s]+$/`, `email:string|required|email|unique:users,email`, `password:string|required|min:6|confirmed`, `password_confirmation:string`, `captcha:string|required|captcha` | redirect to login page on success; flash success/error | validation errors; rate-limited by custom business rule (see section 6) | Create end-user account with status `active`. |
| POST | `/check-email` | No | `email:string` | JSON `{ exists: boolean }` | none explicit | AJAX email existence check. |
| GET | `/user/forgetpassword` | No | none | HTML view from forgot password controller | none explicit | Password reset request form. |
| GET | `/password/reset` | No | none | HTML forgot/reset form | none explicit | Password reset request form (declared twice in routes). |
| POST | `/password/email` | No | Laravel forgot-password payload (email field expected by framework) | redirect/flash per Laravel auth scaffolding | framework validation/errors | Send password reset email. |
| GET | `/password/reset/{token}` | No | path `token:string` | HTML reset form | invalid token handling via framework | Render password reset form for token. |
| POST | `/password/reset` | No | Laravel reset payload (`token`, `email`, `password`, `password_confirmation`) | redirect/flash per framework | validation/token errors | Complete password reset. |
| GET | `/login/{provider}` | No | path `provider:string` | redirect to Socialite provider | provider errors | Start social login. |
| GET | `/login/{provider}/callback/` | No | provider callback params | redirect to `/` or home with login | provider/user creation errors | Complete social login. |
| GET | `/change-language/{lang}` | No | path `lang: 'en' | 'ja'` | redirect back with flash success | unsupported language silently ignored | Writes `session('app_locale')`. |
| GET | `/change-currency/{currency}` | No | path `currency: 'USD' | 'HKD' | 'JPY'` | redirect back with flash success | unsupported currency silently ignored | Writes `session('currency')`. |

### 3.3 Public storefront pages and discovery

| Method | Path | Auth | Request schema | Response schema | Errors | Description |
|---|---|---:|---|---|---|---|
| GET | `/` | No | none | HTML view `frontend.index` | none explicit | Home page with banners, featured products, posts, categories, instructors. |
| GET | `/home` | Yes (because controller uses current user role) | none | redirect to route named by authenticated user role | unauthenticated behavior depends on controller/request state | Role-based landing redirect. |
| GET | `/about-us` | No | none | HTML view `frontend.pages.about-us` | none explicit | Static about page. |
| GET | `/faqs` | No | none | HTML view `frontend.pages.faqs` | none explicit | Static FAQ page. |
| GET | `/contact` | No | none | HTML view `frontend.pages.contact` | none explicit | Contact page. |
| GET | `/product-detail/{slug}` | No | `slug:string` | HTML view `frontend.pages.product_detail` with `product_detail` | invalid slug produces null data path; no explicit 404 | Product detail page. |
| POST | `/product/search` | No | `search:string` | HTML view `frontend.pages.product-grids` with search result pagination | none explicit | Search products by title/slug/description/summary/price. |
| GET | `/product-cat/{slug}` | No | `slug:string` | HTML view `frontend.pages.cat-list` | invalid slug handling not explicit | Category landing page. |
| GET | `/product-sub-cat/{slug}/{sub_slug}` | No | `slug:string`, `sub_slug:string` | HTML view `frontend.pages.cat-list` | invalid slugs handling not explicit | Subcategory landing page. |
| GET | `/product-brand/{slug}` | No | `slug:string` | HTML view product grid/list | contains dead code path in controller (`return $brand_ids;`) for list/grid filtering logic elsewhere | Brand landing page. |
| GET | `/product-grids` | No | query params optional: `category:string(csv slugs)`, `brand:string(csv slugs)`, `sortBy:'title'|'price'`, `price:'min-max'`, `show:int` | HTML view `frontend.pages.product-grids` with paginated products | none explicit | Grid catalog page. |
| GET | `/product-lists` | No | same query params as above | HTML view `frontend.pages.product-lists` with paginated products | none explicit | List catalog page. |
| GET or POST | `/filter` | No | body/query optional: `show`, `sortBy`, `category:string[]`, `brand:string[]`, `price_range:string` | redirect to grid/list route with built query string | none explicit | Filter helper endpoint; does not itself return filtered products. |
| GET | `/blog` | No | none | HTML view `frontend.pages.blog` | none explicit | Blog landing page. |
| GET | `/blog-detail/{slug}` | No | `slug:string` | HTML view `frontend.pages.blog-detail` | invalid slug handling not explicit | Blog article page. |
| GET | `/blog/search` | No | query `search:string` | HTML blog list view | none explicit | Search blog posts. |
| POST | `/blog/filter` | No | filtering fields from blog sidebar form | HTML blog list view | none explicit | Filter blog posts. |
| GET | `/blog-cat/{slug}` | No | `slug:string` | HTML blog list view | none explicit | Blog posts by category. |
| GET | `/blog-tag/{slug}` | No | `slug:string` | HTML blog list view | none explicit | Blog posts by tag. |
| POST | `/subscribe` | No | `email:string` | redirect to `/` or back with flash success/error | newsletter provider failure | Newsletter subscription. |
| GET | `/sitemap.xml` | No | none | XML response | none explicit | XML sitemap built from active products and categories. |
| GET | `/pages/{slug}` | No | `slug:string` | HTML view `frontend.pages.page` | no explicit 404 | CMS page by slug. |
| GET | `/{slug}` | No | `slug:string` | HTML view `frontend.pages.page` | route catch-all may swallow unexpected paths | Catch-all CMS page route. |
| GET | `/database` | No | none | HTML view `frontend.pages.database` | none explicit | Static page. |
| GET | `/instructor` | No | none | expected HTML view `frontend.pages.instructor` | **view file missing in repo** | Instructor list page. |
| GET | `/instructor/{slug}` | No | `slug:string` | expected HTML view `frontend.pages.instructor-detail` | **view file missing in repo** | Instructor detail page. |

### 3.4 Contact and messages

| Method | Path | Auth | Request schema | Response schema | Errors | Description |
|---|---|---:|---|---|---|---|
| POST | `/contact/message` | No | `name:string|required|min:2`, `email:email|required`, `message:string|required|min:20|max:200`, `subject:string|required`, `phone:numeric|required` | no normal HTTP response path; controller creates `Message`, fires `MessageSent`, then `exit()` | validation errors | Legacy contact-message creation endpoint used by older frontend flow. |
| POST | `/contact` | No | `name:string|required`, `subject:string|required`, `email:email|required`, `phone:required`, `message:required`, `captcha:required|captcha` | redirect to `/contact` with flash success | validation errors; mail exceptions only logged | Sends admin + user contact emails. |
| GET | `/admin/message` | Admin | none | HTML admin message index | auth/role redirects | List messages. |
| GET | `/admin/message/five` | Admin | none | JSON array of up to 5 unread messages | auth/role redirects | AJAX unread message list. |
| GET | `/admin/message/{message}` | Admin | path `id:int` | HTML admin message detail | if not found redirects back | Marks message read. |
| DELETE | `/admin/message/{message}` | Admin | path `id:int` | redirect back with flash success/error | not found => error | Delete message. |

### 3.5 Cart, points purchase, wishlist, checkout, coupon

| Method | Path | Auth | Request schema | Response schema | Errors | Description |
|---|---|---:|---|---|---|---|
| GET | `/add-to-cart/{slug}` | Logged-in user expected by implementation | `slug:string` | redirect back with flash success/error | invalid slug; stock insufficient; unauthenticated use would break because controller assumes `auth()->user()` | Add one unit of product to authenticated cart. |
| POST | `/add-to-cart` | Guest or auth | `slug:string|required`, `quant:array|required` where controller reads `quant[1]`; optional `hours` | redirect back with flash success/error | invalid product; stock failure; product already in cart; mixed cart rule violation | Add game/service product with quantity and optional training hours. |
| POST | `/points-add-to-cart` | Guest or auth | `slug:string|required`, `quant:array|required` (controller ignores semantic value), `price:numeric`, `points:numeric` | redirect back with flash success/error | mixed cart rule violation | Add or update special points purchase line item using synthetic `product_id = 1000`. |
| GET | `/cart-delete/{id}` | No middleware | path `id:int` | redirect back with flash success/error | invalid ID | Delete cart line item. |
| POST | `/cart-update` | No middleware | arrays `quant[]`, `qty_id[]` | redirect back with flash success/error | invalid cart IDs | Update cart quantities. |
| GET | `/trainingdelete/{id}` | No middleware | path `id:int` | redirect back with flash success | invalid cart ID not handled explicitly | Remove training-hour surcharge by resetting cart row pricing to base product price and `hours=0`. |
| GET | `/pointsredeem` | `user` middleware | none | redirect back with flash success/error | insufficient user points | Redeem current cart using stored user points instead of card payment. |
| GET | `/cart` | No | none | HTML view `frontend.pages.cart` | none explicit | Cart page shell. |
| GET | `/gamecart` | `user` middleware | none | HTML view `frontend.pages.gamecart` | auth redirect | Game/service cart page shell. |
| GET | `/checkout` | `user` middleware | none | HTML view `frontend.pages.checkout` or `frontend.pages.gamecart` | auth redirect | Decides which checkout/cart UI to show based on whether cart contains product `1000` (points purchase). |
| GET | `/wishlist` | No | none | HTML view `frontend.pages.wishlist` | none explicit | Wishlist page shell. |
| GET | `/wishlist/{slug}` | `user` middleware | `slug:string` | redirect back with flash success/error | invalid product; duplicates | Add product to wishlist. |
| GET | `/wishlist-delete/{id}` | No middleware | path `id:int` | redirect back with flash success/error | invalid ID | Remove wishlist item. |
| POST | `/coupon-store` | Auth expected by implementation | `code:string` | redirect back with flash success/error; writes `session('coupon')` as `{id, code, value}` | invalid coupon code | Apply coupon to current authenticated cart. |

### 3.6 Orders, payment, tracking, success/failure

| Method | Path | Auth | Request schema | Response schema | Errors | Description |
|---|---|---:|---|---|---|---|
| POST | `/cart/order` | Auth expected by implementation | `first_name:string|required`, `last_name:string`, `address1:string|required`, `address2:string|nullable`, `coupon:numeric|nullable`, `phone:numeric|required`, `city:string|required`, `post_code:string|required`, `email:string|required`, `state:string|required`, `country:string|required not_in:0,""`, `captcha:string|required|captcha`, plus payment fields read directly: `shipping`, `card_number`, `expiry_month`, `expiry_year`, `cvv`, `name`, `card_type` | redirect to external payment gateway, or redirect to `/cart/payment?...`, or back with validation/flash error | validation errors; empty cart; invalid CVC; payment API failure paths | Creates order row, assigns current cart rows to it, then calls DAS payment API. |
| GET | `/cart/payment` | Auth expected by implementation | query includes `payment_status`, `oid`, `transaction_id`; internally may call external payment-status API | HTML success or failure view | forbidden / missing txn / unsuccessful status -> failure view | Payment callback/finalization endpoint. Also increments user `points` **once per transaction id** when purchased line item is product `1000`. |
| GET | `/payment` | Auth | none | redirect to PayPal checkout URL | provider errors | PayPal Express checkout starter for current open cart. |
| GET | `/payment/success` | No | query returned by gateway | for DAS path: `dd` in `DasGatewayController::success`; for PayPal path handled by `PaypalController::success` because route name collision exists in codebase | ambiguous due controller naming inconsistency | Success callback route name exists but real active path for card flow is `/cart/payment`. |
| GET | `/payment/failed` | No | query params | HTML failure view | none explicit | Failure callback route. |
| GET | `/order/pdf/{id}` | No middleware declared | path `id:int` | PDF file download | invalid order ID unhandled | Download order PDF. |
| GET | `/income` | No middleware declared | none | array/object of monthly amounts | none explicit | Current-year income chart data from delivered orders. |
| GET | `/product/track` | No | none | HTML view `frontend.pages.order-track` | none explicit | Order tracking page. |
| POST | `/product/track/order` | Auth expected by implementation | `order_number:string` | redirect home/back with flash message | invalid order number; order not belonging to current user | Track order status by order number. |

### 3.7 Reviews and blog comments

| Method | Path | Auth | Request schema | Response schema | Errors | Description |
|---|---|---:|---|---|---|---|
| POST | `/product/{slug}/review` | Auth expected by implementation | path `slug:string`; body includes `rate:numeric|required|min:1`, and controller also reads `name`, `email` | redirect back with flash success/error | validation errors | Create product review with status `active`; notifies admins. |
| GET | `/review` | No middleware in routes | none | HTML admin review index | access control depends on UI exposure only | Resource route. |
| GET | `/review/{review}/edit` | No middleware in routes | path `id:int` | HTML edit form | none explicit | Edit review. |
| PUT/PATCH | `/review/{review}` | No middleware in routes | arbitrary review fields from request | redirect to review index | review missing -> flash error | Update review. |
| DELETE | `/review/{review}` | No middleware in routes | path `id:int` | redirect to review index | none explicit | Delete review. |
| POST | `/post/{slug}/comment` | Auth expected by implementation | path `slug:string`; body fields inferred from model/controller: `comment`, optional `parent_id`, optional `replied_comment` | redirect back with flash success/error | validation behavior depends on controller | Create blog comment/reply. |
| GET | `/comment` | No middleware in routes | none | HTML comment index | UI-only access control | Resource route. |
| GET | `/comment/{comment}/edit` | No middleware in routes | path `id:int` | HTML edit view | none explicit | Edit comment. |
| PUT/PATCH | `/comment/{comment}` | No middleware in routes | arbitrary request fields | redirect to comment index/back | none explicit | Update comment. |
| DELETE | `/comment/{comment}` | No middleware in routes | path `id:int` | redirect back/index | none explicit | Delete comment. |

### 3.8 Admin routes

All routes below are inside prefix `/admin` and require both `auth` and `admin` middleware unless otherwise noted.

#### Admin dashboard/profile/settings/password/system

| Method | Path | Request schema | Response schema | Errors | Description |
|---|---|---|---|---|---|
| GET | `/admin/` | none | HTML `backend.index` | auth/role redirects | Admin dashboard. |
| GET | `/admin/file-manager` | none | HTML file manager wrapper | auth/role redirects | File manager page. |
| GET | `/admin/profile` | none | HTML profile view | auth/role redirects | Admin profile. |
| POST | `/admin/profile/{id}` | arbitrary user fields; no explicit validation | redirect back with flash | invalid user ID -> 404 | Update admin profile. |
| GET | `/admin/settings` | none | HTML settings page | auth/role redirects | Site settings form. |
| POST | `/admin/setting/update` | `short_des:string|required`, `description:string|required`, `photo:required`, `logo:required`, `address:string|required`, `email:email|required`, `phone:string|required` | redirect to `/admin` with flash | validation errors | Update singleton `settings` row. |
| GET | `/admin/change-password` | none | HTML password change view | auth/role redirects | Admin password form. |
| POST | `/admin/change-password` | `current_password:required|MatchOldPassword`, `new_password:required`, `new_confirm_password:same:new_password` | redirect to `/admin` with flash | validation errors | Change admin password. |
| GET | `/storage-link` | none | redirect back with flash | artisan exceptions | Recreate Laravel storage symlink. |
| GET | `/cache-clear` | none | redirect back with flash | none explicit | Run `optimize:clear`. |

#### Admin resource CRUD endpoints

The following resource groups follow standard Laravel resource URIs under `/admin`. Where `show()` is empty in controller, route exists from `Route::resource` but backend behavior is effectively undefined/no-op.

##### Users

| Method | Path | Request schema | Response schema | Description |
|---|---|---|---|---|
| GET | `/admin/users` | none | HTML index | List users. |
| GET | `/admin/users/create` | none | HTML create form | Create form. |
| POST | `/admin/users` | `name:string|required|max:30`, `email:string|required|unique:users`, `password:string|required`, `role:'admin'|'user'`, `status:'active'|'inactive'`, `photo:string|nullable` | redirect to index with flash | Store user. |
| GET | `/admin/users/{id}` | none | no meaningful implementation | Show route exists but method empty. |
| GET | `/admin/users/{id}/edit` | none | HTML edit form | Edit user. |
| PUT/PATCH | `/admin/users/{id}` | `name:string|required|max:30`, `email:string|required`, `role:'admin'|'user'`, `status:'active'|'inactive'`, `photo:string|nullable` | redirect to index with flash | Update user. |
| DELETE | `/admin/users/{id}` | none | redirect to index with flash | Delete user. |

##### Banner

| Method | Path | Request schema | Response schema | Description |
|---|---|---|---|---|
| GET | `/admin/banner` | none | HTML index | List banners. |
| GET | `/admin/banner/create` | none | HTML create form | Create form. |
| POST | `/admin/banner` | `title:string|required|max:50`, `description:string|nullable`, `photo:string|required`, `status:'active'|'inactive'` | redirect to index with flash | Store banner, slug auto-generated. |
| GET | `/admin/banner/{id}` | none | method intentionally unimplemented | Resource show route exists but no implementation. |
| GET | `/admin/banner/{id}/edit` | none | HTML edit form | Edit banner. |
| PUT/PATCH | `/admin/banner/{id}` | same as store except slug unchanged | redirect to index with flash | Update banner. |
| DELETE | `/admin/banner/{id}` | none | redirect to index with flash | Delete banner. |

##### Brand

| Method | Path | Request schema | Response schema | Description |
|---|---|---|---|---|
| GET | `/admin/brand` | none | HTML index | List brands. |
| GET | `/admin/brand/create` | none | HTML create form | Create form. |
| POST | `/admin/brand` | `title:string|required`, `status:'active'|'inactive'` | redirect to index with flash | Store brand; slug auto-generated. |
| GET | `/admin/brand/{id}` | none | empty implementation | Resource show exists but not implemented. |
| GET | `/admin/brand/{id}/edit` | none | HTML edit form | Edit brand. |
| PUT/PATCH | `/admin/brand/{id}` | `title:string|required`, `status:'active'|'inactive'` | redirect to index with flash | Update brand. |
| DELETE | `/admin/brand/{id}` | none | redirect to index with flash | Delete brand. |

##### Category

| Method | Path | Request schema | Response schema | Description |
|---|---|---|---|---|
| GET | `/admin/category` | none | HTML index | List categories. |
| GET | `/admin/category/create` | none | HTML create form | Create form. |
| POST | `/admin/category` | `title:string|required`, `summary:string|nullable`, `photo:string|nullable`, `status:'active'|'inactive'`, `is_parent:'1'|nullable`, `parent_id:exists:categories,id|nullable` | redirect to index with flash | Store category; slug auto-generated; `is_parent` defaults to `0` if unchecked. |
| GET | `/admin/category/{id}` | none | empty implementation | Resource show exists but not implemented. |
| GET | `/admin/category/{id}/edit` | none | HTML edit form | Edit category. |
| PUT/PATCH | `/admin/category/{id}` | same as store | redirect to index with flash | Update category. |
| DELETE | `/admin/category/{id}` | none | redirect to index with flash | Delete category; child categories are shifted to parent (`is_parent=1`) if needed. |
| POST | `/admin/category/{id}/child` | route path carries `{id}` but controller actually reads `$request->id` | JSON `{status:boolean,msg:string,data:null|object}` | Return child categories by parent. |

##### Product

| Method | Path | Request schema | Response schema | Description |
|---|---|---|---|---|
| GET | `/admin/product` | none | HTML index | List products. |
| GET | `/admin/product/create` | none | HTML create form | Create form. |
| POST | `/admin/product` | validated fields: `title:string|required`, `summary:string|required`, `description:string|nullable`, `photo:string|required`, `stock:string|required`, `cat_id:exists:categories,id|required`, `status:'active'|'inactive'`, `price:string|required`; controller also accepts optional `is_featured`, `size[]` | redirect to index with flash | Store product; slug auto-generated. |
| GET | `/admin/product/{id}` | none | empty implementation | Resource show exists but not implemented. |
| GET | `/admin/product/{id}/edit` | none | HTML edit form | Edit product. |
| PUT/PATCH | `/admin/product/{id}` | only `title` explicitly validated in current code; controller also consumes optional `is_featured`, `size[]`, and whatever other fields are passed through request but not validated | redirect to index with flash | Update product. |
| DELETE | `/admin/product/{id}` | none | redirect to index with flash | Delete product. |

##### Post category, post tag, post

| Method | Path | Request schema | Response schema | Description |
|---|---|---|---|---|
| GET | `/admin/post-category` | none | HTML index | List post categories. |
| GET | `/admin/post-category/create` | none | HTML create form | Create form. |
| POST | `/admin/post-category` | `title:string|required`, `status:'active'|'inactive'` | redirect with flash | Store post category; slug auto-generated. |
| GET | `/admin/post-category/{id}` | none | empty implementation | Show exists but no implementation. |
| GET | `/admin/post-category/{id}/edit` | none | HTML edit form | Edit post category. |
| PUT/PATCH | `/admin/post-category/{id}` | `title:string|required`, `status:'active'|'inactive'` | redirect with flash | Update post category. |
| DELETE | `/admin/post-category/{id}` | none | redirect with flash | Delete post category. |
| GET | `/admin/post-tag` | none | HTML index | List post tags. |
| GET | `/admin/post-tag/create` | none | HTML create form | Create form. |
| POST | `/admin/post-tag` | `title:string|required`, `status:'active'|'inactive'` | redirect with flash | Store post tag; slug auto-generated. |
| GET | `/admin/post-tag/{id}` | none | empty implementation | Show exists but no implementation. |
| GET | `/admin/post-tag/{id}/edit` | none | HTML edit form | Edit post tag. |
| PUT/PATCH | `/admin/post-tag/{id}` | `title:string|required`, `status:'active'|'inactive'` | redirect with flash | Update post tag. |
| DELETE | `/admin/post-tag/{id}` | none | redirect with flash | Delete post tag. |
| GET | `/admin/post` | none | HTML index | List posts. |
| GET | `/admin/post/create` | none | HTML create form | Create form. |
| POST | `/admin/post` | `title:string|required`, `quote:string|nullable`, `summary:string|required`, `description:string|nullable`, `photo:string|nullable`, `tags:nullable`, `added_by:nullable`, `post_cat_id:required`, `status:'active'|'inactive'` | redirect with flash | Store post; slug auto-generated; `tags[]` are imploded to comma string. |
| GET | `/admin/post/{id}` | none | empty implementation | Show exists but no implementation. |
| GET | `/admin/post/{id}/edit` | none | HTML edit form | Edit post. |
| PUT/PATCH | `/admin/post/{id}` | same as store | redirect with flash | Update post. |
| DELETE | `/admin/post/{id}` | none | redirect with flash | Delete post. |

##### Order, shipping, coupon, message, review

| Method | Path | Request schema | Response schema | Description |
|---|---|---|---|---|
| GET | `/admin/order` | none | HTML index | List orders. |
| GET | `/admin/order/create` | none | no implementation | Route exists from resource. |
| POST | `/admin/order` | same payload as `/cart/order` if called directly | creates order + payment flow | Resource create endpoint exists but real user flow uses `/cart/order`. |
| GET | `/admin/order/{id}` | none | HTML show view | Order detail. |
| GET | `/admin/order/{id}/edit` | none | HTML edit form | Edit order status. |
| PUT/PATCH | `/admin/order/{id}` | `status:'new'|'process'|'delivered'|'cancel'` | redirect with flash | Update order status; on `delivered`, decrements stock for each cart item. |
| DELETE | `/admin/order/{id}` | none | redirect with flash | Delete order. |
| GET | `/admin/shipping` | none | HTML index | List shipping methods. |
| GET | `/admin/shipping/create` | none | HTML create form | Create form. |
| POST | `/admin/shipping` | `type:string|required`, `price:numeric|nullable`, `status:'active'|'inactive'` | redirect with flash | Store shipping method. |
| GET | `/admin/shipping/{id}` | none | empty implementation | Show exists but no implementation. |
| GET | `/admin/shipping/{id}/edit` | none | HTML edit form | Edit shipping. |
| PUT/PATCH | `/admin/shipping/{id}` | same as store | redirect with flash | Update shipping. |
| DELETE | `/admin/shipping/{id}` | none | redirect with flash | Delete shipping. |
| GET | `/admin/coupon` | none | HTML index | List coupons. |
| GET | `/admin/coupon/create` | none | HTML create form | Create form. |
| POST | `/admin/coupon` | `code:string|required`, `type:'fixed'|'percent'`, `value:numeric|required`, `status:'active'|'inactive'` | redirect with flash | Store coupon. |
| GET | `/admin/coupon/{id}` | none | empty implementation | Show exists but no implementation. |
| GET | `/admin/coupon/{id}/edit` | none | HTML edit form | Edit coupon. |
| PUT/PATCH | `/admin/coupon/{id}` | same as store | redirect with flash | Update coupon. |
| DELETE | `/admin/coupon/{id}` | none | redirect with flash | Delete coupon. |
| GET | `/admin/message` | none | HTML index | See messages section above. |
| GET | `/admin/message/create` | none | empty implementation | Exists from resource. |
| POST | `/admin/message` | same as `/contact/message` payload | no normal response | Resource create via public contact flow. |
| GET | `/admin/message/{id}` | none | HTML detail | Show message. |
| GET | `/admin/message/{id}/edit` | none | empty implementation | Exists from resource. |
| PUT/PATCH | `/admin/message/{id}` | none | empty implementation | Exists from resource. |
| DELETE | `/admin/message/{id}` | none | redirect with flash | Delete message. |

#### Notifications

| Method | Path | Request schema | Response schema | Description |
|---|---|---|---|---|
| GET | `/admin/notifications` | none | HTML notification index | List notifications page. |
| GET | `/admin/notification/{id}` | path `id:uuid` | redirect to URL inside notification data | Marks notification read and redirects. |
| DELETE | `/admin/notification/{id}` | path `id:uuid` | redirect back with flash | Delete notification. |

### 3.9 User dashboard/account area

All routes below are inside `/user` prefix and guarded by custom `user` middleware unless otherwise noted.

| Method | Path | Request schema | Response schema | Errors | Description |
|---|---|---|---|---|---|
| GET | `/user/` | none | HTML `user.index-front` when role=`user`, else `user.index` | custom middleware redirect to login | User dashboard. |
| GET | `/user/profile` | none | HTML profile page | auth redirect | User profile. |
| POST | `/user/profile/{id}` | arbitrary user fields; no explicit validation | redirect back with flash | invalid ID -> 404 | Update user profile. |
| GET | `/user/order` | none | HTML order index | auth redirect | List current user orders. |
| GET | `/user/order/show/{id}` | none | HTML order detail | auth redirect | View specific order. |
| DELETE | `/user/order/delete/{id}` | none | redirect with flash | cannot delete status `process`, `delivered`, `cancel` | Delete own order if still in allowed state. |
| GET | `/user/user-review` | none | HTML review index | auth redirect | List current user product reviews. |
| GET | `/user/user-review/edit/{id}` | none | HTML edit form | auth redirect | Edit review page. |
| PATCH | `/user/user-review/update/{id}` | arbitrary review fields | redirect to review index with flash | review not found | Update own review. |
| DELETE | `/user/user-review/delete/{id}` | none | redirect to review index with flash | none explicit | Delete own review. |
| GET | `/user/user-post/comment` | none | HTML comment index | auth redirect | List own comments. |
| GET | `/user/user-post/comment/edit/{id}` | none | HTML edit form | auth redirect | Edit own comment. |
| PATCH | `/user/user-post/comment/udpate/{id}` | arbitrary comment fields | redirect to comment index with flash | comment not found | Update own comment. |
| DELETE | `/user/user-post/comment/delete/{id}` | none | redirect back with flash | comment not found | Delete own comment. |
| GET | `/user/change-password` | none | HTML password form | auth redirect | User password form. |
| POST | `/user/change-password` | `current_password:required|MatchOldPassword`, `new_password:required`, `new_confirm_password:same:new_password` | redirect to `/user` with flash | validation errors | Change user password. |

### 3.10 Miscellaneous and framework-generated routes

| Method | Path | Notes |
|---|---|---|
| `Auth::routes(['register' => false])` | Laravel auth scaffolding routes are added implicitly. Because `php artisan route:list` failed in this environment due a bootstrap/runtime issue (`Undefined constant CURLOPT_SSL_VERIFYHOST` while loading config), these routes are not enumerated here beyond the explicit password-reset routes already visible in `routes/web.php`. |
| `/laravel-filemanager/*` | All file manager routes are mounted under auth-protected prefix via `Lfm::routes()`. Exact subroutes are package-defined, not expanded in repo code. |

## 4. Data Models

### 4.1 Schema-source note

There are **three different schema signals** in this repo:

1. Laravel migrations
2. `database/e-shop.sql` dump
3. additional columns referenced in application code but not present in either of the above

Where a field is only referenced in code and its DB type is not declared in migrations or SQL dump, the type is marked **`unknown (code-referenced only)`**.

### 4.2 Core entities

#### users

| Field | Type | Constraints / notes |
|---|---|---|
| id | bigint unsigned / id | primary key |
| name | string | required |
| email | string | unique in migration; nullable in migration; used as login identifier |
| email_verified_at | timestamp nullable | Laravel standard |
| password | string nullable | hidden |
| photo | string nullable | |
| role | enum | migration allows `admin`,`user`; default `user` |
| provider | string nullable | social login provider |
| provider_id | string nullable | social login provider user id |
| status | enum | `active`,`inactive`; default `active` |
| remember_token | string nullable | Laravel standard |
| created_at | timestamp nullable | |
| updated_at | timestamp nullable | |
| phone | unknown (code-referenced only) | present in `User::$fillable`; used in profile/order contexts |
| address | unknown (code-referenced only) | present in `User::$fillable` |
| city | unknown (code-referenced only) | present in `User::$fillable` |
| post_code | unknown (code-referenced only) | present in `User::$fillable` |
| state | unknown (code-referenced only) | present in `User::$fillable` |
| country | unknown (code-referenced only) | present in `User::$fillable` |
| points | unknown (code-referenced only) | incremented/decremented during points purchase/redeem |

Relationships: `users hasMany orders`

#### banners

| Field | Type | Constraints / notes |
|---|---|---|
| id | bigint unsigned | primary key |
| title | string | required |
| slug | string | unique |
| photo | string nullable | |
| description | text nullable | |
| status | enum | `active`,`inactive`; default `inactive` |
| created_at | timestamp nullable | |
| updated_at | timestamp nullable | |

#### brands

| Field | Type | Constraints / notes |
|---|---|---|
| id | bigint unsigned | primary key |
| title | string | required |
| slug | string | unique |
| status | enum | `active`,`inactive`; default `active` |
| created_at | timestamp nullable | |
| updated_at | timestamp nullable | |

Relationships: `brand hasMany products`

#### categories

| Field | Type | Constraints / notes |
|---|---|---|
| id | bigint unsigned | primary key |
| title | string | required |
| slug | string | unique |
| summary | text nullable | |
| photo | string nullable | |
| is_parent | boolean | default `1` in migration; controller often sets `0` if checkbox absent |
| parent_id | unsignedBigInteger nullable | FK to `categories.id`, on delete set null |
| added_by | unsignedBigInteger nullable | FK to `users.id`, on delete set null |
| status | enum | `active`,`inactive`; default `inactive` |
| created_at | timestamp nullable | |
| updated_at | timestamp nullable | |
| title_jp | unknown (code-referenced only) | used for locale-specific category display |
| summary_jp | unknown (code-referenced only) | used for locale-specific category display |
| catgenres | unknown (code-referenced only) | in `$fillable` only |

Relationships: self parent/children; `category hasMany products by cat_id`; `category hasMany sub_products by child_cat_id`

#### products

| Field | Type | Constraints / notes |
|---|---|---|
| id | bigint unsigned | primary key |
| title | string | required |
| slug | string | unique |
| summary | text | required in migration |
| description | longText nullable | |
| photo | text / string | required |
| stock | integer | default `1` |
| size | string nullable | migration default `M`; controller stores comma-separated values from `size[]` |
| condition | enum | migration: `default`,`new`,`hot`; default `default` |
| status | enum | `active`,`inactive`; default `inactive` |
| price | float | required |
| discount | float nullable | migration typo suggests intended nullable |
| is_featured | boolean | intended default false; controller stores `0`/`1` |
| cat_id | unsignedBigInteger nullable | FK to categories |
| child_cat_id | unsignedBigInteger nullable | FK to categories |
| brand_id | unsignedBigInteger nullable | FK to brands |
| created_at | timestamp nullable | |
| updated_at | timestamp nullable | |
| title_jp | unknown (code-referenced only) | Japanese localized title |
| summary_jp | unknown (code-referenced only) | Japanese localized summary |
| description_jp | unknown (code-referenced only) | Japanese localized description |
| extra_description | unknown (code-referenced only) | referenced in model/selects |
| extra_description_jp | unknown (code-referenced only) | localized extra description |
| price_jp | unknown (code-referenced only) | JPY price |
| price_hk | unknown (code-referenced only) | HKD price |
| duration | unknown (code-referenced only) | used in product detail / email contexts |
| skill_level | unknown (code-referenced only) | product detail |
| skill_level_jp | unknown (code-referenced only) | product detail |
| lectures | unknown (code-referenced only) | product detail |
| language | unknown (code-referenced only) | product detail |
| language_jp | unknown (code-referenced only) | product detail |
| genres | unknown (code-referenced only) | product detail and random product helpers |

Relationships: belongs to category/brand; hasMany reviews; hasMany carts; hasMany wishlists

#### carts

| Field | Type | Constraints / notes |
|---|---|---|
| id | bigint unsigned | primary key |
| product_id | unsignedBigInteger | FK to products in migration; code also uses synthetic product `1000` for points purchase |
| order_id | unsignedBigInteger nullable | FK to orders, on delete set null |
| user_id | unsignedBigInteger nullable | FK to users in migration; for guests the code stores a random session integer here |
| price | float | current-currency/base price |
| status | enum in migration | migration values `new`,`progress`,`delivered`,`cancel`; code also writes `Redeemed` |
| quantity | integer | required |
| amount | float | line amount |
| created_at | timestamp nullable | |
| updated_at | timestamp nullable | |
| currency | unknown (code-referenced only) | set in `addToCart` |
| price_jp | unknown (code-referenced only) | alternate currency amount |
| price_hk | unknown (code-referenced only) | alternate currency amount |
| amount_jp | unknown (code-referenced only) | alternate currency amount |
| amount_hk | unknown (code-referenced only) | alternate currency amount |
| hours | unknown (code-referenced only) | optional training add-on hours |
| points | unknown (code-referenced only) | points granted by product `1000` or used for redeem logic |

Relationships: belongsTo product; belongsTo order

#### wishlists
n
| Field | Type | Constraints / notes |
|---|---|---|
| id | bigint unsigned | primary key |
| product_id | unsignedBigInteger | FK to products |
| cart_id | unsignedBigInteger nullable | FK to carts |
| user_id | unsignedBigInteger nullable | FK to users |
| price | float | |
| quantity | integer | |
| amount | float | |
| created_at | timestamp nullable | |
| updated_at | timestamp nullable | |
| amount_jp | unknown (code-referenced only) | helper expects it |
| amount_hk | unknown (code-referenced only) | helper expects it |

Relationships: belongsTo product

#### orders

| Field | Type | Constraints / notes |
|---|---|---|
| id | bigint unsigned | primary key |
| order_number | string | unique |
| user_id | unsignedBigInteger nullable | FK to users |
| sub_total | float | |
| shipping_id | unsignedBigInteger nullable | FK to shippings |
| coupon | float nullable | stored coupon amount |
| total_amount | float | |
| quantity | integer | |
| payment_method | enum in migration | migration `cod`,`paypal`; code writes `credit_card` also |
| payment_status | enum in migration | migration `paid`,`unpaid`; code writes `Pending`,`Completed`,`Failed` |
| status | enum in migration | migration `new`,`process`,`delivered`,`cancel`; code also writes `New`,`Completed`,`Payment Failed` |
| first_name | string | required |
| last_name | string | required in migration, but controller validation only says string |
| email | string | required |
| phone | string | required |
| country | string | required |
| post_code | string nullable | required by controller |
| address1 | text | required |
| address2 | text nullable | |
| created_at | timestamp nullable | |
| updated_at | timestamp nullable | |
| currency | unknown (code-referenced only) | session currency at checkout |
| trans_id | unknown (code-referenced only) | payment transaction id |
| sub_total_jp | unknown (code-referenced only) | alternate currency subtotal |
| sub_total_hk | unknown (code-referenced only) | alternate currency subtotal |
| total_amount_jp | unknown (code-referenced only) | alternate currency total |
| total_amount_hk | unknown (code-referenced only) | alternate currency total |
| city | unknown (code-referenced only) | validated and passed through request; not in migration/sql dump |
| state | unknown (code-referenced only) | validated and passed through request; not in migration/sql dump |

Relationships: belongsTo user; belongsTo shipping; hasMany carts/cart_info

#### shippings

| Field | Type | Constraints / notes |
|---|---|---|
| id | bigint unsigned | primary key |
| type | string | required |
| price | float nullable | |
| status | enum | `active`,`inactive` |
| created_at | timestamp nullable | |
| updated_at | timestamp nullable | |

#### coupons

| Field | Type | Constraints / notes |
|---|---|---|
| id | bigint unsigned | primary key |
| code | string | unique |
| type | enum | `fixed`,`percent` |
| value | decimal(20,2) | required |
| status | enum | `active`,`inactive` |
| created_at | timestamp nullable | |
| updated_at | timestamp nullable | |

#### posts

| Field | Type | Constraints / notes |
|---|---|---|
| id | bigint unsigned | primary key |
| title | string | required |
| slug | string | unique |
| summary | text | required |
| description | longText nullable | |
| quote | text nullable | |
| photo | string nullable | |
| tags | string/text nullable | controller stores comma-separated tag ids/values |
| post_cat_id | unsignedBigInteger nullable | FK to post_categories |
| post_tag_id | unsignedBigInteger nullable | FK to post_tags |
| added_by | unsignedBigInteger nullable | FK to users |
| status | enum | `active`,`inactive` |
| created_at | timestamp nullable | |
| updated_at | timestamp nullable | |

Relationships: belongs to author/category/tag; hasMany comments/allComments

#### post_categories

| Field | Type | Constraints / notes |
|---|---|---|
| id | bigint unsigned | primary key |
| title | string | required |
| slug | string | unique |
| status | enum | `active`,`inactive` |
| created_at | timestamp nullable | |
| updated_at | timestamp nullable | |

#### post_tags

| Field | Type | Constraints / notes |
|---|---|---|
| id | bigint unsigned | primary key |
| title | string | required |
| slug | string | unique |
| status | enum | `active`,`inactive` |
| created_at | timestamp nullable | |
| updated_at | timestamp nullable | |

#### post_comments

| Field | Type | Constraints / notes |
|---|---|---|
| id | bigint unsigned | primary key |
| user_id | unsignedBigInteger nullable | FK to users |
| post_id | unsignedBigInteger nullable | FK to posts |
| comment | text | required |
| status | enum | `active`,`inactive` |
| replied_comment | text nullable | |
| parent_id | unsignedBigInteger nullable | self-reference used for replies |
| created_at | timestamp nullable | |
| updated_at | timestamp nullable | |

Relationships: belongsTo post; hasMany replies; hasOne user_info

#### product_reviews

| Field | Type | Constraints / notes |
|---|---|---|
| id | bigint unsigned | primary key |
| user_id | unsignedBigInteger nullable | FK to users |
| product_id | unsignedBigInteger nullable | FK to products |
| rate | tinyInteger | default `0` |
| review | text nullable | |
| status | enum | `active`,`inactive` |
| created_at | timestamp nullable | |
| updated_at | timestamp nullable | |
| name | unknown (code-referenced only) | in model `$fillable`, set in controller |
| email | unknown (code-referenced only) | in model `$fillable`, set in controller |

#### messages

| Field | Type | Constraints / notes |
|---|---|---|
| id | bigint unsigned | primary key |
| name | varchar(191) | required |
| subject | text | required |
| email | varchar(191) | required |
| photo | varchar(191) nullable | |
| phone | varchar(191) nullable | |
| message | longText | required |
| read_at | timestamp nullable | |
| created_at | timestamp nullable | |
| updated_at | timestamp nullable | |

#### notifications

| Field | Type | Constraints / notes |
|---|---|---|
| id | uuid | primary key |
| type | string | notification class |
| notifiable_type | string | morph type |
| notifiable_id | bigint/unsigned morph id | morph id |
| data | text | serialized notification payload |
| read_at | timestamp nullable | |
| created_at | timestamp nullable | |
| updated_at | timestamp nullable | |

#### settings

| Field | Type | Constraints / notes |
|---|---|---|
| id | bigint unsigned | primary key |
| description | longText | required |
| short_des | text | required |
| logo | string | required |
| photo | string | required |
| address | string | required |
| phone | string | required |
| email | string | required |
| created_at | timestamp nullable | |
| updated_at | timestamp nullable | |

### 4.3 Auxiliary / framework tables

- `password_resets(email, token, created_at)`
- `failed_jobs(id, connection, queue, payload, exception, failed_at)`
- `jobs(id, queue, payload, attempts, reserved_at, available_at, created_at)`
- `migrations(id, migration, batch)`

### 4.4 Code-referenced models without migration/sql schema in repo

#### pages

Code-defined fillable fields:

| Field | Type |
|---|---|
| page_title | unknown |
| page_title_ja | unknown |
| page_slug | unknown |
| page_desc | unknown |
| page_desc_ja | unknown |
| page_meta | unknown |
| page_keywords | unknown |

#### instructors

Code-defined fillable fields:

| Field | Type |
|---|---|
| id | unknown |
| instructor_name | unknown |
| instructor_name_ja | unknown |
| instructor_slug | unknown |
| instructor_pic | unknown |
| instructor_designation | unknown |
| instructor_designation_ja | unknown |
| instructor_desc | unknown |
| instructor_desc_ja | unknown |
| status | unknown; code expects active value `A` |

## 5. Authentication & Authorization Flow

### Login flow

1. User submits `POST /user/login` with `email` and `password`.
2. Backend authenticates with `Auth::attempt(['email' => ..., 'password' => ..., 'status' => 'active'])`.
3. On success:
   - `Session::put('user', $email)` is set.
   - if a guest cart exists under `session('guest')`, all cart rows whose `user_id` equals that guest integer are reassigned to the authenticated user ID, `session('guest')` is cleared, and the user is redirected to `/checkout`.
   - otherwise the user is redirected to `/`.
4. On failure, backend redirects back with flash error `invalid_email_password`.

### Registration flow

1. User submits `POST /user/register` with `name`, `email`, `password`, `password_confirmation`, `captcha`.
2. Validation rules:
   - `name`: letters and spaces only, max 40
   - `email`: unique in `users.email`
   - `password`: min 6 and confirmed
   - `captcha`: required and valid
3. Additional business rule: if there have been **2 or more user rows created in the last 24 hours**, registration is blocked with generic try-again error.
4. Successful create stores user with hashed password and `status='active'`.
5. Controller sets `Session::put('user', email)` but then redirects to login page; it does **not** call `Auth::login`.

### Logout flow

- `GET /user/logout`
- Clears `session('user')`
- Calls `Auth::logout()`
- Redirects home with success flash

### Password reset flow

- Password reset uses Laravel scaffolding plus explicit routes in `web.php`.
- Visible endpoints:
  - `GET /user/forgetpassword`
  - `GET /password/reset`
  - `POST /password/email`
  - `GET /password/reset/{token}`
  - `POST /password/reset`
- Payload shape for reset completion follows Laravel defaults: `token`, `email`, `password`, `password_confirmation`.

### Session management

- Session driver is env-configured via `SESSION_DRIVER`.
- Custom app state stored in session:
  - `user` → user email, used by custom `user` middleware
  - `guest` → random integer used as pseudo-user id for guest cart rows
  - `currency` → one of `USD`, `HKD`, `JPY`
  - `app_locale` → `en` or `ja`
  - `coupon` → `{ id, code, value }`
  - payment transaction dedupe key where key name equals transaction id to prevent repeated points crediting

### Authorization

| Mechanism | Behavior |
|---|---|
| `auth` middleware | standard Laravel auth check; redirects to route `login.form` when request does not expect JSON |
| `admin` middleware | requires authenticated user `role == 'admin'`; otherwise flashes error and redirects to route named by current user role |
| `user` middleware | **custom**: only checks whether `session('user')` is non-empty, otherwise redirects to `login.form` |

### Role-based access

- `users.role` enum in migration: `admin`, `user`
- Admin area is under `/admin` with `auth` + `admin`
- User dashboard area is under `/user` with custom `user` middleware
- `FrontendController@index` redirects to route named by authenticated user role (`admin` or `user`)

### Token refresh / JWT / OAuth API tokens

- No refresh-token flow was found.
- No JWT implementation was found.
- Sanctum package is installed but not used in visible code paths.
- Social login exists through Socialite provider redirects/callbacks.

## 6. Business Logic & Rules

### Cart composition rules

1. **Points purchase line item is synthetic product `1000`.**
2. A cart cannot mix points purchase and game/service product lines:
   - if current cart already contains product `1000`, adding a normal product (`id < 1000`) is blocked
   - if current cart already contains a normal product, adding points is blocked
3. In checkout, if cart contains product `1000`, the controller deletes any open cart rows whose `product_id < 1000` and renders the points checkout view.

### Guest cart behavior

- If a guest adds a product and `session('guest')` is absent, the app creates a random integer between `100000` and `999999` and stores it in session.
- That integer is persisted into `carts.user_id` for guest rows.
- On successful login, guest cart rows are reassigned to real user ID.

### Product add rules

- `singleAddToCart` expects quantity in `quant[1]`, not a scalar `quant`.
- If `hours > 0`, line price is increased by `20 * hours` in all three currency fields.
- Duplicate product add in `singleAddToCart` short-circuits with `product_already_in_cart` error; the code below that return is dead/unreachable.
- Stock validation blocks adds when requested qty exceeds product stock.

### Points purchase rules

The points purchase flow uses special price-to-points ladders.

#### USD ladder

Based on accumulated USD price in the points cart row:

- `1 < price < 601` → points = price
- `601 < price < 2001` → points = round(price * 1.5)
- `2000 < price < 3201` → points = round(price * 2)
- `price > 3200` → points = round(price * 5)

#### JPY ladder

Backend converts JPY request price to base USD-ish `price = request.price / 160`, stores `price_jp = request.price`, and then derives points from accumulated `price_jp`:

- `1 < price_jp < 100001` → points = `price_jp / 160`
- `100000 < price_jp < 300001` → points = round(base * 1.5)
- `300000 < price_jp < 500001` → points = round(base * 2)
- `price_jp > 500000` → points = round(base * 5)

#### HKD ladder

Backend converts `price = request.price / 8`, stores `price_hk = request.price`, then derives points from accumulated HKD amount:

- `1 < price_hk < 5001` → points = `price_hk / 8`
- `5000 < price_hk < 15001` → points = round(base * 1.5)
- `15000 < price_hk < 25001` → points = round(base * 2)
- `price_hk > 25000` → points = round(base * 5)

### Currency and locale behavior

- Supported locales: `en`, `ja`
- Supported currencies: `USD`, `HKD`, `JPY`
- Product/category/page/instructor queries select translated fields when locale is `ja`.
- Helper totals sum `amount`, `amount_jp`, or `amount_hk` depending on session currency.
- Currency symbols are derived from helper/model maps:
  - USD → `$`
  - JPY → `¥`
  - HKD → `HK$`

### Coupon rules

- Coupon stored in session as computed discount amount, not only as code.
- `Coupon::discount(total)` logic:
  - `fixed` → returns raw `value`
  - `percent` → returns `(value / 100) * total`
- Coupon application uses authenticated user’s open cart only.

### Order creation and payment rules

- Cart must not be empty.
- Required billing/shipping fields are validated.
- `country` cannot be `0` or empty string.
- `captcha` is required on checkout submit.
- Controller always sets:
  - `order_number = 'ORD-' + random 10-char uppercase string`
  - `status = 'New'`
  - `payment_method = 'credit_card'`
  - `payment_status = 'Pending'`
- Card payment fields are **read directly from request** and not included in validation except `cvv` empty-check.
- After order save, all current open cart rows are assigned the new `order_id` before payment gateway redirect.

### Payment finalization rules

- `/cart/payment` is the decisive callback/finalization endpoint.
- If payment status lookup returns success:
  - order `payment_status` becomes `Completed`
  - order `status` becomes `Completed`
  - order `trans_id` set from query
  - confirmation email is attempted
  - if first cart row `product_id == 1000`, current user’s `points` balance is incremented once by cart `points`
  - duplicate points credit is prevented by storing a session key equal to the transaction id
- If failure/forbidden/missing transaction id:
  - order `payment_status = Failed`
  - order `status = Payment Failed`

### Redeem rules

- `GET /pointsredeem` checks first open cart row’s `price` against current user’s `points` balance.
- If insufficient balance, request fails.
- On success:
  - decrements `users.points` by cart price
  - sets cart `order_id` to a random 6-digit number
  - sets cart `status` to `Redeemed`
  - sends redeem confirmation email

### Admin order status update rules

- Valid admin-updatable statuses: `new`, `process`, `delivered`, `cancel`
- If admin sets order status to `delivered`, the code decrements each related product’s stock by cart quantity.

### Registration anti-abuse rule

- Registration blocked when `User::where('created_at', '>=', now()->subHours(24))->count() >= 2`.
- There is no per-IP logic; it is global user-row count over last 24 hours.

### Notification behavior

- Product review creation notifies admins with `database` and `broadcast` channels.
- Order creation builds a `details` payload for notification, though the visible `Notification::send` call is present in reviews and not clearly executed for orders in current code.

### Validation/implementation mismatches to preserve or clarify

- `users` migration enum for role is `admin|user`, but login redirect assumes route names equal to role strings.
- `orders` migration enums do not match values written by code (`credit_card`, `Pending`, `Completed`, `Failed`, `New`, `Payment Failed`).
- `carts.status` migration enum does not include `Redeemed`, but controller writes it.
- Product update validates only `title`, even though create validates additional fields.
- `MessageController@store` ends with `exit()` and does not return a normal response.

## 7. Existing Pages & Routes

### 7.1 Public-facing pages

| Route | Current page/view | Purpose | Backend endpoints involved | Key UI states to preserve |
|---|---|---|---|---|
| `/` | `frontend.index` | Home page with hero, banners, categories, featured products, latest posts, points-purchase form | GET `/`; POST `/points-add-to-cart`; currency/language switch links | initial load, success/error flash, points calculation before submit, authenticated vs guest CTAs |
| `/about-us` | `frontend.pages.about-us` | Static about page | GET `/about-us` | normal content state |
| `/faqs` | `frontend.pages.faqs` | FAQ page | GET `/faqs` | normal content state |
| `/contact` | `frontend.pages.contact` | Contact form page | GET `/contact`; POST `/contact` (or legacy `/contact/message` if retained) | form idle, validation errors, captcha error, success flash |
| `/product-grids` | `frontend.pages.product-grids` | Product catalog grid | GET `/product-grids`; GET/POST `/filter`; POST `/product/search`; GET `/product-cat/{slug}` etc. | loading, pagination, empty result set, filter-applied state, search state |
| `/product-lists` | `frontend.pages.product-lists` | Product catalog list | same as grid route set | loading, pagination, empty result set |
| `/product-detail/{slug}` | `frontend.pages.product_detail` | Product detail, review form, add-to-cart | GET product detail; POST `/add-to-cart`; POST `/product/{slug}/review`; GET `/wishlist/{slug}` | loading, out-of-stock, add success/error, review validation, related products |
| `/cart` | `frontend.pages.cart` | Generic cart page | GET `/cart`; POST `/cart-update`; GET `/cart-delete/{id}`; POST `/coupon-store` | empty cart, cart lines, quantity update, coupon success/error |
| `/gamecart` | `frontend.pages.gamecart` | Game/service cart page for non-points products | GET `/gamecart`; POST `/add-to-cart`; GET `/trainingdelete/{id}`; GET `/pointsredeem` | empty cart, add-on hours, remove training, insufficient points, redeem success |
| `/checkout` | `frontend.pages.checkout` or `frontend.pages.gamecart` | Points/credit checkout or gamecart fallback | GET `/checkout`; POST `/cart/order` | empty cart redirect, billing form validation, captcha, payment processing redirect |
| `/wishlist` | `frontend.pages.wishlist` | Wishlist page | GET `/wishlist`; GET `/wishlist/{slug}`; GET `/wishlist-delete/{id}`; GET `/add-to-cart/{slug}` | empty wishlist, add/remove success/error |
| `/blog` | `frontend.pages.blog` | Blog list page | GET `/blog`; GET `/blog/search`; POST `/blog/filter`; GET `/blog-cat/{slug}`; GET `/blog-tag/{slug}` | list, empty state, search state |
| `/blog-detail/{slug}` | `frontend.pages.blog-detail` | Blog article + comment form | GET `/blog-detail/{slug}`; POST `/post/{slug}/comment`; POST `/subscribe` | article load, login-required comment CTA, comment success/error |
| `/product/track` | `frontend.pages.order-track` | Order tracking page | GET `/product/track`; POST `/product/track/order` | form idle, success flash, invalid order flash |
| `/user/login` | `frontend.pages.login` | Login page | GET/POST `/user/login` | validation errors, login failure, redirect after login |
| `/user/register` | `frontend.pages.register` | Signup page | GET/POST `/user/register`; POST `/check-email` | email-availability feedback, captcha error, registration throttling flash |
| `/user/forgetpassword` | `frontend.pages.forget-pwd-form` (expected) | Password reset request | GET `/user/forgetpassword`; POST `/password/email` | validation, email-sent state |
| `/pages/{slug}` and `/{slug}` | `frontend.pages.page` | CMS content pages | GET `/pages/{slug}` or catch-all GET `/{slug}` | page found/not-found handling |
| `/database` | `frontend.pages.database` | Static page | GET `/database` | normal content state |
| `/order-success` / `/order-failed` conceptual states | `frontend.pages.order-success`, `frontend.pages.order-failed` | Payment result pages rendered by controller, not directly routed by these URIs | GET `/cart/payment`, GET `/payment/failed` | success, failure, missing transaction data |
| `/instructor` | expected `frontend.pages.instructor` | Instructor list | GET `/instructor` | **view missing in repo** |
| `/instructor/{slug}` | expected `frontend.pages.instructor-detail` | Instructor detail | GET `/instructor/{slug}` | **view missing in repo** |

### 7.2 User account pages

| Route | Current page/view | Purpose | Backend endpoints involved | Key UI states |
|---|---|---|---|---|
| `/user` | `user.index-front` or `user.index` | Dashboard | GET `/user` | logged-in landing |
| `/user/profile` | `user.users.profile` | Edit profile | GET/POST `/user/profile/{id}` | form state, success/error |
| `/user/order` | `user.order.index` | List own orders | GET `/user/order`; DELETE `/user/order/delete/{id}` | loading, empty state, delete-not-allowed state |
| `/user/order/show/{id}` | `user.order.show` | View order detail | GET `/user/order/show/{id}` | detail state |
| `/user/user-review` | `user.review.index` | List own product reviews | GET `/user/user-review`; DELETE review | loading, empty |
| `/user/user-review/edit/{id}` | `user.review.edit` | Edit own review | GET/PATCH review routes | edit success/error |
| `/user/user-post/comment` | `user.comment.index` | List own comments | GET `/user/user-post/comment` | loading, empty |
| `/user/user-post/comment/edit/{id}` | `user.comment.edit` | Edit own comment | GET/PATCH comment routes | edit success/error |
| `/user/change-password` | `user.layouts.userPasswordChange` | Change password | GET/POST `/user/change-password` | validation, success |

### 7.3 Admin pages

Admin Blade views exist for dashboard, users, banners, brands, categories, products, posts, post categories, post tags, orders, shipping, coupons, reviews, notifications, settings, file manager, and messages. Each maps directly to the `/admin/...` routes documented above and follows standard Laravel server-rendered patterns: index table, create form, edit form, delete action, and flash-based success/error handling.

## 8. Environment Variables & Configuration

### 8.1 Frontend-relevant env/config keys

The frontend rebuild needs awareness of the following backend-facing configuration concepts.

| Variable / config | Purpose |
|---|---|
| `APP_URL` | Base application URL |
| `WEBSITE_URL` | Used to build payment return URLs |
| `MIX_PUSHER_APP_KEY` | Exposed to frontend JS for Echo/Pusher |
| `MIX_PUSHER_APP_CLUSTER` | Exposed to frontend JS for Echo/Pusher |
| CSRF token meta tag | Required for Axios and standard form submissions |
| session cookie config (`SESSION_*`) | Required if frontend is decoupled and still uses Laravel sessions |

### 8.2 Backend-only but behaviorally important env/config keys

| Variable / config | Purpose |
|---|---|
| `DB_*` | Database connection |
| `PAYMENT_URL` | Card charge/create endpoint |
| `PAYMENT_STATUS_URL` | Card payment-status lookup endpoint |
| `USD_DASMID`, `JPY_DASMID` | Merchant IDs |
| `SECRET_KEY`, `X_API_KEY` | Payment gateway auth headers |
| `MAIL_*` | Email sending |
| `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME` | Contact email and sender identity |
| `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_DEFAULT_REGION`, `AWS_BUCKET`, `AWS_URL` | AWS/S3 integrations |
| `PUSHER_APP_ID`, `PUSHER_APP_KEY`, `PUSHER_APP_SECRET`, `PUSHER_APP_CLUSTER` | Realtime broadcasting |
| `BROADCAST_DRIVER` | Broadcast transport |
| `CACHE_DRIVER`, `QUEUE_CONNECTION`, `REDIS_*` | Async/cache runtime behavior |
| `FILESYSTEM_*` | Storage behavior |
| `PAYPAL_*` | PayPal integration |
| `MAILCHIMP_*` | Newsletter integration |

### 8.3 Middleware/config behavior the frontend must know

- Web routes are in the `web` middleware group with:
  - cookies
  - session start
  - shared errors
  - CSRF verification
  - language middleware
  - currency middleware
- If `session('currency')` is absent, `CurrencyMiddleware` initializes it to `USD`.
- `Authenticate` middleware redirects unauthenticated web requests to `route('login.form')`.

## 9. Known Constraints or Gotchas

1. **This is session/cookie auth, not token auth.** A SPA or external frontend must send cookies and CSRF headers correctly.
2. **Custom `user` middleware only checks `session('user')`, not `Auth::check()`.** Do not assume it behaves like normal Laravel auth.
3. **Catch-all route `GET /{slug}` is last and will swallow unmatched frontend routes.** Any new frontend route not backed by Laravel may conflict unless handled carefully.
4. **Synthetic cart product `1000` is hardcoded** for points purchases.
5. **Guest carts persist in DB using a random integer stored in `carts.user_id`.** This is unusual and must be preserved if backend stays unchanged.
6. **Resource routes exist even where controller methods are empty.** Do not rely on unsupported resource actions unless you confirm they are unused.
7. **Schema drift exists.** Code references many columns not present in migrations or SQL dump (`points`, `price_jp`, `title_jp`, etc.). Frontend should trust controller payloads, not schema assumptions.
8. **Enum drift exists.** Code writes order/cart/payment statuses that do not match migration enums.
9. **`MessageController@store` terminates with `exit()`** and does not return a normal redirect/JSON response.
10. **`/admin/category/{id}/child` route path includes `{id}`, but controller ignores route param and reads `$request->id`.** Submit both route segment and request field if you preserve current AJAX contract.
11. **Payment/card fields are not fully validated server-side.** Frontend should perform stronger client validation if desired, but must still send exact field names expected by controller.
12. **Some controller code is dead or inconsistent** (for example unreachable statements after `return`, duplicate password reset routes, ambiguous PayPal vs DAS success route names).
13. **Realtime frontend JS expects `baseURL+'/broadcasting/auth'` but `baseURL` is not defined in `resources/js/bootstrap.js`.** Existing realtime setup may depend on global script elsewhere.
14. **Broadcast channel `message` returns `true` for all listeners.** There is no auth gate on that channel definition.
15. **Instructor pages are wired in controller/routes but corresponding Blade views are missing from repo.**
16. **`php artisan route:list` could not be executed in this environment** because app bootstrap hit `Undefined constant CURLOPT_SSL_VERIFYHOST` from `config/broadcasting.php`; therefore package-generated and implicit framework routes could not be machine-verified here.
17. **Order PDF route has no explicit auth middleware.** If kept public, it may expose order downloads by numeric id.
18. **Stock decrement happens only when admin marks an order delivered**, not at checkout time.
19. **Coupon totals and cart totals are currency-sensitive via session.** Do not compute totals client-side as source of truth.
20. **The frontend currently depends on Blade-rendered flash messages and redirect flows.** A decoupled frontend will need explicit handling for redirect responses or a backend adapter layer.

## 10. Open Questions

1. What is the **actual production database schema** for fields referenced in code but missing from migrations/SQL dump, especially:
   - `users.points`, `users.phone`, `users.address`, `users.city`, `users.post_code`, `users.state`, `users.country`
   - `products.title_jp`, `summary_jp`, `description_jp`, `extra_description`, `extra_description_jp`, `price_jp`, `price_hk`, `duration`, `skill_level`, `skill_level_jp`, `lectures`, `language`, `language_jp`, `genres`
   - `categories.title_jp`, `summary_jp`, `catgenres`
   - `carts.currency`, `price_jp`, `price_hk`, `amount_jp`, `amount_hk`, `hours`, `points`
   - `orders.currency`, `trans_id`, `sub_total_jp`, `sub_total_hk`, `total_amount_jp`, `total_amount_hk`, `city`, `state`
   - `wishlists.amount_jp`, `wishlists.amount_hk`
   - `product_reviews.name`, `product_reviews.email`
2. What are the **real DB enum definitions** in production for `orders.status`, `orders.payment_method`, `orders.payment_status`, and `carts.status`, since code writes values outside the migration enums?
3. Are `/instructor` and `/instructor/{slug}` currently live in production, and if so where are the missing view files?
4. Which contact flow is authoritative for the new frontend: `/contact` or legacy `/contact/message`?
5. Should the rebuild preserve server-rendered redirects/flash messages, or is an adapter/API layer acceptable while keeping backend business logic unchanged?
6. Are the implicit `Auth::routes()` endpoints actually used anywhere in production UI besides password reset?
7. Is the payment gateway callback contract documented externally, especially the exact query params appended to `/cart/payment`?
8. Should order PDF download be publicly accessible by id, or should the frontend assume auth/authorization checks will be added later?
9. What is the expected response contract for message/contact AJAX submissions given `MessageController@store` exits without returning JSON or redirect?
10. Is the points program intentionally tied to hardcoded thresholds and synthetic `product_id = 1000`, or can that be externalized/configured later?
11. What is the intended canonical success route for payments (`/cart/payment`, `/payment/success`, or both)?
12. Are there additional package-generated routes from Laravel File Manager or auth scaffolding that the new frontend will directly call?
