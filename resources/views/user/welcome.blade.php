@extends('layouts.main')

@push('styles')
    <link href="{{ asset('css/modules/main.css') }}" rel="stylesheet">
@endpush

@section('content')

@auth
<h2>Bienvenue {{ Auth::user()->name }} {{ Auth::user()->lastname }}</h2>

@dump(Auth::user())

<a href={{ session()->get('url.intended', route('main.index')) }}>Retour au site</a>

@endauth

@endsection
