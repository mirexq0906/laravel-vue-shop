<?php

namespace App\Actions\FavoriteAction;

use App\Models\Favorite;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;

class StoreAndRemoveAction
{
    /**
     * Добавление или удаление товара из избранного
     */
    public function execute($productId): ?Product
    {
        $user = Auth::user();

        $product = Product::where('id', $productId)->first();

        if (!isset($product)) {
            throw new Exception('Данный товар не найден');
        }

        $productInFavorites = Favorite::where('user_id', $user->id)->where('product_id', $productId)->first();

        if (isset($productInFavorites)) {
            $this->remove($productInFavorites);
            return null;
        }

        $this->store($productId, $user->id);

        return $product;
    }

    public function store(int $productId, int $userId): Favorite
    {
        $favorite = Favorite::create([
            'product_id' => $productId,
            'user_id' => $userId,
        ]);

        return $favorite;
    }

    public function remove(Favorite $favorite): void
    {
        $favorite->delete();
    }
}
