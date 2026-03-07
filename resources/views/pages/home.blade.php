@extends('layouts.app')

@section('content')
  <main>@include('pages.inc.hero')</main>
@endsection

@push('styles')
<style>
  main {
    padding: 1rem;
  }
</style>