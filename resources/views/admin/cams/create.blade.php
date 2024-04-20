@extends('admin.layouts.app')

@section('title', 'Criar Novo Tópico')

@section('header')
<h1 class="text-lg text-black-500">Nova Camera</h1>
@endsection

@section('content')
<form action="{{ route('cams.store')}}" method="POST">
    @include('admin.cams.partials.form')
</form>
@endsection
