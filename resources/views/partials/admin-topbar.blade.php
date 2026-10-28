<div class="fw-semibold text-muted">
    <i class="bi bi-grid-1x2-fill"></i> Hệ thống quản trị
</div>

<div class="admin-top__user">
    <span class="role-badge">Quản trị viên</span>
    <span>{{ auth()->user()->name ?? 'Admin' }}</span>
    <form method="post" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-sm btn-outline-secondary" type="submit">Đăng xuất</button>
    </form>
</div>