@extends('admin.layouts.app')

@section('title', "Camera identificada de número { $cam->id }")

@section('header')
<h1 class="text-lg text-black-500">Dúvida {{ $cam->id }}</h1>
@endsection

@section('content')
<ul>
    <li>Assunto: {{ $cam->id }}</li>
    <li>Status: {{ $cam->tpMan }}</li>
    <li>Descrição: {{ $cam->cEQP }}</li>
</ul>

<form action="{{ route('cams.destroy', $cam->id)}}" method="POST">
    @csrf()
    @method('DELETE')
    <button type="submit">Deletar</button>
</form>
@endsection
