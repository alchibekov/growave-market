<?php

namespace App\Http\Controllers;

use App\Services\Cart\Exceptions\CartIsEmpty;
use App\Services\Cart\GetCartService;
use App\Services\Product\AddToCartService;
use App\Services\Product\Dto\FilterProductDto;
use App\Services\Product\Exceptions\ProductAlreadyExistsInCart;
use App\Services\Product\Exceptions\ProductNotExistsException;
use App\Services\Product\FilterProductsListService;
use App\Services\Product\GetProductService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private FilterProductsListService $getProductsListService;
    private GetProductService $getProductService;
    private AddToCartService $addToCartService;
    private $getCartService;

    /**
     * ProductController constructor.
     * @param GetCartService $getCartService
     */
    public function __construct(
        GetCartService $getCartService
    )
    {
        $this->getCartService = $getCartService;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): View
    {
        try {
            $products = $this->getCartService->execute();

            return view('cart.index', [
                'products' => $products,
            ]);
        } catch (CartIsEmpty $e) {
            return view('cart.index', [
                'products' => [],
                'cartIsEmpty' => $e->getMessage(),
            ]);
        }

    }
}
