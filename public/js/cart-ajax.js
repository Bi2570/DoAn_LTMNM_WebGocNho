// Thêm vào giỏ hàng bằng AJAX (Fetch API): không tải lại trang.
document.addEventListener('submit', async function (event) {
    const form = event.target;

    // Chỉ xử lý form có thuộc tính data-ajax-cart
    if (!form.matches('[data-ajax-cart]')) return;
    // Nút "Mua ngay" vẫn gửi form bình thường để chuyển sang trang thanh toán
    if (event.submitter && event.submitter.name === 'buy_now') return;

    event.preventDefault();

    const button = event.submitter || form.querySelector('button[type="submit"]');
    const oldHtml = button ? button.innerHTML : '';
    if (button) {
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
    }

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            body: new FormData(form),
        });

        // Chưa đăng nhập: chuyển sang trang đăng nhập
        if (response.status === 401) {
            window.location.href = document.querySelector('meta[name="login-url"]').content;
            return;
        }

        const data = await response.json();
        if (response.ok && data.ok) {
            updateCartBadge(data.cart_count);
            showToast(data.message, 'ok');
        } else {
            showToast(data.message || 'Không thể thêm vào giỏ hàng.', 'error');
        }
    } catch (error) {
        showToast('Có lỗi kết nối, vui lòng thử lại.', 'error');
    } finally {
        if (button) {
            button.disabled = false;
            button.innerHTML = oldHtml;
        }
    }
});

// Cập nhật con số trên biểu tượng giỏ hàng ở header
function updateCartBadge(count) {
    const badge = document.getElementById('cart-count');
    if (!badge) return;
    badge.textContent = count;
    badge.classList.toggle('d-none', count <= 0);
}

// Hiện thông báo nổi, tự biến mất sau 3,5 giây
function showToast(message, type) {
    let stack = document.getElementById('toast-stack');
    if (!stack) {
        stack = document.createElement('div');
        stack.id = 'toast-stack';
        stack.className = 'toast-stack';
        stack.setAttribute('aria-live', 'polite');
        document.body.appendChild(stack);
    }
    const toast = document.createElement('div');
    toast.className = 'toast-msg toast-msg--' + type;

    const icon = document.createElement('i');
    icon.className = type === 'ok' ? 'bi bi-check-circle-fill' : 'bi bi-exclamation-triangle-fill';

    const text = document.createElement('span');
    text.textContent = message; // dùng textContent để tên sản phẩm không chèn được mã HTML

    toast.append(icon, text);
    stack.appendChild(toast);
    setTimeout(() => toast.remove(), 3500);
}