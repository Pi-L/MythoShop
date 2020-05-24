@extends('layouts.main')

@push('styles')
    <link href="{{ asset('css/modules/user.css') }}" rel="stylesheet">
@endpush

@section('content')
@auth

    <h2>Nouvelle Adresse</h2>

    <section class="user__createAddresse">

    {!! Form::open(['route' => 'user.storeAddresse',
                                'method' => 'POST',
                                'class' => 'createAddresse__form']) !!}
        <div class="name">
            <label>Nom pour cette adresse (exemple: Maison): </label>
            {!! Form::text('name') !!}
            {!! $errors->first('name', '<small class="help-block">:message</small>') !!}
        </div>

        <div class="number">
            <label class="mandatory">Num : </label>
            {!! Form::text('number') !!}
            {!! $errors->first('number', '<small class="help-block">:message</small>') !!}
        </div>

        <div class="street">
            <label class="mandatory">Rue : </label>
            {!! Form::text('street') !!}
            {!! $errors->first('street', '<small class="help-block">:message</small>') !!}
        </div>

        <div class="postcode">
            <label class="mandatory">Code Postal: </label>
            {!! Form::text('postcode') !!}
            {!! $errors->first('postcode', '<small class="help-block">:message</small>') !!}
        </div>

        <div class="town">
            <label  class="mandatory">Ville : </label>
            {!! Form::text('town') !!}
            {!! $errors->first('town', '<small class="help-block">:message</small>') !!}
        </div>

            {!! Form::submit('Valider', ['name' => 'submit', 'class' => ['button', 'submit']]) !!}

    {!! Form::close() !!}

</section>

@endauth
@endsection
