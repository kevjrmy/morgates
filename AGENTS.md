# Morgates Agent Context

## Project Summary
Morgates is a French Laravel web application for publishing and browsing rental listings. The public side lets visitors discover listings, filter them, view listing details, and contact owners directly. The private side lets owners create an account, complete onboarding, manage their dashboard, and publish listings.

## People And Context
- Loïs is the founder, originated the idea, and will run the product.
- Kevin is the solo developer of the project.
- The project is currently being built as an MVP.
- The project is in development mode, so the database can be refreshed or reset at any time.

## Product Direction
The product should feel like a practical direct-contact rental marketplace for French-speaking users. Morgates is not another booking/reservation platform. Its core purpose is to put visitors and owners in direct contact while shortcutting intermediaries. Keep user-facing copy in French unless a task explicitly asks otherwise. Prioritize clear listing discovery, trustworthy owner profiles, direct contact flows, and a smooth multi-step publishing experience.

## Target Markets
The planned market expansion order is:
1. Brittany, because it is Loïs's home region.
2. France as the national market.
3. Valencia, because Kevin is currently based there.
4. Spain.
5. International English-speaking market.

## Internationalization Direction
The MVP interface is French only. The longer-term vision includes English and Spanish versions, so new architecture and UI work should avoid choices that would make future translation difficult. When practical, keep visible strings easy to move into Laravel translation files later, and avoid scattering duplicated hard-coded text across unrelated templates.

## User Roles
- Visitors browse listings and contact owners directly.
- Owners create an account, upload listings, and manage their listings from a dashboard.

## Listing Categories
All published offers belong to the `Listing` model. Listings are separated by category/type, not by separate models.

The product currently has two listing categories:
- Sailing rentals: boats used for sailing, touring, or nautical trips.
- Stay rentals: houses, apartments, rooms, holiday rentals, unusual stays, campsites, land, guest houses, and similar classic overnight rentals.

If a boat is rented as a classic overnight stay instead of for sailing/touring, it belongs to the stay rental category, not the sailing rental category.

Internal DB enum values and their French UI labels:
- `boats` → `Bateau`
- `stays` → `Hébergement`

## Contact Model
Morgates does not include internal messaging, chat, or email forms in the MVP. Visitors contact owners directly through owner-provided contact channels.

The `Listing` model stores the following contact fields:
- `contact_email`
- `contact_phone`
- `contact_whatsapp`
- `contact_website`
- `contact_social_links` (JSON array)

The model has a `primaryContactUrl()` helper that returns the best available contact link in order: email → phone → WhatsApp → website → owner email fallback.

The contact experience should make the owner's direct channels clear and accessible without adding Morgates as an intermediary.

## Publishing And Validation
Owners can publish listings instantly in the MVP. There is no pre-publication approval workflow for now.

Minimum trust and safety requirements are still open and should be refined along the way. Do not overbuild this early, but keep the architecture flexible enough to add requirements such as verified contact details, required photos, profile completion, moderation, or reporting later.

## Business Model
The MVP is free. The intended business model is a monthly or yearly owner subscription.

The concept is a digital version of the old mail-order catalog model: owners pay or subscribe to appear, choose a simple plan, and then run their own business directly with visitors. Morgates should not take transaction fees or booking commissions. The product direction is deliberately simple: cut intermediaries and fees.

## MVP Scope
Currently out of scope for the MVP:
- payments
- online booking
- availability calendar
- reviews
- chat or internal messaging
- multilingual UI

This scope can evolve, but default to keeping the MVP lightweight and direct-contact focused.

## Data Ownership And Visitor Flow
The goal is to send visitors to owner channels as fast as possible. Morgates should help visitors discover a relevant listing and then make the owner's direct contact options obvious.

## Admin Needs
Loïs needs an admin dashboard in the MVP to manage users, listings/content, and basic KPIs.

## Launch Direction
Launch planning is still open. Given the small team, strict budget, and flexible MVP approach, prefer lightweight validation over large launch efforts. A practical direction is to start with a small focused region or niche, manually onboard early owners, collect feedback quickly, and only expand when the direct-contact model is working.

