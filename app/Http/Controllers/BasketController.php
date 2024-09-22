<?php

namespace App\Http\Controllers;

use App\Actions\BasketAction\StoreAndRemoveAction;
use App\Http\Requests\Basket\StoreRequest;
use App\Http\Resources\Basket\IndexResource;
use Illuminate\Http\JsonResponse;
use Throwable;
use App\Http\Resources\ErrorResource;
use App\Models\Basket;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function index(): ResourceCollection | ErrorResource
    {
        try {
            $user = Auth::user();
            $products = Basket::where('user_id', $user->id)->with('product')->get();
            return IndexResource::collection($products);
        } catch (Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function storeAndRemove(StoreRequest $request, StoreAndRemoveAction $action): JsonResponse | ErrorResource
    {
        try {
            $data = $request->validated();
            $product = $action->execute($data['product_id']);
            return response()->json($product);
        } catch (Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }
}
