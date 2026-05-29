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
- `stays` → `Séjour`

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

## Brand Direction
Morgates should feel:
- calm
- local
- accessible
- indie
- direct
- autonomous
- trustful
- secure
- reliable
- intuitive

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
- Account area: `/mon-espace`
- Account subscriptions: `/mon-espace/abonnements`
- Account onboarding: `/bienvenue`
- Listing creation flow: `/mon-espace/publier`
- Legal pages: `/confidentialite`, `/conditions-utilisation`, `/a-propos`
- Contact page: `/contact`

## Domain Model
The main domain entity is `Listing`.

Listings belong to a user and currently include fields for:
- `type` (enum: `boats`, `stays`)
- `title`, `slug`, `description`
- `photos` (JSON array)
- `price_amount` (decimal), `price_unit` (enum: `hour`, `half-day`, `day`, `week`, `month`, `contact`)
- `capacity` (unsigned small int)
- `min_duration`, `max_duration`, `duration_unit` (enum: `day`, `week`, `month`)
- `country` (char 2), `region`, `city`, `address`
- `map_url` (Google Maps URL; the model derives a Google Maps embed URL from it via `getMapEmbedUrlAttribute()`)
- `tags` (JSON array; resolved via `config/tags.php` through `resolveTags()`)
- `is_active` (boolean)
- `contact_email`, `contact_phone`, `contact_whatsapp`, `contact_website`, `contact_social_links` (JSON)

The model exposes helper methods: `typeLabel()`, `priceUnitLabel()`, `durationUnitLabel()`, `primaryContactUrl()`, `resolveTags()`, `getMapEmbedUrlAttribute()`.

Listing routes use the `slug` as the route key.

## Tags System
Tags are defined in `config/tags.php` as a flat associative array keyed by slug. Each entry has `icon` and `label` fields. The `icon` must be a valid Tabler Icon name (rendered via the `blade-tabler-icons` package). There are two groups of tags: stay tags and boat tags. Tags are stored as a JSON array of slugs on each listing and resolved via `Listing::resolveTags()`.

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
- Account dashboard (`/mon-espace`) shows the owner's listings.
- Account subscriptions page (`/mon-espace/abonnements`) exists with placeholder plan data.
- Legal pages (privacy, terms, about) and a contact page exist with placeholder content.
- Listing creation is scaffolded as a six-step Blade flow:
  1. type
  2. location
  3. basics
  4. details
  5. description
  6. photos
- The listing creation controller redirects between steps but does **not** persist listing data yet.

## Important Files
- `routes/web.php`: main web routes.
- `app/Models/Listing.php`: listing model, fillable fields, casts, and helper methods.
- `app/Http/Controllers/AuthController.php`: login, registration, logout.
- `app/Http/Controllers/AccountController.php`: account dashboard and subscriptions page.
- `app/Http/Controllers/OnboardingController.php`: account onboarding saves.
- `app/Http/Controllers/ListingController.php`: listing creation flow (steps).
- `config/tags.php`: tag definitions (slug → icon + French label).
- `resources/views/pages/`: public pages (home, listings index, listing show, legal, contact).
- `resources/views/account/`: private account pages and listing creation step views.
- `resources/views/components/`: reusable Blade components (filter panel, search modal, listing cards, tags, etc.).
- `resources/views/components/ui/`: generic reusable UI components (buttons, etc.).
- `resources/views/layouts/`: Blade layouts.
- `resources/css/`: application CSS entry points.
- `database/migrations/`: database schema.
- `database/seeders/`: seed data.

## Development Commands
- Run backend tests: `php artisan test`
- Run frontend build: `npm run build`
- Run the full dev workflow: `composer run dev`
- Run only Vite dev server: `npm run dev`

## Coding Conventions
- Prefer Laravel conventions and existing local patterns.
- Use Blade templates and existing layouts/components before adding new abstractions.
- Keep changes scoped to the requested task.
- Keep code, code comments, class names, function names, and variable names in English.
- Keep visible UI text in French.
- Do not add large dependencies without a clear reason.
- Avoid unrelated refactors.
- Preserve existing uncommitted user work.
- Avoid semicolons in JavaScript.

## Frontend Direction
- Build the real app experience, not a marketing landing page, unless explicitly requested.
- Keep marketplace screens efficient, scannable, and practical.
- Focus on vertical/mobile design first. Desktop responsive/horizontal layouts will be designed later.
- It is acceptable to take interaction and layout inspiration from Airbnb, while keeping Morgates' distinct direct-contact positioning.
- Wallapop is another strong inspiration because it connects buyers and sellers directly, which is close to Morgates' visitor-owner relation model.
- Keep the interface lightweight and easy to load.
- Use non-invasive, smooth, short animations. The interface should communicate calmness, not hurry.
- Prefer intuitive UI/UX over impressive or flashy design.
- Use the CSS variables defined in `resources/css/app.css` as much as possible and keep UI styling consistent with them.
- Use vanilla CSS and vanilla JavaScript.
- Prefer scoped CSS and scoped JavaScript at the view or component template level.
- Put CSS or JavaScript in shared files only when it is reused across multiple views/components.
- Reuse existing CSS files and layout structure where they already match the intended scope.
- Make forms, filters, listing cards, and account flows responsive on mobile and desktop.

## Known TODOs
- Persist the listing creation flow (save each step to a `Listing` record).
- Implement production-ready image upload/storage (evaluate Cloudinary).
- Improve the owner dashboard: show listings with status, edit/delete/activate actions.
- Add basic admin dashboard for Loïs (users, listings, basic KPIs).
- Add owner trust fields: confirmation email, required contact details before publishing.
- Track key MVP metrics: listing views, contact clicks by channel, owner signups, published listings.
- Refine legal page content (privacy, terms).
- Expand test coverage beyond the default/example tests.

## Agent Workflow Notes
- Start by checking `git status --short`.
- Treat uncommitted changes as user work unless clearly generated by the current task.
- Read the relevant route, controller, model, Blade view, and CSS before editing.
- Run `php artisan test` for backend changes when feasible.
- Run `npm run build` for frontend/CSS/Blade asset changes when feasible.
- If tests or builds cannot be run, report that clearly in the final response.

## Local Development Notes
- Kevin usually runs `php artisan serve` from the IDE terminal during development.
- Kevin usually has the Vite dev server/build watcher running from the IDE, so agents should not run `npm run build` unless explicitly needed or requested.