# TODO

## Short-Term MVP Features

1. **Implement listing photos**
    - Decide MVP storage approach (evaluate Cloudinary).
    - Keep upload UX lightweight and mobile-friendly.
    - Add photo display and management in the listing edit view.

2. **Add basic admin dashboard for Loïs**
    - Custom Blade area (no third-party admin package).
    - Manage users and listings/content.
    - Display basic KPIs: signups, total listings, active listings, contact clicks (if tracked).

3. **Add basic owner trust fields**
    - Confirmation/verification email on registration.
    - Require at least one contact detail before publishing.
    - Keep requirements simple until trust and safety rules are clearer.

4. **Track key MVP metrics**
    - Listing views.
    - Contact clicks by channel (email, phone, WhatsApp, website).
    - Owner signups.
    - Published listings count.

5. **Refine legal content**
    - Terms of service page (currently placeholder).
    - Privacy policy page (currently placeholder).
    - Add simple marketplace content rules later.

6. **Expand test coverage**
    - Add feature tests for listing creation flow, filtering, and contact.
    - Add unit tests for model helpers.

## Backlog

- Review location autocomplete UX on mobile (step 2 of listing creation).
- Add `contact_social_links` to the listing creation flow and edit view.
- Listing deactivate / delete actions from the account listings page.
- Add optional links to external booking platforms (Airbnb, Booking.com, etc.) in the listing creation flow — for owners who are also listed elsewhere.
