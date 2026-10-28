@extends('layouts.shop')
@section('title', 'Đăng nhập')

@section('content')
<div class="container section">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5 col-xl-4">
            <div class="panel auth">
                <h1 class="h3 mb-1">Đăng nhập</h1>
                <p class="text-muted">Dùng chung cho khách hàng và quản trị viên.</p>
                <form method="post" action="{{ route('login') }}">
                    @csrf
                    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" autocomplete="email" required autofocus>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="password">Mật khẩu</label>
                        <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" autocomplete="current-password" required>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Đăng nhập</button>
                </form>
                <p class="text-center mt-3 mb-0">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a></p>
            </div>
        </div>
    </div>
</div>
@endsection