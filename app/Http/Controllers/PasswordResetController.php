<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
  public function requestForm()
  {
    return view('auth.forgot-password');
  }

  public function sendResetLink(Request $request)
  {
    $request->validate(['email' => ['required', 'email']]);

    Password::sendResetLink($request->only('email'));

    // Always show success to prevent email enumeration
    return back()->with('status', 'Si un compte existe avec cette adresse, vous recevrez un email dans quelques instants.');
  }

  public function resetForm(Request $request, string $token)
  {
    return view('auth.reset-password', [
      'token' => $token,
      'email' => $request->query('email', ''),
    ]);
  }

  public function reset(Request $request)
  {
    $request->validate([
      'token'    => ['required'],
      'email'    => ['required', 'email'],
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
      'password.min'       => 'Le mot de passe doit contenir au moins 8 caractères.',
      'password.regex'     => 'Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et un caractère spécial.',
      'password.confirmed' => 'Les mots de passe ne correspondent pas.',
    ]);

    $status = Password::reset(
      $request->only('email', 'password', 'password_confirmation', 'token'),
      function (User $user, string $password) {
        $user->forceFill(['password' => Hash::make($password)])->save();
      }
    );

    if ($status === Password::PASSWORD_RESET) {
      return redirect()->route('login')
        ->with('success', 'Mot de passe mis à jour. Vous pouvez vous connecter.');
    }

    return back()->withErrors(['email' => 'Ce lien est invalide ou a expiré. Faites une nouvelle demande.']);
  }
}
