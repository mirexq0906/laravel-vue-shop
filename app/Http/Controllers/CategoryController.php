<?php

namespace App\Http\Controllers;

use App\Actions\CategoryAction\ShowAction;
use App\Http\Resources\ErrorResource;
use App\Models\Category;
use App\Traits\DataProcessor;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class CategoryController extends Controller
{
    use DataProcessor;

    public function index(Request $request): JsonResponse | ErrorResource
    {
        try {
            $data = $request->all();
            $query = Category::query();
            [$categories, $total] = $this->processData($query, $data);
            return response()->json(['rows_count' => $total, 'data' => $categories]);
        } catch (Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }

    public function show(string $slug, ShowAction $action): JsonResponse | ErrorResource
    {
        try {
            $category = $action->execute($slug);
            return response()->json($category);
        } catch (Throwable $e) {
            return new ErrorResource($e->getMessage());
        }
    }
}
