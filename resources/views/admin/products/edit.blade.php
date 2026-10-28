@extends('layouts.admin')
@section('title', 'Sửa sản phẩm')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Sản phẩm</a></li>
    <li class="breadcrumb-item active" aria-current="page">Sửa</li>
@endsection

@section('content')
<h1 class="h3 mb-4">Sửa sản phẩm: {{ $product->name }}</h1>

{{-- Gọi file partial ra, truyền cả biến categories và biến product --}}
@include('admin.products._form', ['categories' => $categories, 'product' => $product])

@endsection