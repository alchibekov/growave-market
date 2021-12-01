<?php

namespace App\Http\Controllers;

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

    /**
     * ProductController constructor.
     * @param FilterProductsListService $getProductsListService
     * @param GetProductService $getProductService
     * @param AddToCartService $addToCartService
     */
    public function __construct(
        FilterProductsListService $getProductsListService,
        GetProductService $getProductService,
        AddToCartService $addToCartService
    )
    {
        $this->getProductsListService = $getProductsListService;
        $this->getProductService = $getProductService;
        $this->addToCartService = $addToCartService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addToCart(Request $request): JsonResponse
    {
        try {
            $this->addToCartService->execute($request->product);

            return response()->json([
                'status' => 'success'
            ], JsonResponse::HTTP_OK);
        } catch (ProductAlreadyExistsInCart $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): View
    {
        $products = $this->getProductsListService->execute(new FilterProductDto());

        return view('products.index', [
            'products' => $products,
        ]);
    }

    /**
     * @param int $id
     * @return Application|Factory|View
     * @throws ProductNotExistsException
     */
    public function show(int $id): View
    {
        $product = $this->getProductService->execute($id);

        return view('products.show', [
            'product' => $product,
        ]);
    }
}
