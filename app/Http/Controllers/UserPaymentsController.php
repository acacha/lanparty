<?php

namespace App\Http\Controllers;

use App\Exceptions\NotEnoughTicketsException;
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
     * @return User
     */
    public function store(UserPaymentsRequest $request, User $user)
    {
        if (isset($user->inscription_paid[$request->session]) && $user->inscription_paid[$request->session]) abort(422,"L'usuari ja ha pagat la inscripció");
        try {
            return $user->pay($request->session);
        } catch (NotEnoughTicketsException $e) {
            abort(422,'No hi ha més places/tickets disponibles');
        }
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
        if (!$user->inscription_paid) abort(422,"L'usuari no ha pagat el ticket");
        return $user->unpay($request->session);
    }
}
