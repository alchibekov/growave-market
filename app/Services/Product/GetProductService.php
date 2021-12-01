<?php


namespace App\Services\Product;


use App\Services\Product\Exceptions\ProductNotExistsException;
use App\Models\Product;

class GetProductService
{
    /**
     * @param int $id
     * @return Product
     * @throws ProductNotExistsException
     */
    public function execute(int $id): Product
    {
        $item = Product::find($id);

        if (! $item instanceof Product) {
            throw new ProductNotExistsException("Продукта с id = $id не существует");
        }

        return $item;
    }
}
