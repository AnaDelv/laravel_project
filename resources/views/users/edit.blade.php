@extends('layouts.app')

@section('content')
    <h1>Modifier utilisateur</h1>

    <div class="container">
        <div class="row">

            <div class="col-md-6 col-xs-1" id="users">
                <a href="/users" class="btn btn-secondary btn-md btn-block">Retour vers la liste utilisateurs</a>

                {!! Form::open(['action' => ['UsersController@update', $user->id], 'method' => 'POST']) !!}
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        {{Form::label('lastname_form', 'Nom')}}
                        {{Form::text('lastname', $user->lastname, ['id' => 'lastname_form', 'class' => 'field-form', 'placeholder' => 'Nom'])}}
                    </div>
                    <div class="form-group col-md-6">
                        {{Form::label('firstname_form', 'Prénom')}}
                        {{Form::text('firstname', $user->firstname, ['id' => 'firstname_form', 'class' => 'field-form', 'placeholder' => 'Prénom'])}}
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        {{Form::label('pass_form', 'Nouveau mot de passe')}}
                        {{Form::password('password', ['id' => 'pass_form', 'class' => 'field-form', 'placeholder' => 'Mot de passe'])}}
                    </div>
                    <div class="form-group col-md-6">
                        {{Form::label('confpass_form', 'Confirmez le mot de passe')}}
                        {{Form::password('confirm_password', ['id' => 'confpass_form', 'class' => 'field-form', 'placeholder' => 'Confirmer le mot de passe'])}}
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        {{Form::label('username_form', 'Identifiant')}}
                        {{Form::text('username', $user->username, ['id' => 'username_form', 'class' => 'field-form', 'placeholder' => 'Identifiant'])}}
                    </div>
                    <div class="form-group col-md-6">
                        {{Form::label('class_form', 'Class')}}
                        <select name="class" id="class_form" class="field-form">
                            <option value="class" selected disabled="">Choisir une classe</option>

                            <optgroup label="LP">
                                @foreach($list_lp as $list)
                                    <option value="{{$list->name}}">{{$list->name}}</option>
                                @endforeach
                            </optgroup>
                            <optgroup label="LG">

                                @foreach($list_lg as $list)
                                    <option value="{{$list->name}}">{{$list->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>
                    <div>
                        {{Form::checkbox('role', 'admin')}}
                        {{Form::label('role', 'Admin', ['id' => 'role', 'class' => 'form-check-label'])}}
                    </div>
                </div>
                    <div>
                        {{Form::submit('Modifier', ['class' => 'btn btn-primary'])}}
                        {{Form::reset('Annuler', ['class' => 'btn btn-secondary'])}}
                        {{Form::hidden('_method', 'PUT')}}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
@endsection