<form class="panel form-narrow" method="post" action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}">
    @csrf
    @if(isset($category)) @method('PUT') @endif
    
    <div class="mb-3">
        <label class="form-label" for="name">Tên loại</label>
        <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label" for="description">Mô tả</label>
        <textarea id="description" class="form-control" name="description" rows="4">{{ old('description', $category->description ?? '') }}</textarea>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-primary" type="submit">{{ isset($category) ? 'Cập nhật' : 'Lưu' }}</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.categories.index') }}">Hủy</a>
    </div>
</form>