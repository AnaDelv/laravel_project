@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-1 col-xs-2">
                <!--Rechercher logiciel-->
                <form class="form-inline">
                {!! Form::open(['action' => ['FilesController@index'], 'method' => 'GET']) !!}
                @csrf
                <div class="form-group mx-sm-3 mb-2">
                    {{Form::text('search', '', ['id' => 'file', 'class' => 'form-control', 'placeholder' => 'Rechercher un logiciel...'])}}
                </div>
                {{Form::submit('Rechercher', ['class' => 'btn btn-primary mb-2'])}}
                {!! Form::close() !!}
                </form>
            </div>

            @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())

                <div class="col-md-6 col-xs-2">
                <!--Ajouter logiciel-->
                    {!! Form::open(['action' => ['FilesController@store'], 'method' => 'POST', 'files' => 'true']) !!}
                    @csrf
                    <div class="input-group">
                        <div class="custom-file">
                            {{Form::file('file', ['id' => 'inputGroupFile04', 'class' => 'custom-file-input'])}}
                            {{Form::label('inputGroupFile04', 'Upload', ['class' => 'custom-file-label'])}}
                        </div>
                        <div class="input-group-append">
                            {{Form::submit('Ajouter', ['class' => 'btn btn-outline-secondary'])}}
                            {{Form::reset('Annuler', ['class' => 'btn btn-outline-secondary'])}}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            @endif
        </div>


        <table class="table table-bordered">
            <thead class="thead-light">
            <tr>
                <th>Nom du fichier</th>
                <th>Téléchargement</th>
                @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                    <th>Action</th>
                @endif

            </tr>
            </thead>
            <tbody>

            @if(count($files) == 0)
                <tr>
                    <td colspan="{{Auth::user()->isSuperAdmin() || Auth::user()->isAdmin() ? '3' : '2'}}" align="center">Aucun résultat</td>
                </tr>
            @else
                @foreach($files as $file)
                    <tr>
                        <td>{{$file->name}}</td>
                        <td><a href="{{$file->file_url}}"><input type="submit" class="btn btn-success" value="Lien"></a></td>
                        @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())
                            <td>
                                {!! Form::open(['action' => ['FilesController@destroy', $file->id], 'onsubmit' => 'return ConfirmDelete()']) !!}
                                {{Form::hidden('_method', 'DELETE')}}
                                {{Form::submit('Supprimer', ['class' => 'btn btn-danger'])}}

                                {!! Form::close() !!}
                            </td>
                        @endif
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
        {{$files->appends(Request::only('search'))->links()}}
    @if(Auth::user()->isSuperAdmin() || Auth::user()->isAdmin())

            <a href="../files/delete" onclick="return confirm('Voulez-vous supprimer cet élément de la liste ?')">
                <input type="submit" class="btn btn-danger" value="Supprimer tous les logiciels">
            </a>
    @endif
    </div>
@endsection

