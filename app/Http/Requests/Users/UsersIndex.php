<?php

namespace App\Http\Requests\Users;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UsersIndex.
 *
 * @package App\Http\Requests
 */
class UsersIndex extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('users.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
