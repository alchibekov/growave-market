<?php

namespace App\Services\Product;

use App\Models\Product;
use App\Services\Product\Dto\FilterProductDto;
use Illuminate\Pagination\LengthAwarePaginator;

class FilterProductsListService
{
    /**
     * @param FilterProductDto $filterProductDto
     * @return LengthAwarePaginator
     */
    public function execute(FilterProductDto $filterProductDto): LengthAwarePaginator
    {
        return Product::when(count($filterProductDto->onlyIds), function ($query) use ($filterProductDto) {
            $query->whereIn('id', $filterProductDto->onlyIds);
        })
            ->latest()
            ->paginate($filterProductDto->perPage);
    }
}
