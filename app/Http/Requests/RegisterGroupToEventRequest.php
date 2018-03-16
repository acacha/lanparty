<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegisterGroupToEventRequest.
 *
 * @package App\Http\Requests
 */
class RegisterGroupToEventRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'avatar' => 'required|image',
//            'avatar' => ['nullable', 'image', Rule::dimensions()->minWidth(600)->ratio(8.5/11)],
            'ids' => 'required'
        ];
    }
}
