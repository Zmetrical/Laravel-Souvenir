<?php

namespace App\Http\Controllers\builder;

class BraceletController extends BuilderController
{
    public function index()
    {
        $product  = $this->getProduct('bracelet');
        $elements = $this->getElementsPayload();

        return view('builder.bracelet', [
            'activePage'    => 'bracelet',
            'maxBeads'      => $product->max_beads,
            'productLabel'  => $product->label,
            'productConfig' => [
                'product'   => 'bracelet',
                'basePrice' => $product->base_price,
                'maxBeads'  => $product->max_beads,
            ],
            'elements'      => $elements,   
        ]);
    }
}