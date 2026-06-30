@extends('layouts.app')

@section('title', 'Contact - Morgates')

@section('content')
  <main class="contact-page">

    <section class="contact-hero">
      <h1>Une question ?</h1>
      <p class="contact-tagline">Choisissez le canal qui vous convient, on vous répond directement.</p>
    </section>

    <section class="contact-methods">
      <a href="mailto:contact@morgates.com" class="contact-method">
        <div class="contact-method-icon">
          @svg('tabler-mail')
        </div>
        <div class="contact-method-body">
          <span class="contact-method-label">Email</span>
          <span class="contact-method-value">contact@morgates.com</span>
        </div>
        @svg('tabler-chevron-right', ['class' => 'contact-method-chevron'])
      </a>

      <a href="https://wa.me/33600000000" target="_blank" rel="noopener noreferrer" class="contact-method">
        <div class="contact-method-icon">
          @svg('tabler-brand-whatsapp')
        </div>
        <div class="contact-method-body">
          <span class="contact-method-label">WhatsApp</span>
          <span class="contact-method-value">Discuter avec nous</span>
        </div>
        @svg('tabler-chevron-right', ['class' => 'contact-method-chevron'])
      </a>
    </section>

  </main>
@endsection

@push('styles')
  <style>
    .contact-page {
      padding: 2rem 1.25rem 4rem;
      display: flex;
      flex-direction: column;
      gap: 2rem;
    }

    .contact-hero {
      padding-top: 1.5rem;
    }

    .contact-hero h1 {
      font-size: 1.75rem;
      font-weight: 700;
      color: var(--clr-text-dark);
      margin-bottom: 0.5rem;
    }

    .contact-tagline {
      font-size: 0.95rem;
      color: var(--clr-text-medium);
      line-height: 1.6;
    }

    .contact-methods {
      display: flex;
      flex-direction: column;
      border: 0.5px solid #EBEBEB;
      border-radius: 0.875rem;
      overflow: hidden;
      box-shadow: var(--box-shadow);
    }

    .contact-method {
      display: flex;
      align-items: center;
      gap: 0.875rem;
      padding: 1rem 1.125rem;
      background: var(--clr-background);
      border-bottom: 0.5px solid #EBEBEB;
      text-decoration: none;
      transition: background 0.15s;
    }

    .contact-method:last-child {
      border-bottom: none;
    }

    .contact-method:hover {
      background: #FAFAFA;
    }

    .contact-method-icon {
      flex-shrink: 0;
      width: 2.5rem;
      height: 2.5rem;
      border-radius: 0.625rem;
      background: color-mix(in srgb, var(--clr-primary) 10%, transparent);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--clr-primary);
    }

    .contact-method-icon svg {
      width: 1.25rem;
      height: 1.25rem;
    }

    .contact-method-body {
      display: flex;
      flex-direction: column;
      gap: 0.125rem;
      flex: 1;
      min-width: 0;
    }

    .contact-method-label {
      font-size: 0.72rem;
      color: var(--clr-text-light);
    }

    .contact-method-value {
      font-size: 0.9rem;
      font-weight: 600;
      color: var(--clr-text-dark);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .contact-method-chevron {
      flex-shrink: 0;
      width: 1rem;
      height: 1rem;
      color: #D0D0D0;
    }
  </style>
@endpush
