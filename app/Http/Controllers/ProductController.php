<?php

namespace App\Http\Controllers;

use App\Actions\ProductAction\ShowAction;
use App\Http\Resources\ErrorResource;
use App\Models\PopularProduct;
use App\Models\Product;
use App\Models\WeekProduct;
use App\Traits\DataProcessor;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ProductController extends Controller
{
    use DataProcessor;

    public function indexWeekProducts(Request $request): JsonResponse | ErrorResource
    {
        try {
            $data = $request->all();
            $query = WeekProduct::query()->with('product');
            [$products, $total] = $this->processData($query, $data);
            return response()->json(['rows_count' => $total, 'data' => array_column($products, 'product')]);
        } catch (Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function indexPopularProducts(Request $request): JsonResponse | ErrorResource
    {
        try {
            $data = $request->all();
            $query = PopularProduct::query()->with('product');
            [$products, $total] = $this->processData($query, $data);
            return response()->json(['rows_count' => $total, 'data' => array_column($products, 'product')]);
        } catch (Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function index(Request $request): JsonResponse | ErrorResource
    {
        try {
            $data = $request->all();
            $query = Product::query();
            [$products, $total] = $this->processData($query, $data);
            return response()->json(['rows_count' => $total, 'data' => $products]);
        } catch (Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function show(string $slug, ShowAction $action): JsonResponse | ErrorResource
    {
        try {
            $product = $action->execute($slug);
            return response()->json($product);
        } catch (Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }
}
