<?php

namespace App\Http\Requests\Managers;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ManagersIndex.
 *
 * @package App\Http\Requests
 */
class ManagersIndex extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('managers.index');
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
