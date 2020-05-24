@extends('layouts.main')

@push('styles')
    <link href="{{ asset('css/modules/cart.css') }}" rel="stylesheet">
@endpush

@section('content')

    <h2>Votre panier</h2>

    <section class="cart__container">
        @if (\Cart::getTotalQuantity() > 0)
            @foreach (\Cart::getContent()->sortBy('name') as $item)
                @include('cart.includes.cartItem', ['item' => $item])
            @endforeach

            {!! Form::open(['route' => 'cart.updateShippingChoice',
                                    'method' => 'POST',
                                    'class' => 'cart__shipping']) !!}
                <fieldset class="shipping__choice">
                    <legend>Choisissez un type de Livraison</legend>

                    <div>
                        <input id="colissimo" type="radio" name="shipping__choice" value="colissimo"
                            {{ $shippingChoice ==='colissimo' ? 'checked' : '' }} />
                        <label for="colissimo">Envoi en Colissimo</label>
                    </div>
                    <div>
                        <input id="store" type="radio" name="shipping__choice" value="store"
                            {{ $shippingChoice ==='store' ? 'checked' : '' }}/>
                        <label for="store">Retrait au magasin</label>
                    </div>
                    <div class="shippingSubmit">
                        {!! Form::submit('Valider', ['name' => 'submit', 'class' => 'button']) !!}
                    </div>
                </fieldset>

                <h2 class="shippingCost">Frais de port (HT) : {{round($shippingCost, 2)}} €</h2>

                <h2 class="subtotal">Sous-Total (HT) : {{round(\Cart::getSubTotal(),2)}} €</h2>

            {!! Form::close() !!}



            <a href={{ route('order.shipping') }} class="cartValidation">Valider le Panier</a>

        @else
            <h2>Le panier est vide</h2>
        @endif
    </section>

@endsection
