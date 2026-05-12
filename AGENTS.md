# AGENTS.md — E-Commerce Brazil

## Project Snapshot

| Item | Value |
|------|-------|
| Framework | Laravel 12 / PHP 8.2 |
| Frontend | Tailwind CSS v4 + Vite 6 |
| Database | SQLite (dev) / MySQL (prod) |
| Auth | Laravel Auth + Google OAuth (Socialite) |
| Default locale | Portuguese (`pt`) |
| Test runner | PHPUnit 11 (`php artisan test`) |

## What This App Does

A multi-brand e-commerce platform for custom products. Customers can configure products with nested options (color, material, size, artwork upload), add to cart, and complete a multi-step checkout. Admins manage products, pricing rules, orders, and content through an admin panel.

Two primary product brands with dedicated show pages:
- `hotstrap` → `ProductController@hotstrap_show` → `products/hotstrap_show.blade.php`
- `hotmobily` → `ProductController@hotmobily_show` → `products/hotmobily_show.blade.php`

## Code Conventions

### Investigation First
- Analyze the full problem, relevant files, data flow, and request context before making code changes.
- Do not guess behavior or implement fixes before understanding the current workflow.
- Trace the route, controller, model, view, request/session data, and related JavaScript when they affect the feature being changed.
- If the behavior is unclear, inspect the code and existing tests first; ask the user only when the answer cannot be discovered safely from the project.
- Keep changes scoped to the understood problem and avoid unrelated refactors.

### PHP / Laravel
- PSR-4 autoloading, `App\` namespace
- Follow existing controller pattern: thin controllers, logic in models or dedicated methods
- Use `php artisan make:*` for scaffolding (models, migrations, controllers)
- Run `./vendor/bin/pint` before committing PHP files
- Migrations: always add reversible `down()` methods

### Blade / Frontend
- Layouts are in `resources/views/layouts/` — extend them, don't duplicate structure
- Use Tailwind utility classes — no custom CSS unless unavoidable
- Assets compiled via Vite: reference with `@vite(['resources/css/app.css', 'resources/js/app.js'])`
- Run `npm run build` to verify no Vite compilation errors before completing frontend tasks

### Localization / i18n
- This site supports three languages: Portuguese (`pt`), Japanese (`ja`), and English (`en`).
- When adding a new page, form, notification, email, navigation item, button label, validation message, or any user-facing text, add translations for all three locales.
- Keep translation keys consistent across `lang/pt/`, `lang/ja/`, and `lang/en/`.
- Do not hardcode user-facing copy in Blade, controllers, mailables, or JavaScript when it should be translated.
- If a feature introduces new validation rules or form errors, make sure the related messages are available in all supported languages.
- Do not edit multilingual copy by guessing. Preserve the intended meaning and ask for clarification if the source text or target language is ambiguous.
- Keep all multilingual files encoded as UTF-8. Do not introduce mojibake or corrupted characters when editing Portuguese, Japanese, or English text.

### Forms & Validation
- Any form that accepts user input must include both frontend and backend validation.
- Frontend validation should provide immediate, user-friendly feedback using native HTML constraints, Blade error displays, and existing JavaScript patterns where appropriate.
- Backend validation is mandatory and must be the source of truth; use Laravel `Request::validate()`, Form Request classes, or existing validation patterns before creating or updating records.
- Keep validation rules consistent between create/update flows, checkout steps, auth-related forms, and admin forms.
- Preserve submitted values with `old()` in Blade forms and show validation errors close to the relevant field.
- Validate file uploads for type, size, and required/optional state before storing them.
- Do not rely on frontend validation alone, especially for pricing, checkout, account, admin, or file-upload workflows.
- Add or update tests for validation behavior when changing high-risk forms or shared request handling.

### Database
- All new tables need a migration; never modify existing migration files
- Soft deletes where data loss would be significant (orders, products)
- Timestamps on all tables

## Critical Domain Knowledge

### Product Option System
Products have `OptionGroups` containing `ProductOptions`. Options can have:
- Dependencies (`OptionDependency`) — show/hide based on parent option selection
- Images (`OptionImage`)
- Variants (`ProductOptionVariant`) — different SKUs per option combination

### Pricing System (Complex)
Three-layered pricing:
1. **Base price** on `Product`
2. **Price tiers** (`ProductPriceTier`) — quantity-based discounts
3. **Price rules** (`ProductPriceRule`) with `ProductPriceRuleOption` and `ProductPriceRuleTier` — option-combination-based pricing overrides

Do not touch pricing without reading all four related models and their migrations first.

### Checkout Flow
Multi-step, stored in session:
1. Artwork upload (`/checkout/artwork`)
2. Address entry (`/checkout/address`)
3. Payment info (`/checkout/payment`)
4. Review (`/checkout/review`)
5. Place order → `Order` + `OrderItems` + `OrderCustomer` + `OrderPayment` + `OrderArtwork` created

## File Locations for Common Tasks

| Task | File |
|------|------|
| Add a public route | `routes/web.php` |
| Add an admin route | `routes/web.php` under `prefix('admin')` group |
| Add a new product field | New migration + `Product` model `$fillable` |
| Modify checkout steps | `app/Http/Controllers/OrderController.php` + `resources/views/checkout/` |
| Change email templates | `resources/views/emails/` |
| Add a language string | `lang/{locale}/` |
| Modify admin product form | `resources/views/admin/products/` |

## Constraints & Risks

- **Admin has no auth guard** — do not add admin features that expose sensitive data without first adding middleware.
- **Pricing rules are deeply relational** — changes cascade through 4+ tables; test thoroughly.
- **Google OAuth** requires `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, `GOOGLE_REDIRECT_URI` in `.env`.
- **reCAPTCHA** keys are in `.env` but integration may be incomplete — verify before enabling on contact/register forms.
- Do not commit `output.json` (untracked debug file in root).

## Testing

```bash
php artisan test                    # Full suite
php artisan test --filter=CartTest  # Single test class
```

Tests live in `tests/Feature/` and `tests/Unit/`. Factories are available for seeding test data. Database tests use SQLite in-memory (check `phpunit.xml`).
