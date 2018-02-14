<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddEmailToNewsletterRequest;
use Newsletter;
use Response;

/**
 * Class NewsletterController.
 *
 * @package App\Http\Controllers
 */
class NewsletterController extends Controller
{
    /**
     * Store email in newsletter
     *
     * @param AddEmailToNewsletterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddEmailToNewsletterRequest $request)
    {
        $result = Newsletter::subscribePending($request->email);

        if ($result) return $result;

        return Response::json([
            'message' => 'User already registered'
        ], 422);
    }
}
