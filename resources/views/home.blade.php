@extends('layouts.app')

@section('content')
    <div id="app" class="container">
        <handle-upload-component api_token="{{ auth()->user()->api_token }}"></handle-upload-component>
        <list-component api_token="{{ auth()->user()->api_token }}"></list-component>
    </div>
@endsection
