@extends('layouts.app')

@section('title', 'Page introuvable - Morgates')
@section('robots', 'noindex, nofollow')

@push('styles')
<style>
  .error-page {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 4rem 1.5rem 6rem;
    min-height: 60vh;
    gap: 1rem;
  }

  .error-code {
    font-size: 5rem;
    font-weight: 700;
    color: var(--clr-primary);
    line-height: 1;
    opacity: 0.15;
  }

  .error-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--clr-text-dark);
    margin: 0;
  }

  .error-body {
    font-size: 0.9rem;
    color: var(--clr-text-medium);
    line-height: 1.6;
    max-width: 22rem;
    margin: 0;
  }

  .error-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    justify-content: center;
    margin-top: 0.5rem;
  }

  .error-btn-primary {
    display: inline-flex;
    align-items: center;
    padding: 0.7rem 1.25rem;
    border-radius: 0.625rem;
    background: var(--clr-primary);
    color: #fff;
    font-size: 0.875rem;
    font-weight: 600;
    transition: opacity 0.2s;
  }

  .error-btn-primary:hover {
    opacity: 0.88;
  }

  .error-btn-secondary {
    display: inline-flex;
    align-items: center;
    padding: 0.7rem 1.25rem;
    border-radius: 0.625rem;
    border: 0.5px solid #DADADA;
    background: var(--clr-background);
    color: var(--clr-text-dark);
    font-size: 0.875rem;
    font-weight: 500;
    transition: border-color 0.2s;
  }

  .error-btn-secondary:hover {
    border-color: var(--clr-primary);
  }
</style>
@endpush

@section('content')
  <main class="error-page">
    <p class="error-code">404</p>
    <h1 class="error-title">Page introuvable</h1>
    <p class="error-body">La page que vous cherchez n'existe pas ou a été déplacée.</p>
    <div class="error-actions">
      <a href="{{ route('home') }}" class="error-btn-primary">Retour à l'accueil</a>
      <a href="{{ route('listings') }}" class="error-btn-secondary">Voir les annonces</a>
    </div>
  </main>
@endsection
