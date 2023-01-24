<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

class RecipeSaveRequest extends ApiRequest
{
        /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'ingredients' => 'required',
            'ingredients.*.id' => 'required|numeric|exists:ingredients,id',
            'ingredients.*.kg' => 'required|numeric',
            'ingredients.*.order' => 'required|numeric',
        ];
    }
}
