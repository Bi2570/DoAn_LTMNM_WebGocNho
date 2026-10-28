@extends('layouts.shop')
@section('title', 'Sản phẩm')

@section('content')
<div class="container section">
    <nav aria-label="breadcrumb" class="crumbs"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('shop.home') }}">Trang chủ</a></li><li class="breadcrumb-item active" aria-current="page">Sản phẩm</li></ol></nav>
    <div class="d-flex justify-content-between align-items-baseline mb-3">
        <h1 class="h3 mb-0">Tất cả sản phẩm</h1>
        <p class="text-muted mb-0">Hiển thị {{ $products->total() }} sản phẩm</p>
    </div>

    <form method="get" action="{{ route('shop.products') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-4">
                <select name="category" class="form-select" onchange="this.form.submit()">
                    <option value="">Tất cả loại</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <select name="sort" class="form-select" onchange="this.form.submit()">
                    <option value="">Sắp xếp</option>
                    <option value="price_asc" @selected(request('sort') === 'price_asc')>Giá tăng dần</option>
                    <option value="price_desc" @selected(request('sort') === 'price_desc')>Giá giảm dần</option>
                </select>
            </div>
        </div>
    </form>

    <div class="row g-3">
        @forelse($products as $product)
            {{-- DÙNG INCLUDE Ở ĐÂY --}}
            @include('shop.partials.product-card', ['product' => $product])
        @empty
            <div class="empty"><h2 class="h5">Không tìm thấy sản phẩm</h2><p>Thử đổi từ khóa tìm kiếm.</p></div>
        @endforelse
    </div>

    <div class="mt-4">{{ $products->withQueryString()->links() }}</div>
</div>
@endsection