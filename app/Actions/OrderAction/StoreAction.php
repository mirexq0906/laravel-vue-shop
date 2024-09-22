<?php

namespace App\Actions\OrderAction;

use App\Models\Basket;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class StoreAction
{
    public function execute(array $data): Order
    {
        $user = Auth::user();

        $order = Order::create([
            'phone' => $data['phone'],
            'name' => $data['name'],
            'email' => $data['email'],
            'payment' => $data['payment'],
            'delivery' => $data['delivery'],
            'user_id' => $user->id
        ]);

        $attachData = [];

        foreach ($data['products'] as $productId => $count) {
            $attachData[] = [
                'count' => $count,
                'product_id' => $productId,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        $order->product()->attach($attachData);

        Basket::where('user_id', $user->id)->delete();

        return $order;
    }
}
