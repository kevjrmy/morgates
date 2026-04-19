<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required'],
    ]);

    if (Auth::attempt($credentials, $request->boolean('remember'))) {
      $request->session()->regenerate();
      return redirect()->intended(route('account'));
    }

    return back()
      ->onlyInput('email')
      ->withErrors(['email' => 'Ces identifiants ne correspondent à aucun compte.']);
  }

  public function register(Request $request)
  {
    try {
      $request->validate([
        'email' => 'required|email|unique:users,email',
        'password' => [
          'required',
          'confirmed',
          'min:8',
          'max:72',
          'regex:/[A-Z]/',
          'regex:/[a-z]/',
          'regex:/[0-9]/',
          'regex:/[^A-Za-z0-9]/',
        ],
      ], [
        'email.required' => 'L\'adresse email est obligatoire.',
        'email.email' => 'L\'adresse email est invalide.',
        'email.unique' => 'Cette adresse email est déjà utilisée.',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        'password.regex' => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.',
        'password.confirmed' => 'Les mots de passe ne correspondent pas.',
      ]);
    } catch (ValidationException $e) {
      $firstError = collect($e->errors())->flatten()->first();

      return back()->with('error', $firstError)->withInput();
    }

    $user = User::create([
      'email' => strtolower($request->email),
      'password' => Hash::make($request->password),
    ]);

    Auth::login($user);

    return redirect()->route('onboarding.index')->with('success', 'Bienvenue ! Votre compte a été créé avec succès.');
  }

  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('home')->with('success', 'Vous avez été déconnecté avec succès.');
  }
}