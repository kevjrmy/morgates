# Morgates

Morgates is a French Laravel web app for publishing and browsing rental listings. Its goal is to connect visitors directly with owners, without acting as a booking platform or adding intermediaries.

The project is currently an MVP in active development.

## Documentation

- `AGENTS.md`: project context, product direction, domain model, conventions, and implementation state for AI coding agents.
- `.claude/rules/coding.md`: coding conventions and agent workflow rules.
- `.claude/rules/design.md`: frontend and design rules.
- `TODO.md`: current project TODO list (`todo.md`).
- `doc.md`: small deployment/dependency notes.

For AI/code agents: read `AGENTS.md` before making changes. After relevant work, proactively update context files (`AGENTS.md`, `todo.md`, `.claude/rules/`) so they stay accurate: see **Context Files Maintenance** in `AGENTS.md`.

## Tech Stack

- Laravel 12
- PHP 8.2+
- Blade
- Vite
- Vanilla CSS
- Vanilla JavaScript
- SQLite for local development
- PHPUnit

## Development

Run backend tests:

```bash
php artisan test
```

Run frontend build:

```bash
npm run build
```

Run the local development workflow:

```bash
composer run dev
```

## Deployment Note

If `composer.lock` changes after adding, updating, or removing a Composer package, SSH into Hostinger and run:

```bash
cd /domains/whitesmoke-spoonbill-547959.hostingersite.com/public_html
git pull origin main
composer install --no-dev --optimize-autoloader --ignore-platform-reqs
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
