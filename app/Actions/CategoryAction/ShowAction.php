<?php

namespace App\Actions\CategoryAction;

use App\Models\Category;
use App\Models\Product;
use Exception;

class ShowAction
{
    public function execute(string $slug): Category
    {
        $category = Category::where('slug', $slug)->first();
        if (!isset($category)) {
            throw new Exception('Страница не найдена');
        }
        $queryProducts = Product::query();
        $maxProductPrice = $queryProducts->where('category_id', $category->id)->max('price');
        $products = $queryProducts->where('category_id', $category->id)->with('author')->get()->toArray();

        $authors = array_column($products, 'author');
        $uniqueAuthors = [];
        foreach ($authors as $author) {
            $uniqueAuthors[$author['id']] = $author;
        }

        $category->maxProductPrice = $maxProductPrice;
        $category->authorsInCategory = array_values($uniqueAuthors);

        return $category;
    }
}
