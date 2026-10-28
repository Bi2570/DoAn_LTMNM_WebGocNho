@extends('layouts.admin')
@section('title', 'Thêm sản phẩm')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
@endsection

@section('content')
<h1 class="h3 mb-4">Thêm sản phẩm</h1>

{{-- Gọi file partial ra và truyền biến categories --}}
@include('admin.products._form', ['categories' => $categories])

@endsection