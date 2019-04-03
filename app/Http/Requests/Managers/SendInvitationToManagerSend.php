<?php

namespace App\Http\Requests\Managers;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SendInvitationToManagerSend.
 *
 * @package App\Http\Requests
 */
class SendInvitationToManagerSend extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('managers.invitation.send');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email'
        ];
    }
}
