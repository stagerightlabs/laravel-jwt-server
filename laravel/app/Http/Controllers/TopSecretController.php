<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopSecretController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function get()
    {
        return response()->json([
            'secret code words' => [
                'kappa',
                'epsilon',
                'omicron',
                'omega'
            ]
        ]);
    }
}
