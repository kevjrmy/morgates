<?php

namespace App\Http\Controllers;

class AccountController extends Controller
{
  public function index()
  {
    $listings = auth()->user()->listings()->latest()->get();

    return view('account.index', compact('listings'));
  }

  public function subscriptions()
  {
    $user = auth()->user();
    $listings = $user->listings()->latest()->get();

    $plan = [
      'name' => 'Plan Découverte',
      'status' => 'Actif',
      'ends_at' => now()->addMonth()->locale('fr')->translatedFormat('d F Y'),
      'publication_limit' => 3,
    ];

    return view('account.subscriptions.index', compact('listings', 'plan'));
  }
}
