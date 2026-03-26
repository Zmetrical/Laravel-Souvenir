<?php

namespace App\Http\Controllers\builder;

class KeychainController extends BuilderController
{
    public function index()
    {
        $product  = $this->getProduct('keychain');
        $elements = $this->getElementsPayload();

        return view('builder.keychain', [
            'activePage'    => 'keychain',
            'maxBeads'      => $product->max_beads,
            'productLabel'  => $product->label,
            'productConfig' => [
                'product'   => 'keychain',
                'basePrice' => $product->base_price,
                'maxBeads'  => $product->max_beads,
            ],
            'elements'      => $elements,
        ]);
    }
}