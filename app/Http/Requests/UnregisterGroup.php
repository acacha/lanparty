<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UnregisterGroup.
 * @package App\Http\Requests
 */
class UnregisterGroup extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (! Auth::user()) return false;
        return Auth::user()->hasRole('Manager') || $this->loggedUserIsLeaderOfGroup($this->group);
    }

    /**
     * Logged user us leader of group.
     *
     * @param $group
     * @return bool
     */
    protected function loggedUserIsLeaderOfGroup($group)
    {
        if ($group->leader) {
            return $group->leader->id === Auth::user()->id;
        }
        return false;
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
