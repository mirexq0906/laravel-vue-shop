<?php

namespace App\Console\Commands;

use App\Models\PopularProduct;
use App\Models\WeekProduct;
use DateTime;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class GetPopularPrducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-popular-prducts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получение популярных продуктов';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $this->getPopularProducts();
            $this->getWeekProducts();
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
        }
    }

    public function getWeekProducts(): void
    {
        $oneWeekAgo = (new DateTime())->modify('-1 week')->format('Y-m-d H:i:s');

        $now = (new DateTime())->format('Y-m-d H:i:s');

        $orderProducts = DB::table('order_product')
            ->select('product_id')
            ->whereBetween('created_at', [$oneWeekAgo, $now])
            ->get();

        $productsToInsert = $this->handleProducts($orderProducts);

        WeekProduct::truncate();

        WeekProduct::insert($productsToInsert);
    }

    public function getPopularProducts(): void
    {
        $orderProducts = DB::table('order_product')->select('product_id')->get();

        $productsToInsert = $this->handleProducts($orderProducts);

        PopularProduct::truncate();

        PopularProduct::insert($productsToInsert);
    }

    public function handleProducts($orderProducts): array
    {
        $popularProducts = [];

        foreach ($orderProducts as $item) {
            $productId = $item->product_id;
            if (isset($popularProducts[$productId])) {
                $popularProducts[$productId]++;
            } else {
                $popularProducts[$productId] = 1;
            }
        }

        arsort($popularProducts);

        $productsLimit = array_slice($popularProducts, 0, 50, true);

        $productsToInsert = [];

        foreach ($productsLimit as $productId => $count) {
            $productsToInsert[] = [
                'product_id' => $productId,
                'count' => $count
            ];
        }

        return $productsToInsert;
    }
}
