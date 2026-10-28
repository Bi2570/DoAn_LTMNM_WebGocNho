@if (session('ok') || session('error'))
    <div class="flash-stack">
        @if (session('ok'))
            <div class="flash flash--ok" role="status">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('ok') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="flash flash--error" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
    </div>
@endif