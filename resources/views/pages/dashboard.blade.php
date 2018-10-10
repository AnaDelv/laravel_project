@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-xs-1" id="informations">
                <h4>Publier une information</h4>
                {!! Form::open(['action' => ['NewsController@store'], 'method' => 'POST']) !!}
                <div class="form-group">
                    {{Form::label('title', 'Titre')}}
                    {{Form::text('title', '', ['class' => 'form-control', 'id' => 'titre_information', 'placeholder' => 'Titre'])}}
                </div>
                <div class="form-group">
                    {{Form::label('text', 'Texte')}}
                    {{Form::textarea('text', '', ['class' => 'form-control', 'id' => 'summernote', 'placeholder' => 'Texte', 'maxlength' => '100'])}}
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="choice" id="choice_nd" value="ND">
                    <label class="form-check-label" for="choice_nd" id="choice_nd">ND</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="choice" id="choice_lp" value="LP">
                    <label class="form-check-label" for="choice_lp" id="choice_lp">LP</label>

                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="choice" id="choice_lg" value="LG">
                    <label class="form-check-label" for="choice_lg" id="choice_lg">LG</label>
                </div>
                <div>
                    {{Form::submit('Publier', ['class' => 'btn btn-primary btn-sm'])}}
                    {{Form::reset('Annuler', ['class' => 'btn btn-secondary btn-sm'])}}
                </div>
                {!! Form::close() !!}
            </div>

            

            <div class="col-md-6 col-xs-1" id="users">
                @if(Auth::user()->isSuperAdmin())
                <h4>Ajouter un utilisateur</h4>
                {!! Form::open(['action' => ['UsersController@store'], 'method' => 'POST']) !!}
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        {{Form::label('lastname_form', 'Nom')}}
                        {{Form::text('lastname', '', ['id' => 'lastname_form', 'class' => 'field-form', 'placeholder' => 'Nom'])}}
                    </div>
                    <div class="form-group col-md-6">
                        {{Form::label('firstname_form', 'Prénom')}}
                        {{Form::text('firstname', '', ['id' => 'firstname_form', 'class' => 'field-form', 'placeholder' => 'Prénom'])}}
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        {{Form::label('pass_form', 'Mot de passe')}}
                        {{Form::password('password', ['id' => 'pass_form', 'class' => 'field-form', 'placeholder' => 'Mot de passe'])}}
                    </div>
                    <div class="form-group col-md-6">
                        {{Form::label('confpass_form', 'Confirmer mot de passe')}}
                        {{Form::password('confirm_password', ['id' => 'confpass_form', 'class' => 'field-form', 'placeholder' => 'Mot de passe'])}}
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        {{Form::label('username_form', 'Identifiant')}}
                        {{Form::text('username', '', ['id' => 'username_form', 'class' => 'field-form', 'placeholder' => 'Identifiant'])}}
                    </div>


                    <div class="form-group col-md-6">
                        {{Form::label('class_form', 'Classe')}}
                        <select name="class" id="class_form" class="field-form">
                            <option value="class" selected disabled="">Liste des classes</option>

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
                </div>
                <div>
                    {{Form::checkbox('role', 'admin')}}
                    {{Form::label('role', 'Admin', ['id' => 'role', 'class' => 'form-check-label'])}}
                </div>
                <div>
                    {{Form::submit('Ajouter', ['class' => 'btn btn-primary'])}}
                    {{Form::reset('Annuler', ['class' => 'btn btn-secondary'])}}
                </div>
                {!! Form::close() !!}
                @else
                    <img src="#" size="100px" alt="Logo" title="Logo" id="image_logo">
                @endif
            </div>

            <div class="col-md-12 col-xs-1">

                <div class="btn-group btn-group-lg">
                    <a href="/news" class="btn btn-outline-secondary btn-md btn-block" id="redirection_news">Voir la liste des informations</a>
                </div>
                @if(Auth::user()->isSuperAdmin())
                <div class="btn-group btn-group-lg">
                    <a href="/users" class="btn  btn-outline-secondary btn-md btn-block" id="redirection_user">Voir les utilisateurs</a>
                </div>

                <div class="btn-group btn-group-lg">
                    <a href="/password/reset" class="btn btn-outline-danger">Changer le mot de passe</a>
                </div>
                <div class="btn-group btn-group-lg">
                    <a href="/classes" class="btn btn-outline-danger">Changer la liste des classes</a>
                </div>
                @endif
            </div>
        </div>
    </div>

@endsection