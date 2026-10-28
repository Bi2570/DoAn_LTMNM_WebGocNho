@extends('layouts.shop')
@section('title', 'Đăng ký')

@section('content')
<div class="container section">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5 col-xl-4">
            <div class="panel auth">
                <h1 class="h3 mb-1">Tạo tài khoản</h1>
                <p class="text-muted">Tài khoản mới mặc định là khách hàng.</p>
                <form method="post" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name">Họ và tên</label>
                        <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Mật khẩu</label>
                        <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required>
                        <div class="form-text">Tối thiểu 8 ký tự.</div>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password_confirmation">Nhập lại mật khẩu</label>
                        <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Tạo tài khoản</button>
                </form>
                <p class="text-center mt-3 mb-0">Đã có tài khoản? <a href="{{ route('login') }}">Đăng nhập</a></p>
            </div>
        </div>
    </div>
</div>
@endsection