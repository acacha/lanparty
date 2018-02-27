<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPaymentsRequest;
use App\User;
use Illuminate\Http\Request;

/**
 * Class UserPaymentsController.
 * 
 * @package App\Http\Controllers
 */
class UserPaymentsController extends Controller
{

    /**
     * Pay user ticket.
     *
     * @param UserPaymentsRequest $request
     * @param User $user
     * @return $this
     */
    public function store(UserPaymentsRequest $request, User $user)
    {
        return $user->pay();
    }

    /**
     * Unpay user ticket.
     *
     * @param UserPaymentsRequest $request
     * @param User $user
     * @return $this
     */
    public function destroy(UserPaymentsRequest $request, User $user)
    {
        return $user->unpay();
    }
}
