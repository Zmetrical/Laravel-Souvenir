<?php

namespace App\Http\Controllers\builder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NecklaceController extends Controller
{
    public function index()
    {
        return view('builder.necklace', [
            'activePage'   => 'necklace',
            'maxBeads'     => 30,
            'productLabel' => 'Necklace',
            'productConfig' => [
                'product'   => 'necklace',
                'basePrice' => 120,
                'maxBeads'  => 30,
            ],
        ]);
    }
}
