@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">

        <div class="col-md-5 col-md-offset-1 col-xs-2">
            <h4>Rechercher Classe</h4>
            {!! Form::open(['action' => ['ClassesController@index'], 'class' => 'form-inline', 'method' => 'GET']) !!}
            <div class="form-group mx-sm-3 mb-2">
                {{Form::text('search', '', ['id' => 'query', 'class' => 'form-control', 'placeholder' => 'Cherchez...'])}}
            </div>

            {{Form::submit('Recherchez', ['class' => 'btn btn-primary mb-2'])}}
            {!! Form::close() !!}
        </div>


            <div class="col-md-4 col-md-offset-2 col-xs-1" id="informations">
                <h4>Ajouter une classe</h4>
                {!! Form::open(['action' => ['ClassesController@store'], 'method' => 'POST', 'files' => 'true']) !!}
                @csrf
                {{Form::text('name', '', ['class' => 'field-form', 'placeholder' => 'Nom de la classe'])}}

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="choice" id="choice_lp" value="LP">
                    {{Form::label('choice', 'LP', ['id' => 'choice_lp', 'class' => 'form-check-label'])}}
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="choice" id="choice_lp" value="LG">
                    {{Form::label('choice', 'LG', ['id' => 'choice_lg', 'class' => 'form-check-label'])}}

                </div>
                <div>
                    {{Form::submit('Envoyer', ['class' => 'btn btn-primary'])}}
                    {{Form::reset('Annuler', ['class' => 'btn btn-secondary'])}}
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    <table class="table table-bordered">
        <thead class="thead thead-light">
            <tr>
                <th>Classe</th>
                <th>Établissement</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
        @foreach($list as $class)
            <tr>
                <td>{{$class->name}}</td>
                <td>{{$class->etablissement}}</td>
                @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                <td><a href="/classes/{{$class->id}}/edit" class="btn btn-info">Modifier</a>

                        {!! Form::open(['action' => ['ClassesController@destroy', $class->id], 'onsubmit' => 'return ConfirmDelete()']) !!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Supprimer', ['class' => 'btn btn-danger'])}}

                        {!! Form::close() !!}
                    </td>
                @endif

            </tr>
        @endforeach

        </tbody>
    </table>
{{$list->links()}}

    </div>

@endsection