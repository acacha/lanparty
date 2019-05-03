<?php

namespace App\Http\Requests\Numbers;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class NumbersStore.
 *
 * @package App\Http\Requests
 */
class NumbersStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('numbers.store');
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
