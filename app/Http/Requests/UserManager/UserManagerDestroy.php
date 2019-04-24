<?php

namespace App\Http\Requests\UserManager;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserManagerDestroy.
 *
 * @package App\Http\Requests
 */
class UserManagerDestroy extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('user.manager.destroy');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
