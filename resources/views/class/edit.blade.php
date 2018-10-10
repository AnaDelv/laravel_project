@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-2 col-xs-1" id="informations">
                <a href="/classes" class="btn btn-secondary btn-md btn-block">Retour vers la liste des classes</a>
                {!! Form::open(['action' => ['ClassesController@update', $class->id], 'method' => 'POST']) !!}
                @csrf
                <div class="form-group">
                    {{Form::label('name', 'Nom de la classe')}}
                    {{Form::text('name', $class->name, ['class' => 'field-form'])}}
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="choice" id="choice_lp" value="LP" {{$class->etablissement == 'LP' ? ' checked' : ''}}>
                    {{Form::label('choice', 'LP', ['id' => 'choice_lp', 'class' => 'form-check-label'])}}
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="choice" id="choice_lp" value="LG" {{$class->etablissement == 'LG' ? ' checked' : ''}}>
                    {{Form::label('choice', 'LG', ['id' => 'choice_lg', 'class' => 'form-check-label'])}}

                </div>

                <div>
                    {{Form::submit('Envoyer', ['class' => 'btn btn-primary'])}}
                    {{Form::reset('Annuler', ['class' => 'btn btn-secondary'])}}
                    {{Form::hidden('_method', 'PUT')}}
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>




@endsection

