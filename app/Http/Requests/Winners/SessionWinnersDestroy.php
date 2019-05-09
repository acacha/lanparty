<?php

namespace App\Http\Requests\Winners;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SessionWinnersDestroy.
 *
 * @package App\Http\Requests
 */
class SessionWinnersDestroy extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('session.winners.destroy');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
        ];
    }
}
