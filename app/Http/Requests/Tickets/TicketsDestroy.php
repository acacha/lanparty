<?php

namespace App\Http\Requests\Tickets;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class TicketsDestroy.
 *
 * @package App\Http\Requests
 */
class TicketsDestroy extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('tickets.destroy');
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
