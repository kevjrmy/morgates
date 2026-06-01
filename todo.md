# TODO

## Short-Term MVP Features

1. **Persist the listing creation flow**
   - Save each step of `/mon-espace/publier` to a `Listing` record.
   - Allow owners to publish instantly at the end of the flow.
   - Include contact channel fields (email, phone, WhatsApp, website, social links) in the creation flow.

2. **Implement listing photos**
   - Decide MVP storage approach.
   - Evaluate Cloudinary for production-ready image/photo storage.
   - Keep upload UX lightweight and mobile-friendly.

3. **Improve the owner dashboard**
   - Show owner's listings with status (active/inactive).
   - Add edit/delete and activate/deactivate actions.
   - Make the dashboard mobile-first.

4. **Add basic admin dashboard for Loïs**
   - Manage users.
   - Manage listings/content.
   - Display basic KPIs: signups, total listings, active listings, contact clicks (if tracked).

5. **Add basic owner trust fields**
   - Confirmation/verification email on registration.
   - Require at least one contact detail before publishing.
   - Keep requirements simple until trust and safety rules are clearer.

6. **Track key MVP metrics**
   - Listing views.
   - Contact clicks by channel (email, phone, WhatsApp, website).
   - Owner signups.
   - Published listings count.

7. **Refine legal content**
   - Terms of service page (currently placeholder).
   - Privacy policy page (currently placeholder).
   - Add simple marketplace content rules later.

8. **Expand test coverage**
   - Add feature tests for listing creation flow, filtering, and contact.
   - Add unit tests for model helpers.


## Perso
- finir le UI de la page de profil puis le conecter avec le backend