@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-2 col-xs-1" id="informations">
                <a href="/news" class="btn btn-secondary btn-md btn-block">Voir la liste des informations</a>
                {!! Form::open(['action' => ['NewsController@update', $news->id], 'method' => 'POST']) !!}
                @csrf
                <div class="form-group">
                    {{Form::label('title', 'Title')}}
                    {{Form::text('title', $news->title, ['class' => 'form-control', 'id' => 'titre_information', 'placeholder' => 'Text'])}}
                </div>
                <div class="form-group">
                    {{Form::label('text', 'Text')}}
                    {{Form::textarea('text', $news->text, ['class' => 'form-control', 'id' => 'summernote', 'placeholder' => 'Text'])}}
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="choice" id="choice_nd" value="ND" {{$news->etablissement == 'ND' ? ' checked' : ''}}>
                    {{Form::label('choice', 'ND', ['id' => 'choice_nd', 'class' => 'form-check-label'])}}
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="choice" id="choice_lp" value="LP" {{$news->etablissement == 'LP' ? ' checked' : ''}}>
                    {{Form::label('choice', 'LP', ['id' => 'choice_lp', 'class' => 'form-check-label'])}}

                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="choice" id="choice_lp" value="LG" {{$news->etablissement == 'LG' ? ' checked' : ''}}>
                    {{Form::label('choice', 'LG', ['id' => 'choice_lg', 'class' => 'form-check-label'])}}
                </div>
                <div>
                    {{Form::submit('Send', ['class' => 'btn btn-primary'])}}
                    {{Form::reset('Cancel', ['class' => 'btn btn-secondary'])}}
                    {{Form::hidden('_method', 'PUT')}}
                </div>
                {!! Form::close() !!}
            </div>

        </div>
    </div>

@endsection