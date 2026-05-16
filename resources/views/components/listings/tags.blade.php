@props(['listing'])

@php
  $tags = $listing->resolveTags();
  $limit = 8;
  $hasMore = count($tags) > $limit;
  $displayTags = $hasMore ? array_slice($tags, 0, $limit) : $tags;
@endphp

@if (count($tags) > 0)
  <section class="listing-tags">
    <h2>Équipements</h2>
    <ul class="tags-list" role="list">
      @foreach ($displayTags as $tag)
        <li class="tag">
          @svg('tabler-' . $tag['icon'], ['class' => 'tag-icon'])
          <span class="tag-label">{{ $tag['label'] }}</span>
        </li>
      @endforeach
    </ul>

    @if ($hasMore)
      <button type="button" class="btn-all-tags" id="btn-all-tags-open">
        Voir les {{ count($tags) }} équipements
      </button>

      {{-- Bottom Sheet for all tags --}}
      <div class="bottom-sheet-overlay" id="tags-bottom-sheet" hidden>
        <div class="bottom-sheet-panel">
          <button type="button" class="bottom-sheet-close" aria-label="Fermer">
            @svg('tabler-x')
          </button>

          <h2 class="bottom-sheet-title">Tous les équipements</h2>

          <div class="tags-full-list">
            @foreach ($tags as $tag)
              <div class="tag-full-item">
                <span class="tag-full-icon">@svg('tabler-' . $tag['icon'])</span>
                <span class="tag-full-label">{{ $tag['label'] }}</span>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    @endif
  </section>

  @push('styles')
    <style>
      .listing-tags h2 {
        font-size: 1.1rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
      }
      .tags-list {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
      }
      .tag {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 99px;
        border: var(--border);
        font-size: 0.875rem;
        color: var(--clr-text-medium);
        background-color: #fff;
        transition: all 0.2s ease;
      }
      .tag:hover {
        border-color: var(--clr-primary);
        color: var(--clr-primary);
      }
      .tag-icon {
        width: 1.1rem;
        height: 1.1rem;
        flex-shrink: 0;
        color: var(--clr-primary);
      }
      .tag-label {
        line-height: 1;
      }
      .btn-all-tags {
        margin-top: 1rem;
        width: 100%;
        padding: 0.75rem;
        border-radius: 0.5rem;
        border: 1px solid var(--clr-text-dark);
        background: #fff;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s ease;
      }
      .btn-all-tags:hover {
        background-color: var(--clr-tertiary);
      }
      .tags-full-list {
        display: flex;
        flex-direction: column;
        gap: 0;
        margin-top: 1.5rem;
      }
      .tag-full-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem 0;
        border-bottom: var(--border);
      }
      .tag-full-item:last-child {
        border-bottom: none;
      }
      .tag-full-icon {
        color: var(--clr-text-dark);
        display: flex;
        align-items: center;
      }
      .tag-full-icon svg {
        width: 1.5rem;
        height: 1.5rem;
      }
      .tag-full-label {
        font-size: 1rem;
        color: var(--clr-text-dark);
      }
    </style>
  @endpush

  @if ($hasMore)
    @push('scripts')
      <script>
        (function() {
          const btnTagsOpen = document.getElementById('btn-all-tags-open');
          const tagsBottomSheet = document.getElementById('tags-bottom-sheet');
          const tagsClose = tagsBottomSheet?.querySelector('.bottom-sheet-close');

          if (!btnTagsOpen || !tagsBottomSheet) return;

          const openTags = () => {
            tagsBottomSheet.hidden = false;
            document.body.style.overflow = 'hidden';
          };

          const closeTags = () => {
            tagsBottomSheet.hidden = true;
            document.body.style.overflow = '';
          };

          btnTagsOpen.addEventListener('click', openTags);
          tagsClose?.addEventListener('click', closeTags);
          tagsBottomSheet.addEventListener('click', e => {
            if (e.target === tagsBottomSheet) closeTags();
          });
          document.addEventListener('keydown', e => {
            if (e.key === 'Escape' && !tagsBottomSheet.hidden) closeTags();
          });
        })();
      </script>
    @endpush
  @endif
@endif
