@extends('admin.layouts.app')

@section('title', 'Index')

@section('header')
@include('admin.cams.partials.header', compact('cams'))
@endsection

@section('content')
@include('admin.cams.partials.content')

<x-pagination :paginator="$cams" :appends="$filters" />

@endsection

<x-alert />
