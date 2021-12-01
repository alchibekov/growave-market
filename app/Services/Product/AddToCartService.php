<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Services\Product\Exceptions\ProductAlreadyExistsInCart;

class AddToCartService
{
    /**
     * @param int $id
     * @throws ProductAlreadyExistsInCart
     */
    public function execute(int $id): void
    {
        if (Product::find($id)->existsInCart()) {
            throw new ProductAlreadyExistsInCart('Продукт уже добавлен в корзину');
        }
        session()->push('cart.products', $id);
    }
}
