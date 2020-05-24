@extends('layouts.main')

@push('styles')
    <link href="{{ asset('css/modules/user.css') }}" rel="stylesheet">
@endpush

@section('content')

<h2>Inscription</h2>

<section class="registration--container">
    {!! Form::open(['route' => 'register',
                                'method' => 'POST',
                                'class' => 'registration__form']) !!}
        <div class="lastname">
          <label class="mandatory ">Nom </label>
          {!! Form::text('lastname') !!}
          {!! $errors->first('lastname', '<small class="help-block">:message</small>') !!}
        </div>

        <div class="name">
          <label class="mandatory ">Prenom </label>
          {!! Form::text('name') !!}
          {!! $errors->first('name', '<small class="help-block">:message</small>') !!}
        </div>

        <div class="email">
          <label class="mandatory ">eMail </label>
          {!! Form::email('email') !!}
          {!! $errors->first('email', '<small class="help-block">:message</small>') !!}
        </div>

        <div class="password">
          <label class="mandatory ">Mot de passe </label>
          {!! Form::password('password') !!}
          {!! $errors->first('password', '<small class="help-block">:message</small>') !!}
        </div>

        <div class="password--Confirmation">
          <label class="mandatory ">Verification mot de passe </label>
          {!! Form::password('password_confirmation') !!}
          {!! $errors->first('password_confirmation', '<small class="help-block">:message</small>') !!}
        </div>

        <div class="phone">
          <label class="">Tel </label>
          {!! Form::tel('phone') !!}
          {!! $errors->first('phone', '<small class="help-block">:message</small>') !!}
        </div>

        <div class="birth">
          <label class="">Date de Naissance </label>
          {!! Form::date('birth') !!}
          {!! $errors->first('birth', '<small class="help-block">:message</small>') !!}
        </div>

        <div class="editSubmit">
          <a class="button" href={{ url()->previous() }}>Annuler</a>
          {!! Form::submit('Valider', ['name' => 'submit', 'class' => 'button']) !!}
        </div>
    {!! Form::close() !!}

</section>
@endsection
