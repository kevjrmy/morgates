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
- Vanilla CSS and vanilla JavaScript only; no UI frameworks or component libraries.
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

## Readability
- Navigation links, labels, and any actionable text must use `--clr-text-dark` as the base color. Never use `--clr-text-medium` or `--clr-text-light` on text the user needs to read and act on.
- `--clr-text-medium` is for supporting text: metadata, hints, subtitles, secondary info.
- `--clr-text-light` is for decorative or de-emphasized elements: timestamps, eyebrows, section labels, placeholders, disabled states.
- When reducing font size, compensate with `font-weight: 600` or `--clr-text-dark` to preserve legibility. Never reduce both size and color weight simultaneously.

## Copy
- All user-facing copy in French.
- Do **not** use em dashes (`—`) in user-facing copy. Use a colon, comma, hyphen (`-`), slash, or rephrase instead.
- Keep visible strings easy to extract into Laravel translation files later.
- Avoid duplicating hard-coded text across unrelated templates.
