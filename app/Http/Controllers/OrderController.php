<?php

namespace App\Http\Controllers;

use App\Actions\OrderAction\StoreAction;
use App\Http\Requests\Order\StoreRequest;
use App\Http\Resources\ErrorResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderController extends Controller
{
    public function store(StoreRequest $request, StoreAction $action): JsonResponse
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $order = $action->execute($data);

            DB::commit();
            return response()->json($order);
        } catch (Throwable $e) {
            DB::rollBack();
            return new ErrorResource($e->getMessage());
        }
    }
}
