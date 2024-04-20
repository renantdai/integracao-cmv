@extends('admin.layouts.app')

@section('title', "Id da camera $cam->id ")

@section('header')
<h1 class="text-lg text-black-500">id Camera {{ $cam->id }}</h1>
@endsection

@section('content')
<form action="{{ route('cams.update', $cam->id)}}" method="POST">
    @csrf
    @method('PUT')
    @include('admin.cams.partials.form', [
        'cam' => $cam
        ])
</form>
@endsection

