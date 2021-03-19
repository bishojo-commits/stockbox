<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepotStoreRequest extends FormRequest
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
            'depot_title' => 'required|min:3|max:32',
            'depot_currency' => 'required|max:16'
        ];
    }
}
