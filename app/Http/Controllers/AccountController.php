<?php

namespace App\Http\Controllers;

class AccountController extends Controller
{
  public function index()
  {
    $listings = auth()->user()->listings()->latest()->get();

    return view('account.index', compact('listings'));
  }
}