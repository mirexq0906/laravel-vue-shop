<?php

namespace App\Http\Controllers;

use App\Actions\FavoriteAction\StoreAndRemoveAction;
use App\Http\Requests\Favorite\StoreRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\Favorite\IndexResource;
use App\Models\Favorite;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Throwable;

class FavoriteController extends Controller
{
    public function index(): ResourceCollection | ErrorResource
    {
        try {
            $user = Auth::user();
            $products = Favorite::where('user_id', $user->id)->with('product')->get();
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
