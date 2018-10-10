@extends('layouts.app')

@section('content')
    <div id="login-box">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">{{ __('Connexion') }}</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="form-group row">
                                    <label for="username" class="col-sm-4 col-form-label text-md-right">{{ __('Identifiant') }}</label>

                                    <div class="col-md-6">
                                        <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                                        @if ($errors->has('username'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit"  class="btn btn-lg btn-primary btn-block" id="connexion_button">
                                            {{ __('Login') }}
                                        </button>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div id="google">
                        <img src="{{ asset('img/logo-google.png') }}" alt="">
                        <a class="nav-link" href="https://www.google.com/fr" target="_blank">Accéder à Google >>></a>
                    </div>

                </div>


            </div>

        </div>
    </div>
@endsection
