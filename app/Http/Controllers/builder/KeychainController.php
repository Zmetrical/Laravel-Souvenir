<?php

namespace App\Http\Controllers\builder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KeychainController extends Controller
{
    public function index()
    {
        return view('builder.keychain', [
            'activePage'   => 'keychain',
            'maxBeads'     => 10,
            'productLabel' => 'Keychain',
            'productConfig' => [
                'product'   => 'keychain',
                'basePrice' => 50,
                'maxBeads'  => 10,
            ],
        ]);
    }
}
