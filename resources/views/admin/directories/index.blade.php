@extends('admin.layouts.app')

@section('title', 'Index')

@section('header')
@include('admin.directories.partials.header', compact('directories'))
@endsection

@section('content')
@include('admin.directories.partials.content')

<x-pagination :paginator="$directories" :appends="$filters" />

@endsection

<x-alert />
