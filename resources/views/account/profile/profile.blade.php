@extends('layouts.account')

@section('title', 'Mon profil — Morgates')

@section('content')
  <main id="account-page" class="account-profile-page">

    <section class="account-profile-hero">
      <div class="account-profile-avatar">
        @if($user->profile_picture)
          <img src="{{ asset($user->profile_picture) }}" alt="{{ $user->display_host_name ?: 'Photo de profil' }}">
        @else
          @svg($user->isCompany() ? 'tabler-building' : 'tabler-user', ['class' => 'account-avatar-icon'])
        @endif
      </div>
    </section>

    @include('account.profile.partials.section-identity')

    @include('account.profile.partials.section-languages')

    @include('account.profile.partials.section-contact')

  </main>

  <button
    type="submit"
    form="profile-form"
    id="profile-save"
    class="profile-save-float"
    {{ $errors->hasAny(['account_type', 'first_name', 'last_name', 'company_name', 'host_name', 'bio']) ? '' : 'disabled' }}
  >
    @svg('tabler-device-floppy')
    Enregistrer
  </button>
@endsection

@push('scripts')
  <script>
    document.querySelectorAll('[data-profile-modal-open]').forEach((trigger) => {
      trigger.addEventListener('click', () => {
        const modal = document.getElementById(trigger.dataset.profileModalOpen)
        const currentModal = trigger.dataset.profileModalClose
          ? document.getElementById(trigger.dataset.profileModalClose)
          : trigger.closest('dialog')

        if (!modal || typeof modal.showModal !== 'function') return

        if (currentModal && currentModal.open && currentModal !== modal) {
          currentModal.close()
        }

        if (modal.classList.contains('account-actions-sheet')) {
          const rect = trigger.getBoundingClientRect()
          const menuWidth = Math.min(224, window.innerWidth - 32)
          const left = Math.min(Math.max(16, rect.right - menuWidth), window.innerWidth - menuWidth - 16)
          const top = Math.min(rect.bottom + 8, window.innerHeight - 160)

          modal.style.setProperty('--account-actions-left', `${left}px`)
          modal.style.setProperty('--account-actions-top', `${Math.max(16, top)}px`)
        }

        modal.showModal()
      })
    })

    document.querySelectorAll('.account-bottom-sheet').forEach((modal) => {
      modal.addEventListener('click', (event) => {
        if (event.target === modal) modal.close()
      })
    })

  </script>
@endpush
