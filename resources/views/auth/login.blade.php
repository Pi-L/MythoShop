@extends('layouts.main')

@push('styles')
    <link href="{{ asset('css/modules/user.css') }}" rel="stylesheet">
@endpush

@section('content')

  <h2>Connexion</h2>

  <section class="login--container">

    {!! Form::open(['route' => 'login',
                                  'method' => 'POST',
                                  'class' => 'login--form']) !!}

      <label class="mandatory">eMail </label>
      {!! Form::email('email') !!}
      {!! $errors->first('email', '<small class="help-block">:message</small>') !!}

      <label class="mandatory">Mot de passe </label>
      {!! Form::password('password') !!}
      {!! $errors->first('password', '<small class="help-block">:message</small>') !!}

      {!! Form::submit('Se connecter', ['name' => 'submit', 'class' => 'button']) !!}

    {!! Form::close() !!}

    <div class="noAccount">
        <h3>Pas encore de compte ?</h3>
        <p>Inscrivez-vous en quelques clics !</p>

        <a class="button" href={{ route('register')}}>Inscription</a>

    </div>

  </section>
@endsection
