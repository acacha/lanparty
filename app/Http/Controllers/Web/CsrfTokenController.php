<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class CsrfTokenController.
 *
 * @package App\Http\Controllers
 */
class CsrfTokenController extends Controller
{

    /**
     * show.
     *
     * @param Request $request
     * @return string
     */
    public function show(Request $request)
    {
        return csrf_token();
    }
}