## Content Rules
Detailed prohibited listing types, regions, owner behavior rules, and claim rules are still open. For now, follow common marketplace patterns and avoid adding complex legal or moderation systems too early. Keep the code flexible enough to add terms, reporting, moderation, and content status fields later.

## Tech Stack
- Laravel 12
- PHP 8.2+
- Blade templates
- Vite
- Vanilla CSS
- Vanilla JavaScript
- Tabler Icons (via `blade-tabler-icons`)
- SQLite for local development
- PHPUnit via Laravel's test runner
- Hostinger for hosting

## Main App Areas
- Public home page: `/`
- Listings index: `/annonces`
- Listing detail pages: `/annonces/{listing:slug}`
- Authentication: `/connexion`, `/inscription`, `/deconnexion`
- Account dashboard: `/mon-espace`
- Account listings: `/mon-espace/annonces`
- Account listings edit: `/mon-espace/annonces/{listing}/modifier`
- Account profile: `/mon-espace/profil`
- Account subscriptions: `/mon-espace/abonnements`
- Account onboarding: `/bienvenue`
- Listing creation flow: `/mon-espace/publier`
- Legal pages: `/confidentialite`, `/conditions-utilisation`, `/a-propos`
- Contact page: `/contact`

## Domain Model

### Listing
The main domain entity. Listings belong to a user and include:
- `type` (enum: `boats`, `stays`)
- `title`, `slug`, `description`
- `photos` (JSON array)
- `price_amount` (decimal), `price_unit` (enum: `hour`, `half-day`, `day`, `week`, `month`, `contact`)
- `capacity` (unsigned small int)
- `min_duration`, `max_duration` (integers, always in **days**)
- `country` (char 2), `region`, `city`, `address`
- `latitude`, `longitude` (floats, from Google Maps autocomplete)
- `map_url` (Google Maps URL; the model derives a Google Maps embed URL via `getMapEmbedUrlAttribute()`)
- `tags` (JSON array; resolved via `config/tags.php` through `resolveTags()`)
- `is_active` (boolean)
- `contact_email`, `contact_phone`, `contact_whatsapp`, `contact_website`, `contact_social_links` (JSON)

Helper methods: `typeLabel()`, `priceUnitLabel()`, `primaryContactUrl()`, `resolveTags()`, `getMapEmbedUrlAttribute()`.

Slug is auto-generated on save via the `booted()` hook using `generateUniqueSlug()`. Route key is `slug`.

### Destination
A supporting lookup entity auto-populated from listing location data. Stores known cities/places with coordinates to power location autocomplete. Fields: `name`, `type`, `region`, `country`, `latitude`, `longitude`. Not user-facing. Created automatically by `ListingController::storePhotos()` when a listing with `city` + `latitude` is saved.

## Tags System
Tags are defined in `config/tags.php` as a flat associative array keyed by slug. Each entry has `group`, `icon`, and `label` fields. `group` is either `stays` or `boats` and controls which tags appear in step 4 of the creation flow based on the listing type. The `icon` must be a valid Tabler Icon name (rendered via the `blade-tabler-icons` package). Tags are stored as a JSON array of slugs on each listing and resolved via `Listing::resolveTags()`.

## Current Implementation State
- Public listing browsing and filtering exist.
- Listing filtering on `/annonces` supports:
  - `type` (enum filter)
  - `city` (exact match)
  - `region` (exact match)
  - `q` (free text: title, description, city, owner name)
  - `tag` (JSON contains)
  - `price_min` / `price_max` with `price_unit` normalization (weekly equivalent)
  - `capacity` (minimum capacity)
  - `sort` (`price_asc`, `price_desc`; defaults to latest)
