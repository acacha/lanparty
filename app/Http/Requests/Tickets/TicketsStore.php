<?php

namespace App\Http\Requests\Tickets;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class TicketsStore.
 *
 * @package App\Http\Requests
 */
class TicketsStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('tickets.store');
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
