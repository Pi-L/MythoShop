@extends('layouts.main')

@push('styles')
    <link href="{{ asset('css/modules/order.css') }}" rel="stylesheet">
@endpush

@push('scripts')
   <script src="https://checkout.stripe.com/checkout.js"></script>
@endpush

@section('content')
@auth

<h2>Paiement de la commande</h2>

<section class="order__checkout">

    <article class="order_checkout_products">
        <h3>Panier</h3>
        <div>
            <p>Nom</p><p>quantité</p><p>Total HT</p>
        </div>
        @foreach (\Cart::getContent()->sortBy('name') as $item)
            <div>
                <p>{{ $item->associatedModel->name }}</p>
                <p>{{ $item->quantity  }}</p>
                <p>{{ round($item->price * $item->quantity , 2) }} €</p>
            </div>
        @endforeach
    </article>

    <article class="order_checkout_infos">
        <div class="order_checkout_shipping">
            <h3>Livraison : {{ $order['shippingType'] }}</h3>
            <h4 class="addresse">Adresse</h4>

            @if($order['addresse_id'] === 1)
                <p>MythoShop</p>
            @else
                <p>{{ Auth::user()->name }} {{ Auth::user()->lastname }}</p>
            @endif

            <p>{{ $order['shippingAddresse']->number  }} {{ $order['shippingAddresse']->street }}</p>
            <p>{{ $order['shippingAddresse']->postcode  }} {{ $order['shippingAddresse']->town }}</p>
        </div>

        <div class="order_checkout_totals">
            <h3>Paiement</h3>
            <dl>
                <dt>Total HT :</dt>
                <dd>{{round(\Cart::getSubTotal(),2)}} €</dd>

                <dt>Dont frais d'envoi HT :</dt>
                <dd>{{ $order['shippingCost'] }} €</dd>

                <dt>TVA {{ $order['taxes'] }} :</dt>
                <dd>{{round((\Cart::getTotal()-\Cart::getSubTotal()),2) }} €</dd>

                <dt>Total TTC :</dt>
                <dd>{{round(\Cart::getTotal(),2)}} €</dd>
            </dl>
        </div>

        <form class="order__payment" action="{{route('order.confirmation', ['addresse_id' => $order['addresse_id']] )}}" method="POST">
            @csrf
            <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                data-key="{{env('STRIPE_PUBLIC_KEY')}}"
                data-amount={{round(\Cart::getTotal()*100,2)}}
                data-name="Paiement MythoShop"
                data-description="{{round(\Cart::getTotal(),2)}}€"
                data-image=""
                data-locale="fr"
                data-currency="eur"
                data-label="Payer la commande"
                data-email={{ Auth::user()->email }}>
            </script>
        </form>
    </article>

</section>

@endauth
@endsection
