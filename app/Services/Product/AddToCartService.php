<?php

namespace App\Services\Product;

class AddToCartService
{
    /**
     * @param int $id
     * @return int
     */
    public function execute(int $id): int
    {
        $productsInCart = collect(session('cart.products'));

        $product = $productsInCart->firstWhere('id', $id);

        if (!$product) {
            session()->push('cart.products', [
                'count' => 1,
                'id' => $id
            ]);

            return 1;
        }

        $productsInCart = $productsInCart->map(function($product) use ($id) {
            if ($product['id'] === $id) {
                $product['count'] += 1;
            }

            return $product;
        });

        session(['cart.products' => $productsInCart]);

        $product = $productsInCart->firstWhere('id', $id);

        return $product['count'];
    }
}
