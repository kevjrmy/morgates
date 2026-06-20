# Design Rules

## Brand Feel
Morgates should feel: calm, local, accessible, indie, direct, autonomous, trustful, secure, reliable, intuitive.
Avoid: flashy, busy, platform-y, intermediary-heavy aesthetics.

## UX Principles
- Build the real app experience, not a marketing landing page, unless explicitly requested.
- Keep marketplace screens efficient, scannable, and practical.
- Prioritize listing discovery, trustworthy owner profiles, direct contact flows, and a smooth multi-step publishing experience.
- The goal is to send visitors to owner channels as fast as possible.
- Inspiration: Airbnb (layout and interaction patterns), Wallapop (direct buyer/seller connection). Keep Morgates' distinct direct-contact positioning.

## Layout
- **Mobile-first.** Design for vertical/mobile layouts first. Desktop responsive/horizontal layouts come later.
- Keep the interface lightweight and easy to load.

## Animations
- Use non-invasive, smooth, and short animations only.
- The interface should communicate calmness, not urgency.

## CSS & Styling
- Use the CSS variables defined in `resources/css/app.css` as much as possible.
- Vanilla CSS and vanilla JavaScript only — no UI frameworks or component libraries.
- Prefer scoped CSS at the view or component level using `@push('styles')`.
- Put CSS in shared files only when reused across multiple views/components.
- Reuse existing CSS files and layout structure where they already match the intended scope.

## Icons
- Use Tabler Icons exclusively via the `blade-tabler-icons` package: `@svg('tabler-icon-name')`.
- Icon names must be valid Tabler Icon slugs.

## Forms & Interactive Components
- Make forms, filters, listing cards, and account flows responsive on both mobile and desktop.
- Prefer intuitive UI/UX over impressive or flashy interactions.
- Use stepper inputs, toggle switches, and card selectors where they suit the context (see listing creation steps for patterns).

## Copy
- All user-facing copy in French.
- Keep visible strings easy to extract into Laravel translation files later.
- Avoid duplicating hard-coded text across unrelated templates.
