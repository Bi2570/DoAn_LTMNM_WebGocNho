@extends('layouts.admin')
@section('title', 'Sửa loại sản phẩm')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Loại sản phẩm</a></li>
    <li class="breadcrumb-item active" aria-current="page">Sửa</li>
@endsection
@section('content')
<h1 class="h3 mb-4">Sửa loại sản phẩm: {{ $category->name }}</h1>
@include('admin.categories._form', ['category' => $category])
@endsection