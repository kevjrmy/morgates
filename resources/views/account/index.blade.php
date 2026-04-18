@extends('layouts.account')

@section('title', 'Mon espace — Morgates')

@section('content')
  <main id="account-page">
    <p>Bonjour {{ auth()->user()->name }} !</p>
  </main>
@endsection