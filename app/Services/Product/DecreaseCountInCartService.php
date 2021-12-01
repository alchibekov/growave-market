<?php

namespace App\Services\Product;

use App\Services\Product\Exceptions\ProductNotExistsException;

class DecreaseCountInCartService
{
    private RemoveFromCartService $removeFromCartService;
    private int $id;

    /**
     * DecreaseCountInCartService constructor.
     * @param RemoveFromCartService $removeFromCartService
     */
    public function __construct(
        RemoveFromCartService $removeFromCartService
    )
    {
        $this->removeFromCartService = $removeFromCartService;
    }

    /**
     * @param int $id
     * @return int
     * @throws ProductNotExistsException
     */
    public function execute(int $id): int
    {
        $this->setId($id);

        $productsInCart = collect(session('cart.products'));

        if ($this->getProductCount($productsInCart) === 0) {
            $this->removeFromCartService->execute($id);

            return 0;
        }

        $productsInCart = $productsInCart->map(function($product) {
            if ($product['id'] === $this->id) {
                $product['count'] -= 1;
            }

            return $product;
        });

        if ($this->getProductCount($productsInCart) === 0) {
            $productsInCart = $this->removeFromCartService->execute($id);
        }

        session(['cart.products' => $productsInCart]);

        return $this->getProductCount();
    }

    /**
     * @param null $productsInCart
     * @return int
     */
    private function getProductCount($productsInCart = null): int
    {
        $productsInCart = $productsInCart ?: collect(session('cart.products'));

        $product = $productsInCart->firstWhere('id', $this->id);
        if (!$product) {
            return 0;
        }

        return $product['count'];
    }

    /**
     * @param int $id
     */
    private function setId(int $id): void
    {
        $this->id = $id;
    }
}
