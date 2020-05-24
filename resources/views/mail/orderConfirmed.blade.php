@component('mail::message')
# Merci de votre commande {{ $user->name }} {{ $user->lastname }}
## Celle-ci est confirmée !
*Identifiant de la commande : {{ $order->id }}*

@if($order->shipping_type === 'store')
  Nous vous contacterons très rapidement pour vous dire quand vous pourrez venir la chercher au magasin.
  MythoShop - {{ $addresse->number }}, {{ $addresse->street }} {{ $addresse->postcode }} {{ $addresse->town }}
@else
  Vous la receverez très rapidement à l'adresse :<br>
  *{{ $addresse->number }}, {{ $addresse->street }} {{ $addresse->postcode }} {{ $addresse->town }}*
@endif

------------------------------------------

## Recapitulatif de la commande
@foreach ($products as $product)
- {{ $product->name }} - qté: {{ $product->pivot->quantity }} - prix unitaire: {{ round($product->pivot->current_price,2) }}€
@endforeach

**Montant HT**: {{ round($order->total_ht,2) }}€<br>
**TVA**: {{ round($order->taxes,2) }}€<br>
**Montant TTC**: {{ round($order->total_ttc,2) }}€

------------------------------------------

Merci et à bientôt !<br>
{{ config('app.name') }}
@endcomponent
