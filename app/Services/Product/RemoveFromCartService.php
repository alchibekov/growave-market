<?php

namespace App\Services\Product;

use App\Services\Product\Exceptions\ProductNotExistsException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Session\SessionManager;
use Illuminate\Session\Store;
use Illuminate\Support\Collection;

class RemoveFromCartService
{
    /**
     * @param int $id
     * @return Application|SessionManager|Store|mixed
     * @throws ProductNotExistsException
     */
    public function execute(int $id)
    {
        $productsInCart = collect(session('cart.products'));

        $product = $productsInCart->firstWhere('id', $id);

        if (!$product) {
            throw new ProductNotExistsException("В корзине нет продукта с id = $id");
        }

        $productsInCart = $productsInCart->filter(function ($product) use ($id) {
            return $product['id'] !== $id;
        });

        session([
            'cart.products' => $productsInCart->count()
                ? $productsInCart->toArray()
                : null,
        ]);

        return session('cart.products');
    }
}
