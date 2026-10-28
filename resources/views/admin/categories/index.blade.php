@extends('layouts.admin')
@section('title', 'Loại sản phẩm')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Loại sản phẩm</li>
@endsection

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <h1 class="h3 mb-0">Loại sản phẩm</h1>
    <a class="btn btn-primary" href="{{ route('admin.categories.create') }}"><i class="bi bi-plus-lg"></i> Thêm loại sản phẩm</a>
</div>

<section class="panel">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th scope="col">Tên loại</th>
                    <th scope="col">Mô tả</th>
                    <th scope="col">Số sản phẩm</th>
                    <th scope="col" class="text-end">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="fw-semibold">{{ $category->name }}</td>
                        <td class="text-muted">{{ $category->description ?? 'Không có mô tả' }}</td>
                        <td>{{ $category->products->count() }}</td>
                        <td class="text-end text-nowrap">
                            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.categories.edit', $category->id) }}">
                                <i class="bi bi-pencil-square"></i> Sửa
                            </a>
                            <form class="d-inline" method="post" action="{{ route('admin.categories.destroy', $category->id) }}" onsubmit="return confirm('Bạn có chắc muốn xóa loại này?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" type="submit"><i class="bi bi-trash3"></i> Xóa</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-4">Chưa có loại sản phẩm nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $categories->links() }}</div>
</section>
@endsection