<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListingController extends Controller
{
  private int $totalSteps = 6;

  public function create(Request $request)
  {
    $step = (int) $request->query('step', 1);
    $step = max(1, min($step, $this->totalSteps));

    $view = match($step) {
      1 => 'account.create.step-1-type',
      2 => 'account.create.step-2-location',
      3 => 'account.create.step-3-basics',
      4 => 'account.create.step-4-details',
      5 => 'account.create.step-5-description',
      6 => 'account.create.step-6-photos',
    };

    return view($view, [
      'step'       => $step,
      'totalSteps' => $this->totalSteps,
      'listing'    => null, // placeholder until controller is wired
    ]);
  }

  public function storeType(Request $request)
  {
    return redirect()->route('listings.create.index', ['step' => 2]);
  }

  public function storeLocation(Request $request)
  {
    return redirect()->route('listings.create.index', ['step' => 3]);
  }

  public function storeBasics(Request $request)
  {
    return redirect()->route('listings.create.index', ['step' => 4]);
  }

  public function storeDetails(Request $request)
  {
    return redirect()->route('listings.create.index', ['step' => 5]);
  }

  public function storeDescription(Request $request)
  {
    return redirect()->route('listings.create.index', ['step' => 6]);
  }

  public function storePhotos(Request $request)
  {
    return redirect()->route('account')->with('success', 'Annonce créée avec succès !');
  }
}