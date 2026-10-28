<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const SHIPPING_FEE = 20000;
    protected $fillable =['user_id', 'customer_name', 'phone', 'address', 'note', 'payment_method', 'status', 'total'];
    
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    // Tạo đường dẫn ảnh mã VietQR cho đơn hàng này
    public function vietqrUrl(): string
    {
        $cfg = config('vietqr');

        $query = http_build_query([
            'amount'      => (int) $this->total,
            'addInfo'     => 'DH' . str_pad($this->id, 4, '0', STR_PAD_LEFT), // nội dung chuyển khoản = mã đơn
            'accountName' => $cfg['account_name'],
        ], '', '&', PHP_QUERY_RFC3986);

        return 'https://img.vietqr.io/image/' . $cfg['bank_id'] . '-' . $cfg['account_no']
            . '-' . $cfg['template'] . '.png?' . $query;
    }
}

