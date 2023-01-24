<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

class IngredientSaveRequest extends ApiRequest
{
        /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'description' => 'required'
        ];
    }
}