- Listing detail page (`/annonces/{listing:slug}`) is fully built out with photos, map embed, tags, owner info, and contact channels.
- Login, registration, logout, and account access exist.
- Registration validates email uniqueness and strong passwords.
- User onboarding exists for name, photo, phone, country, and bio.
- Account dashboard (`/mon-espace`) shows a summary for the owner.
- Account listings page (`/mon-espace/annonces`) shows the owner's listings with status and edit actions.
- Account profile page (`/mon-espace/profil`) lets owners edit their profile fields inline.
- Account subscriptions page (`/mon-espace/abonnements`) exists with placeholder plan data.
- Legal pages (privacy, terms, about) and a contact page exist with placeholder content.
- Listing creation is a fully functional six-step Blade flow that persists data to the database:
  1. **Type** — listing type (`boats`/`stays`) and title; stored to session
  2. **Location** — country, region, city, address, coordinates, map URL; stored to session
  3. **Basics** — price, price unit, capacity, min/max duration (days); stored to session
  4. **Details** — tags, contact channels (email, phone, WhatsApp, website); stored to session
  5. **Description** — free-text description; stored to session
  6. **Photos** — final step; creates the `Listing` record from session data, optionally auto-creates a `Destination` record, clears the session, redirects to account
- Photo upload in step 6 is not yet implemented (placeholder only).
- Location autocomplete in step 2 uses a Google Maps API integration.

## Important Files
- `routes/web.php`: all web routes.
- `app/Models/Listing.php`: listing model, fillable fields, casts, slug generation, and helper methods.
- `app/Models/Destination.php`: destination lookup model with search scopes.
- `app/Http/Controllers/AuthController.php`: login, registration, logout.
- `app/Http/Controllers/AccountController.php`: account dashboard, listings, profile, subscriptions, and listing edit.
- `app/Http/Controllers/OnboardingController.php`: account onboarding saves.
- `app/Http/Controllers/ListingController.php`: listing creation flow (6 steps + session persistence + final DB write).
- `config/tags.php`: tag definitions (slug → icon + French label).
- `resources/views/pages/`: public pages (home, listings index, listing show, legal, contact).
- `resources/views/account/`: private account pages and listing creation step views.
- `resources/views/account/create/`: the six listing creation step views.
- `resources/views/components/`: reusable Blade components (filter panel, search modal, listing cards, tags, etc.).
- `resources/views/components/ui/`: generic reusable UI components (buttons, etc.).
- `resources/views/layouts/`: Blade layouts.
- `resources/css/`: application CSS entry points.
- `database/migrations/`: database schema.
- `database/seeders/`: seed data.

## Conventions
Coding conventions are in `.claude/rules/coding.md`.
Frontend and design rules are in `.claude/rules/design.md`.

## Development Commands
- Run backend tests: `php artisan test`
- Run frontend build: `npm run build`
- Run the full dev workflow: `composer run dev`
- Run only Vite dev server: `npm run dev`

## Known TODOs
- Implement production-ready image upload/storage for listing photos (evaluate Cloudinary). Deferred — core listing logic is the current priority.
- Add photo display and management in the account listing edit view.
- Add basic admin dashboard for Loïs (users, listings, basic KPIs) — will be a custom Blade area, no third-party admin package.
- Add owner trust fields: confirmation email, required contact details before publishing.
- Track key MVP metrics: listing views, contact clicks by channel, owner signups, published listings.
- Refine legal page content (privacy, terms).
- Expand test coverage beyond the default/example tests.
- Review and improve location autocomplete UX on mobile (step 2).

## Local Development Notes
- Kevin usually runs `php artisan serve` from the IDE terminal during development.
- Kevin usually has the Vite dev server/build watcher running from the IDE, so agents should not run `npm run build` unless explicitly needed or requested.

## Hostinger Premium Plan
Project will be powered by Hostinger with their premium plan:
- Storage: 20 GB SSD
- RAM: 2 GB
- CPU: 1 core
- Websites: up to 3
- Bandwidth: unlimited
- PHP Workers: 40
- Databases: 10 (3 GB size limit each)
- Inodes: 400,000

The MVP must run smoothly there up to ~3,000 users before needing an upgrade. Prefer lightweight, low-memory implementations.
