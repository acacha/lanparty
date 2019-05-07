<?php

namespace App\Http\Requests\Partners;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class PartnerUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      return Auth::user()->can('partners.update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          'name'=>'required'
        ];
    }
}
