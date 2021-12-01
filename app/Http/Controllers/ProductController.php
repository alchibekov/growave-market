<?php

namespace App\Http\Controllers;

use App\Services\Product\AddToCartService;
use App\Services\Product\DecreaseCountInCartService;
use App\Services\Product\Dto\FilterProductDto;
use App\Services\Product\Exceptions\ProductAlreadyExistsInCart;
use App\Services\Product\Exceptions\ProductNotExistsException;
use App\Services\Product\FilterProductsListService;
use App\Services\Product\GetProductService;
use App\Services\Product\RemoveFromCartService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private FilterProductsListService $getProductsListService;
    private GetProductService $getProductService;
    private AddToCartService $addToCartService;
    private DecreaseCountInCartService $decreaseCountInCartService;
    private RemoveFromCartService $removeFromCartService;

    /**
     * ProductController constructor.
     * @param FilterProductsListService $getProductsListService
     * @param GetProductService $getProductService
     * @param AddToCartService $addToCartService
     * @param DecreaseCountInCartService $decreaseCountInCartService
     * @param RemoveFromCartService $removeFromCartService
     */
    public function __construct(
        FilterProductsListService $getProductsListService,
        GetProductService $getProductService,
        AddToCartService $addToCartService,
        DecreaseCountInCartService $decreaseCountInCartService,
        RemoveFromCartService $removeFromCartService
    )
    {
        $this->getProductsListService = $getProductsListService;
        $this->getProductService = $getProductService;
        $this->addToCartService = $addToCartService;
        $this->decreaseCountInCartService = $decreaseCountInCartService;
        $this->removeFromCartService = $removeFromCartService;
    }


    /**
     * @param Request $request
     */
    public function removeFromCart(Request $request): void
    {
        try {
            $this->removeFromCartService->execute($request->product);

            response()->json([
                'status' => 'success',
            ], JsonResponse::HTTP_OK);
        } catch (ProductNotExistsException $e) {
            response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ProductNotExistsException
     */
    public function decreaseProductInCart(Request $request): JsonResponse
    {
        $count = $this->decreaseCountInCartService->execute($request->product);

        return response()->json([
            'status' => 'success',
            'count' => $count,
        ], JsonResponse::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addToCart(Request $request): JsonResponse
    {
        try {
            $count = $this->addToCartService->execute($request->product);

            return response()->json([
                'status' => 'success',
                'count' => $count,
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
