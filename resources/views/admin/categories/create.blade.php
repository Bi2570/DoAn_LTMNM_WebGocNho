@extends('layouts.admin')
@section('title', 'Thêm loại sản phẩm')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Loại sản phẩm</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
@endsection
@section('content')
<h1 class="h3 mb-4">Thêm loại sản phẩm</h1>
@include('admin.categories._form')
@endsection