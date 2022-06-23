<?php

namespace App\Http\Requests\Buys;

use Illuminate\Foundation\Http\FormRequest;

class BuysStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount'        => 'required|numeric',
            'description'   => 'required|string',
        ];
    }
}
