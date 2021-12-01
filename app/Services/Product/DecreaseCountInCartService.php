<?php

namespace App\Services\Product;

class DecreaseCountInCartService
{
    /**
     * @param int $id
     */
    public function execute(int $id): void
    {
        $productsInCart = collect(session('cart.products'));

        $product = $productsInCart->firstWhere('id', $id);

        if (!$product) {
            return;
        }

        if ($product['id']) {

        }

        $productsInCart->map(function($product) use ($id) {
            if ($product['id'] === $id) {
                $product['id'] -= 1;
            }

            return $product;
        });
    }
}
