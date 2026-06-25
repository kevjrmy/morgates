<dialog id="{{ $confirmModalId }}" class="account-bottom-sheet account-confirm-sheet" aria-label="Confirmer la suppression de {{ $field['label'] }}">
  <div class="account-bottom-sheet-header">
    <div>
      <h3>Supprimer {{ strtolower($field['label']) }}</h3>
    </div>
    <form method="dialog">
      <button type="submit" class="account-bottom-sheet-close" aria-label="Fermer">
        @svg('tabler-x')
      </button>
    </form>
  </div>

  <div class="account-bottom-sheet-body">
    <p class="account-confirm-copy">Cette information sera retirée de votre profil.</p>

    <form action="{{ route('account.profile.clear', $name) }}" method="POST" class="account-bottom-sheet-clear-form">
      @csrf
      @method('DELETE')
      <button type="submit" class="account-field-clear">Confirmer la suppression</button>
    </form>

    <form method="dialog">
      <button type="submit" class="account-field-cancel">Annuler</button>
    </form>
  </div>
</dialog>
