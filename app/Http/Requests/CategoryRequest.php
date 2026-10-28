<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        // route admin được bảo vệ bằng middleware auth và admin
        return true;
    }

    public function rules(): array
    {
        $category = $this->route('category');
        $categoryId = is_object($category) ? $category->id : $category;

        return [
            'name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('categories', 'name')->ignore($categoryId),
            ],
            'description' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên loại sản phẩm.',
            'name.max' => 'Tên loại sản phẩm không được vượt quá 150 ký tự.',
            'name.unique' => 'Tên loại sản phẩm này đã tồn tại.',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'tên loại sản phẩm',
            'description' => 'mô tả',
        ];
    }
}
