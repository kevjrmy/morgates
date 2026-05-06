# TODO

## Short-Term MVP Features

1. Persist the listing creation flow
   - Save each step of `/mon-espace/publier`.
   - Keep both categories in the same `Listing` model.
   - Use clear internal category values such as `sailing` and `stays`.
   - Allow owners to publish instantly.

2. Add direct owner contact channels
   - Email.
   - Phone.
   - WhatsApp.
   - External website/contact link.
   - Social media links.
   - No internal chat, no email form, and no booking flow for the MVP.

3. Improve the owner dashboard
   - Show owner's listings.
   - Add listing status/actions.
   - Add edit/delete or activate/deactivate actions.
   - Make the dashboard mobile-first.

4. Add basic admin dashboard for Loïs
   - Manage users.
   - Manage listings/content.
   - Display basic KPIs: users, listings, active listings, contact clicks if tracked.

5. Implement listing photos
   - Decide MVP storage approach.
   - Evaluate Cloudinary for production-ready image/photo storage.
   - Keep upload UX lightweight and mobile-friendly.

6. Add basic owner trust fields
   - Confirmation email.
   - Required owner contact details before publishing.
   - Keep requirements simple until trust and safety rules are clearer.

7. Track key MVP metrics
   - Listing views.
   - Contact clicks by channel.
   - Owner signups.
   - Published listings.

8. Prepare legal/content basics
   - Terms and privacy pages already exist, but content may need refinement.
   - Add simple marketplace content rules later.
   - Keep moderation/reporting architecture possible without overbuilding now.
