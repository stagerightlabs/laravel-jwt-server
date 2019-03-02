<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopSecretController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function get()
    {
        return response()->json([
            'codewords' => [
                'kappa',
                'epsilon',
                'omicron',
                'omega'
            ]
        ]);
    }
}
