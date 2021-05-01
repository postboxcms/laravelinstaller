@extends('laravelinstaller::master')

@section('content')
    <div class="user health-check">
        <div class="row mb-4">
            @foreach ($specs as $property)
                <div class="col-md-6 col-sm-12 col-xs-12 col-xl-6 col-lg-12">
                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-xs-2">
                            <span class="btn {{$property['bulletColorClass']}} btn-circle btn-sm">
                                <i class="fas {{$property['bulletClass']}}"></i>
                            </span>
                        </div>
                        <div class="col-md-10 col-sm-10 col-xs-10 text-left">
                            <h3>{{$property['label']}} {{$property['value']}}</h3>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop
