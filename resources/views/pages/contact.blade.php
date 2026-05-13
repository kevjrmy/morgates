@extends('layouts.app')

@section('content')
  <main class="contact-page">
    <div class="contact-container">
      <h1>Contactez-nous</h1>
      <p>Une question ? Une suggestion ? Nous sommes à votre écoute pour vous aider.</p>
      
      <div class="contact-methods">
        <div class="contact-method">
          <div class="icon-circle">
            @svg('mdi-email-outline')
          </div>
          <h3>Email</h3>
          <p><a href="mailto:contact@morgates.com">contact@morgates.com</a></p>
        </div>
        
        <div class="contact-method">
          <div class="icon-circle">
            @svg('mdi-whatsapp')
          </div>
          <h3>WhatsApp</h3>
          <p><a href="https://wa.me/33600000000">Discuter avec nous</a></p>
        </div>
      </div>
    </div>
  </main>
@endsection

@push('styles')
  <style>
    .contact-page {
      padding: 4rem 1.5rem;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 70vh;
    }
    
    .contact-container {
      text-align: center;
      max-width: 600px;
      width: 100%;
    }
    
    .contact-container h1 {
      font-size: 2.25rem;
      font-weight: 800;
      color: var(--clr-text-dark);
      margin-bottom: 1rem;
      letter-spacing: -0.02em;
    }
    
    .contact-container p {
      color: var(--clr-text-medium);
      font-size: 1.1rem;
      margin-bottom: 3.5rem;
      line-height: 1.6;
    }
    
    .contact-methods {
      display: grid;
      grid-template-columns: 1fr;
      gap: 1.5rem;
    }
    
    .contact-method {
      background: white;
      padding: 2.5rem 2rem;
      border-radius: 32px;
      border: 1px solid rgba(0, 68, 170, 0.05);
      box-shadow: 0 15px 35px -5px rgba(0, 68, 170, 0.05);
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.75rem;
      transition: transform 0.3s ease;
    }

    .contact-method:hover {
      transform: translateY(-5px);
    }
    
    .icon-circle {
      width: 64px;
      height: 64px;
      background: var(--clr-softblue);
      color: var(--clr-primary);
      border-radius: 22px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 0.5rem;
    }
    
    .icon-circle svg {
      width: 30px;
      height: 30px;
    }
    
    .contact-method h3 {
      font-size: 1.25rem;
      font-weight: 700;
      color: var(--clr-text-dark);
    }
    
    .contact-method a {
      color: var(--clr-primary);
      font-weight: 700;
      text-decoration: none;
      font-size: 1.05rem;
    }

    .contact-method a:hover {
      text-decoration: underline;
    }
    
    @media (min-width: 640px) {
      .contact-methods {
        grid-template-columns: 1fr 1fr;
      }
    }
  </style>
@endpush