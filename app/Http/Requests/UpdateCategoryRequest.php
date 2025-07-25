<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends BaseRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $this->category->id,
            'order' => 'required|numeric|min:0'
        ];
    }
}
