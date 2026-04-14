<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class test extends FormRequest
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
            'customer_name' => 'required'
           /* 'group' => 'required',
            'customer_type' => 'required',
            'market_segment' => 'required',
            'status' => 'required',
            'transaction_type' => 'required',
            'reciver_banck' => 'required',
            'banck_transaction_date' => 'required' ,*/
        ];
    }
}
