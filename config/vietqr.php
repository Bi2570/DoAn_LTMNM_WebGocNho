<?php

// Thông tin tài khoản nhận tiền cho mã VietQR.
// ĐÂY LÀ TÀI KHOẢN MẪU cho đồ án. Không dùng số tài khoản thật của ai trong nhóm.
return [
    'bank_id'      => env('VIETQR_BANK_ID', 'MB'),
    'account_no'   => env('VIETQR_ACCOUNT_NO', '0123456789'),
    'account_name' => env('VIETQR_ACCOUNT_NAME', 'SHOP GOC NHO'),
    'template'     => env('VIETQR_TEMPLATE', 'compact2'),
];