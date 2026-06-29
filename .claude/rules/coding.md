# Coding Rules

## General
- Follow Laravel 12 conventions and existing local patterns.
- Keep changes strictly scoped to the requested task. No unrelated refactors.
- Keep code, comments, class names, function names, and variable names in **English**.
- Keep visible UI text in **French**.
- Do not add large dependencies without a clear reason.
- Do not add features, abstractions, error handling, or validation beyond what the task requires.
- Preserve uncommitted user work — treat it as in-progress unless the current task clearly generated it.

## Comments
- Write no comments by default.
- Only add a comment when the WHY is non-obvious: a hidden constraint, a subtle invariant, a workaround for a known bug.
- Never write multi-paragraph docstrings or multi-line comment blocks.

## Laravel / PHP
- Use Blade templates and existing layouts/components before creating new ones.
- Validate only at system boundaries (user input, external APIs). Trust internal code and framework guarantees.
- Route key for `Listing` is `slug` (defined via `getRouteKeyName()`).
- Listing types are `boats` and `stays` (DB enum values). UI labels: `Bateau`, `Hébergement`.
- Price units depend on listing type: boats allow `hour`, `half-day`, `day`, `week`, `month`, `contact`; stays allow `day`, `week`, `month`, `contact`.
- Duration fields (`min_duration`, `max_duration`) are always in **days** — there is no `duration_unit` column.
- The `Listing` model auto-generates its slug on save via the `booted()` hook. Do not set slugs manually in controllers unless handling creation uniqueness explicitly.
- Listings have a `preferred_contact` field and `contact_social_links` JSON (`instagram`, `messenger`). `primaryContactUrl()` respects the preferred channel.
- The `Destination` model is auto-populated from listing location data when `city` + `latitude` are present. It is not a user-facing entity.
- Tags live in `config/tags.php` under `common`, `stays`, and `boats` keys. Step 4 merges `common` + type-specific tags.
- Listing creation is a 7-step session flow (`ListingController::$totalSteps = 7`): type → location → basics → details (tags) → contact → description → photos.
- `User` has `account_type` (`individual`/`company`) and display name accessors (`display_host_name`, `greeting_name`, `full_name`, `isCompany()`).

## JavaScript
- No semicolons.
- Prefer scoped JS at the view or component level.
- Move JS to shared files only when reused across multiple views/components.

## CSS
- Use the CSS variables defined in `resources/css/app.css`.
- Prefer scoped CSS at the view or component level using `@push('styles')`.
- Move CSS to shared files only when reused across multiple views/components.

## Agent Workflow
- Start by checking `git status --short`.
- Read the relevant route, controller, model, Blade view, and CSS files before editing.
- Run `php artisan test` for backend changes when feasible.
- Kevin usually has the Vite dev server/build watcher running — do **not** run `npm run build` unless explicitly requested or needed.
- If tests or builds cannot be run, report that clearly.
