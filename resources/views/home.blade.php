@extends('layouts.app')

@section('css')
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet" />
@stop

@section('content')
    <div id="app">  
        <app></app>
    </div>

    <script src="/js/app.js"></script>
@stop