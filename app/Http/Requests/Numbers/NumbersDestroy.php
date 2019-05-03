<?php

namespace App\Http\Requests\Numbers;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class NumbersDestroy.
 *
 * @package App\Http\Requests
 */
class NumbersDestroy extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('numbers.destroy');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'session' => 'required|string',
            'quantity' => 'required|numeric'
        ];
    }
}
