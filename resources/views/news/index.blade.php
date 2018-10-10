@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="col-md-5 col-md-offset-1 col-xs-2">
            <h4>Rechercher une information</h4>
            {!! Form::open(['action' => ['NewsController@index'], 'class' => 'form-inline', 'method' => 'GET']) !!}
            <div class="form-group mx-sm-3 mb-2">
                {{Form::text('search', '', ['id' => 'query', 'class' => 'form-control', 'placeholder' => 'Cherchez...'])}}
            </div>

            {{Form::submit('Recherchez', ['class' => 'btn btn-primary mb-2'])}}
            {!! Form::close() !!}
        </div>

    <table class="table table-bordered">
        <thead class="thead-light">
        <tr>
            <th>Date</th>
            <th>Titre</th>
            <th>Texte</th>
            <th>Établissement</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>



        @if(count($news) > 0)

            @foreach($news as $info)

                <tr>
                    <td>{{date('d/m/Y', $info->date)}}</td>
                    <td>{{$info->title}}</td>
                    <td>{!! nl2br(stripslashes($info->text)) !!}</td>
                    <td>{{$info->etablissement}}</td>
                    <td><a href="/news/{{$info->id}}/edit" class="btn btn-info">Modifier</a>
                        {!! Form::open(['action' => ['NewsController@destroy', $info->id], 'method' => 'pull-right', 'onsubmit' => 'return ConfirmDelete()']) !!}
                        {{Form::hidden('_method', 'DELETE')}}
                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}

                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        @else
            <td colspan="4" align="center">Aucun résultat</td>
        @endif
        </tbody>
    </table>
    {{$news->links()}}
    </div>
@endsection