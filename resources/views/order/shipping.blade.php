@extends('layouts.main')

@push('styles')
    <link href="{{ asset('css/modules/order.css') }}" rel="stylesheet">
@endpush

@section('content')
@auth

    <h2>Adresse de livraison</h2>

    <section class="order__shipping">

    {!! Form::open(['route' => 'order.storeAddresse',
                                'method' => 'POST',
                                'class' => 'shipping__form']) !!}


        <fieldset class="address__choice">
            <legend> A quelle adresse souhaitez-vous être livré ? </legend>

            @if (Auth::user()->addresses->count() > 0)

                <label for="store">Choisissez une de vos adresses</label>
                <select name="addresseChoice">
                @foreach (Auth::user()->addresses as $addresse)

                    <option value={{ $addresse->id }}>
                        {{ $addresse->pivot->name ? $addresse->pivot->name.' -':'' }} {{ $addresse->number }}, {{ $addresse->street }} {{ $addresse->postcode }} {{ $addresse->town }}
                    </option>

                @endforeach
                </select>

                <p class="or">Ou alors,</p>

            @else
                <p class="noAddresse">Vous n'avez pas encore d'adresse enregistrée</p>
            @endif


            <a class="button newAddresse" href={{ route('user.createAddresse') }}>Saisir une nouvelle adresse</a>

            @if (Auth::user()->addresses->count() > 0)
                {!! Form::submit('Valider', ['name' => 'submit', 'class' => ['button', 'validate']]) !!}
            @endif
        </fieldset>





    {!! Form::close() !!}

</section>

@endauth
@endsection
