@extends('layouts.admin')
@section('title', 'Sản phẩm')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Sản phẩm</li>
@endsection

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <h1 class="h3 mb-0">Sản phẩm</h1>
    <a class="btn btn-primary" href="{{ route('admin.products.create') }}"><i class="bi bi-plus-lg"></i> Thêm sản phẩm</a>
</div>

<section class="panel">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th scope="col">Sản phẩm</th>
                    <th scope="col">Loại</th>
                    <th scope="col">Giá bán</th>
                    <th scope="col">Tồn kho</th>
                    <th scope="col" class="text-end">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <span class="ph ph-1 ph-sm"><i class="bi bi-box"></i></span>
                                <span class="fw-semibold">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td>{{ $product->category->name }}</td>
                        <td class="text-nowrap">{{ number_format($product->price) }} ₫</td>
                        <td>
                            @if($product->stock > 5)
                                {{ $product->stock }}
                            @elseif($product->stock > 0)
                                <span class="text-warning fw-semibold">Còn {{ $product->stock }}</span>
                            @else
                                <span class="text-danger fw-semibold">Hết hàng</span>
                            @endif
                        </td>
                        <td class="text-end text-nowrap">
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.products.edit', $product->id) }}"><i class="bi bi-pencil-square"></i> Sửa</a>
                            <form class="d-inline" method="post" action="{{ route('admin.products.destroy', $product->id) }}" onsubmit="return confirm('Xóa sản phẩm này?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit"><i class="bi bi-trash3"></i> Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Chưa có sản phẩm nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $products->links() }}</div>
</section>
@endsection