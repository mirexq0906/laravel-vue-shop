<?php

namespace App\Actions\ProductAction;

use App\Models\Product;
use Exception;

class ShowAction
{
    public function execute(string $slug): Product
    {
        $product = Product::where('slug', $slug)->first();
        if (!isset($product)) {
            throw new Exception('Страница не найдена');
        }
        return $product;
    }
}
