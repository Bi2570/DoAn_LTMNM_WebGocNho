<form method="post" action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf
    @if(isset($product))
        @method('PUT')
    @endif
    
    <div class="row g-4">
        <div class="col-lg-8">
            <section class="panel">
                <h2 class="h5 mb-3">Thông tin chung</h2>
                <div class="mb-3">
                    <label class="form-label">Tên sản phẩm</label>
                    <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Loại sản phẩm</label>
                        <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" required>
                            <option value="">-- Chọn loại --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id ?? '') == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Số lượng tồn kho</label>
                        <input class="form-control" type="number" name="stock" min="0" value="{{ old('stock', $product->stock ?? 0) }}" required>
                    </div>
                </div>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Giá bán</label>
                        <div class="input-group">
                            <input class="form-control @error('price') is-invalid @enderror" type="number" name="price" min="0" value="{{ old('price', $product->price ?? '') }}" required>
                            <span class="input-group-text">₫</span>
                        </div>
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Giá gốc (Nếu giảm giá)</label>
                        <div class="input-group">
                            <input class="form-control" type="number" name="old_price" min="0" value="{{ old('old_price', $product->old_price ?? '') }}">
                            <span class="input-group-text">₫</span>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="form-label">Mô tả sản phẩm</label>
                    <textarea class="form-control" name="description" rows="5">{{ old('description', $product->description ?? '') }}</textarea>
                </div>
            </section>
        </div>
        <div class="col-lg-4">
            <section class="panel">
                <h2 class="h5 mb-3">Ảnh sản phẩm</h2>
                @if(isset($product) && $product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded mb-3" alt="Ảnh">
                @endif
                <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" accept="image/*">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text mt-2">Chọn ảnh JPG/PNG, tối đa 2MB. Bỏ trống nếu không đổi ảnh.</div>
            </section>
        </div>
    </div>
    <div class="d-flex gap-2 mt-4">
        <button class="btn btn-primary" type="submit">{{ isset($product) ? 'Cập nhật sản phẩm' : 'Lưu sản phẩm' }}</button>
        <a class="btn btn-outline-secondary" href="{{ route('admin.products.index') }}">Hủy</a>
    </div>
</form>