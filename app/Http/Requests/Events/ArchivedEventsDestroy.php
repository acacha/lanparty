<?php

namespace App\Http\Requests\Events;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ArchivedEventsDestroy.
 *
 * @package App\Http\Requests
 */
class ArchivedEventsDestroy extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('archived.events.destroy');
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
