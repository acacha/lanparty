<?php

namespace App\Http\Requests\Events;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ArchivedEventsStore.
 *
 * @package App\Http\Requests
 */
class ArchivedEventsStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('archived.events.store');
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
