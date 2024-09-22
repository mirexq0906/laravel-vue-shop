<?php

namespace App\Actions\BasketAction;

use App\Models\Basket;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;

class StoreAndRemoveAction
{
    /**
     * Добавление или удаление товара из корзины
     */
    public function execute($productId): ?Product
    {
        $user = Auth::user();

        $product = Product::where('id', $productId)->first();

        if (!isset($product)) {
            throw new Exception('Данный товар не найден');
        }

        $productInBaskets = Basket::where('user_id', $user->id)->where('product_id', $productId)->first();

        if (isset($productInBaskets)) {
            $this->remove($productInBaskets);
            return null;
        }

        $this->store($productId, $user->id);

        return $product;
    }

    public function store(int $productId, int $userId): Basket
    {
        $basket = Basket::create([
            'product_id' => $productId,
            'user_id' => $userId,
        ]);

        return $basket;
    }

    public function remove(Basket $basket): void
    {
        $basket->delete();
    }
}
