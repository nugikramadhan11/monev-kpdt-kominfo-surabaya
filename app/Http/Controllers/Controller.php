<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use ValidatesRequests;

    /**
     * Authorize a given action for the current user.
     *
     * @param string $ability
     * @param mixed $model
     * @return void
     */
    public function authorize($ability, $model = null)
    {
        if (! auth()->check()) {
            abort(401);
        }

        if (! auth()->user()->can($ability, $model)) {
            abort(403);
        }
    }
}
