<?php

namespace App\Http\Controllers\builder;

class NecklaceController extends BuilderController
{
    public function index()
    {
        $product  = $this->getProduct('necklace');
        $elements = $this->getElementsPayload();

        return view('builder.necklace', [
            'activePage'    => 'necklace',
            'maxBeads'      => $product->max_beads,
            'productLabel'  => $product->label,
            'productConfig' => [
                'product'   => 'necklace',
                'basePrice' => $product->base_price,
                'maxBeads'  => $product->max_beads,
            ],
            'elements'      => $elements,
        ]);
    }
}