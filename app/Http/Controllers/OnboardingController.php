<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingController extends Controller
{
  public function saveName(Request $request)
  {
    $request->validate(['name' => 'nullable|string|max:255']);
    $request->user()->update(['name' => $request->name]);
    return redirect()->route('onboarding.index', ['step' => 2]);
  }

  public function savePicture(Request $request)
  {
    $request->validate(['profile_picture' => 'nullable|image|max:2048']);
    if ($request->hasFile('profile_picture')) {
      $path = $request->file('profile_picture')->store('avatars', 'public');
      $request->user()->update(['profile_picture' => $path]);
    }
    return redirect()->route('onboarding.index', ['step' => 3]);
  }

  public function savePhone(Request $request)
  {
    $request->validate(['phone' => 'nullable|string|max:20']);
    $request->user()->update(['phone' => $request->phone]);
    return redirect()->route('onboarding.index', ['step' => 4]);
  }

  public function saveCountry(Request $request)
  {
    $request->validate(['country' => 'nullable|string|size:2']);
    $request->user()->update(['country' => $request->country]);
    return redirect()->route('onboarding.index', ['step' => 5]);
  }

  public function saveBio(Request $request)
  {
    $request->validate(['bio' => 'nullable|string|max:1000']);
    $request->user()->update(['bio' => $request->bio]);
    return redirect()->route('account')->with('success', 'Votre profil a été complété avec succès !');
  }
}