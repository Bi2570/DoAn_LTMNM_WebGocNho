<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Phân biệt xem đang gọi hàm update hay add
        if ($this->routeIs('shop.cart.update')) {
            return [
                'quantity' => 'required|array',
                'quantity.*' => 'required|integer|min:1',
            ];
        }

        // Dành cho hàm add (Thêm vào giỏ / Mua ngay)
        return [
            'quantity' => 'nullable|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng tối thiểu là 1.',
            'quantity.required' => 'Vui lòng nhập số lượng.',
        ];
    }
}
