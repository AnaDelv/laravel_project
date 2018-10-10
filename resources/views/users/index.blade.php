@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-1 col-xs-2">
                <h4>Rechercher Utilisateur</h4>
                {!! Form::open(['action' => ['UsersController@index'], 'class' => 'form-inline', 'method' => 'GET']) !!}
                <div class="form-group mx-sm-3 mb-2">
                    {{Form::text('search', '', ['id' => 'query', 'class' => 'form-control', 'placeholder' => 'Cherchez...'])}}
                    {{Form::select('choice',  ['name' => 'par nom/prénom', 'class' => 'par classe'], NULL, ['id' => 'class_form', 'class' => 'form-control'])}}
                </div>

                {{Form::submit('Recherchez', ['class' => 'btn btn-primary mb-2'])}}
                {!! Form::close() !!}
            </div>

            <div class="col-md-6 col-xs-2">

                <h4>Ajout d'utilisateurs par fichier CSV</h4>

                {!! Form::open(['action' => ['UsersController@csvUpload'], 'method' => 'POST', 'files' => 'true']) !!}
                @csrf                    <div class="input-group">
                    <div class="custom-file">
                        {{Form::file('csv_file', ['id' => 'csvfile', 'class' => 'custom-file-input'])}}
                        {{Form::label('csvfile', 'Upload', ['class' => 'custom-file-label'])}}
                    </div>
                    <div class="input-group-append">
                        <input class="btn btn-outline-secondary" type="submit"  value="Ajouter">
                        <input class="btn btn-outline-secondary" type="reset" value="Annuler">
                    </div>
                </div>
                {!! Form::close() !!}

            </div>


        </div>

        <table class="table table-bordered">
            <thead class="thead-light">
            <tr>
                <th>Classe</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Identifiant</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>

            @if(count($users) == 0)
                <tr>
                    <td colspan="6" align="center">Aucun résultat</td>
                </tr>
            @else
            @foreach($users as $user)
                @if($user->role != 'super_admin' || $user->role != 'admin')
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->lastname}}</td>
                        <td>{{$user->firstname}}</td>
                        <td>{{$user->username}}</td>
                        <td>{{$user->email}}</td>
                        <td><a href="/users/{{$user->id}}/edit"><input type="submit" class="btn btn-info" value="Modifier"></a>
                            {!! Form::open(['action' => ['UsersController@destroy', $user->id], 'onsubmit' => 'return ConfirmDelete()']) !!}
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::submit('Supprimer', ['class' => 'btn btn-danger'])}}

                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endif

            @endforeach
        @endif
            </tbody>
        </table>
        {{$users->appends(Request::only(['search', 'choice']))->links()}}


        <a href="../users/delete" onclick="return confirm('Voulez-vous supprimer tous les utilisateurs ?')">
            <input type="submit" class="btn btn-danger" value="Supprimer tous les utilisateurs">
        </a>
    </div>

@endsection