# CLAUDE.md — E-Commerce Brazil

## Project Overview

Multi-brand e-commerce platform built on **Laravel 12 / PHP 8.2** with a complex product customization engine, multi-step checkout, and a full admin panel. Default locale is Portuguese (`pt`). Two main product brands: `hotstrap` and `hotmobily`.

## Essential Commands

```bash
# Development
php artisan serve          # Start Laravel dev server
npm run dev               # Start Vite (CSS/JS HMR)
concurrently "php artisan serve" "npm run dev"  # Both at once

# Database
php artisan migrate
php artisan migrate:fresh --seed

# Code style
./vendor/bin/pint          # Auto-fix PHP code style (Laravel Pint)

# Testing
php artisan test           # Run PHPUnit test suite

# Logs (dev)
php artisan pail           # Live log tail
```

## Architecture

```
app/
  Http/
    Controllers/
      Admin/         ← All admin CRUD controllers
      Auth/          ← Login, register, OAuth, password reset
    Middleware/
      SetLocale.php  ← Language switching middleware
  Models/            ← 26 Eloquent models (see below)
  Mail/              ← ContactFormSubmitted mailable
  Notifications/     ← VerifyEmailCustom

resources/views/
  layouts/           ← Base layouts (public + admin)
  products/          ← Product display (show, hotstrap_show, hotmobily_show)
  admin/             ← Full admin panel views
  checkout/          ← Multi-step checkout views
  auth/              ← Authentication views
```

## Key Models & Relationships

| Domain | Models |
|--------|--------|
| Product | `Product`, `ProductDetail`, `ProductImage`, `ProductOption`, `ProductOptionAssignment`, `ProductOptionVariant` |
| Pricing | `ProductPriceTier`, `ProductPriceRule`, `ProductPriceRuleOption`, `ProductPriceRuleTier` |
| Options | `OptionGroup`, `OptionDependency`, `OptionImage` |
| Orders | `Order`, `OrderItem`, `OrderItemOption`, `OrderCustomer`, `OrderPayment`, `OrderArtwork` |
| Users | `User`, `SocialAccount` |
| Content | `Category`, `Material`, `ProductListBanner`, `ProductArtworkTemplate`, `ContactSubmission` |

## Route Structure

| Prefix | Area |
|--------|------|
| `/` | Public (home, about, contact) |
| `/products` | Product listing and detail pages |
| `/hotstrap/{product}` | Hotstrap brand product page |
| `/hotmobily/{product}` | Hotmobily brand product page |
| `/cart` | Cart management |
| `/checkout` | Multi-step checkout (artwork → address → payment → review → confirm) |
| `/auth/google/*` | Google OAuth (Socialite) |
| `/admin/*` | Admin panel (no auth guard currently — verify before deploying) |

## Frontend Stack

- **CSS:** Tailwind CSS v4 (via `@tailwindcss/vite`)
- **Build:** Vite 6 with `laravel-vite-plugin`
- **HTTP client (JS):** Axios
- **Blade:** Standard Laravel templating (no Livewire/Inertia)

## Important Conventions

- **Base Controller** (`Controller.php`) contains `AllProvince()` — returns all 47 Japanese prefectures as an array. This is used for address forms across the app.
- **Localization:** `APP_LOCALE=pt` is default. Language switching via `/language/{locale}` route handled by `SetLocale` middleware.
- **Auth:** Standard Laravel auth + Google OAuth via Socialite. Email verification is customized (`VerifyEmailCustom` notification).
- **Mail:** MailHog on port 2525 in dev. Configure `MAIL_*` env vars.
- **Database:** SQLite by default in dev. Switch to MySQL for production.
- **Session/Cache/Queue:** All use `database` driver by default.

## Environment Variables to Configure

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=
RECAPTCHA_SITE_KEY=
RECAPTCHA_SECRET_KEY=
```

## Cautions

- The `/admin` routes have **no authentication middleware** in the current route file — confirm before going to production.
- `output.json` in root is untracked and likely a debug artifact — do not commit.
- Product pricing logic is complex (tiers + rules + rule options + rule tiers) — read existing migrations carefully before touching pricing models.
