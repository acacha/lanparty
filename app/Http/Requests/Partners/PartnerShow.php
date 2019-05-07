<?php

namespace App\Http\Requests\Partners;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class PartnerShow extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      return Auth::user()->can('partners.show');
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
