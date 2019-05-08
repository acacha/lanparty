<?php

namespace App\Http\Requests\Partners;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ManagersIndex.
 *
 * @package App\Http\Requests
 */
class PartnerIndex extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('partners.index');
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
