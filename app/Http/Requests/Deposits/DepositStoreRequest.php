<?php

namespace App\Http\Requests\Deposits;

use Illuminate\Foundation\Http\FormRequest;

class DepositStoreRequest extends FormRequest
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
        //'user_id', 'authorized_by', 'authorized','amount','created_at',
        return [
            'amount'           => 'required|numeric',
        ];
    }
}
