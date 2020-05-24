<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MythoShop') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <a class="skipToContent" href="#content" aria-label="Aller directement au contenu">Aller directement au contenu</a>
    <header>
        <div class="titles">
            <h1><a href="{{ route('main.index') }}">{{ config('app.name', 'MythoShop') }}</a></h1>
            <h2>Toutes vos créatures mythologiques livrées chez vous en 24h !</h2>
        </div>
        <div class="starSky">
            <div class="stars star"></div>
            <div class="stars2 star"></div>
            <div class="stars3 star"></div>
        </div>
    </header>
    <nav  class="navbar">
        <button class="burgerButton" aria-label="Menu button">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </button>
        <ul class="menu">
            <li class="home"><a class="homeIcon" href="{{ route('main.index') }}"></a></li>
            <li class="categories"><a class="dragonIcon" href="{{ route('categorie.index') }}"></a></li>

            <li class="cart">
                <a href="{{ route('cart.index') }}" class="cartIcon"></a>
                @if(\Cart::getTotalQuantity() > 0)
                    <p class="nbCartItems">{{ \Cart::getTotalQuantity() }}</p>
                @endif
            </li>

            @guest
            <li class="connexion button"><a href="{{ route('login') }}">Connexion</a></li>
            @endguest

            @auth
            <ul>
                <li class="connexion">
                    {!! Form::open(['route' => ['logout'],
                                'method' => 'POST',
                                'class' => 'user_login']) !!}
                    {!! Form::submit('Déconnexion', ['name' => 'logout', 'class' => 'button']) !!}
                    {!! Form::close() !!}
                </li>
            </ul>
            @endauth
        </ul>

        <ul class="side--navbar">
            @auth
                <li class="user_name">Bonjour {{ Auth::user()->name }}</li>
            @endauth
            <li><a class="" href="{{ route('main.index') }}">Accueil</a></li>
            <li><a href="{{ route('product.index') }}">Toutes nos Créatures</a></li>
            @if(!empty($navCategories))
                <ul class="categories">
                    <a class="" href="{{ route('categorie.index') }}">Catégories</a>
                    @foreach($navCategories as $categorie)
                        <li><a href="{{ route('categorie.show', $categorie->id) }}">{{ $categorie->name }}</a></li>
                    @endforeach
                </ul>
            @endif
            <li class="cart"><a href="{{ route('cart.index') }}">Panier {{ \Cart::getTotalQuantity() > 0 ? '('.\Cart::getTotalQuantity().')':'' }}</a></li>
            @guest
                <li class="connexion button"><a href="{{ route('login') }}">Connexion</a></li>
                <li class="connexion button"><a href={{ route('register')}}>Inscription</a></li>
            @endguest
            @auth
                <li class="connexion">
                        {!! Form::open(['route' => ['logout'],
                                    'method' => 'POST',
                                    'class' => 'user_login']) !!}
                        {!! Form::submit('Déconnexion', ['name' => 'logout', "class" => 'button']) !!}
                        {!! Form::close() !!}
                </li>
            @endauth
        </ul>
    </nav>


    @include('includes.flashsuccess')
    @include('includes.flasherror')

    <main id="content" class="container">



