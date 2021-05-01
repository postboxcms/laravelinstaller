@extends('laravelinstaller::master')

@section('content')
<div class="user app-details">
    {{-- <form method="post" action="{{url('install/save/application')}}" class="user push-form"> --}}
        {{-- <hr/> --}}
        @csrf
        <div class="row">
        <div class="col-md-12">
            <div class="form-group">
            <input value="{{$app['title']}}" required type="text" name="title" class="form-control form-control-user @error('title') is-invalid @enderror" id="title" aria-describedby="title" placeholder="Add a title for your app. E.g '{{env('APP_NAME')}}'">
            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
        </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <div class="form-group">
            <input value="{{$app['description']}}" type="text" name="description" class="form-control form-control-user @error('description') is-invalid @enderror" id="description" aria-describedby="description" placeholder="Add a description for your app">
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
        </div>
        </div>
        <div class="row">
        <div class="col-md-12">
            <div class="form-group">
            <input value="{{$app['keywords']}}" type="text" name="keywords" class="form-control form-control-user @error('keywords') is-invalid @enderror" id="keywords" aria-describedby="keywords" placeholder="Add some keywords which describe your app">
            @error('keywords')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
            </div>
        </div>
        </div>
    {{-- </form> --}}
</div>
@stop
