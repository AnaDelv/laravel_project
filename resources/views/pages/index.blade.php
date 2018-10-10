@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-6 col-xs-1">
                <div id="intra_slider">
                    <div id="intra_slides">
                        @foreach($news as $info)
                            <div id="intra_slide">
                            <span id="date_slide">
                                {{date('d/m/Y', $info->date) . ' -- INFO: '.$info->title}}</span>
                                <p>{!! nl2br(stripslashes($info->text)) !!}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="image_partenaire" class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-1 col-xs-1">
                <img src="#"  width="277px" height="182px"/>
            </div>
            <div class="col-lg-3 col-md-1 col-xs-1">
                <img src="#"  width="277px" height="182px" />
            </div>
            <div class="col-lg-3 col-md-1 col-xs-1">
                <img src="#"  width="277px" height="182px" />
            </div>
            <div class="col-lg-3 col-md-1 col-xs-1">
                <img src="#"  width="277px" height="182px" />
            </div>
        </div>
    </div>


@endsection