<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait DataProcessor
{
    public function processData(Builder $query, array $settings)
    {
        $limit = $settings['limit'] ?? 999;
        $page = $settings['page'] ?? 1;

        if (isset($settings['filters'])) {
            $filters = $settings['filters'];
            foreach ($filters as $filter) {
                if ($filter['operator'] === "like") {
                    $query->where($filter['field'], "like", "%" . $filter['value'] . "%");
                } elseif ($filter['operator'] === "equal") {
                    $query->where($filter['field'], $filter['value']);
                } elseif ($filter['operator'] === "increase") {
                    $query->where($filter['field'], ">", $filter['value']);
                } elseif ($filter['operator'] === "decrease") {
                    $query->where($filter['field'], "<", $filter['value']);
                }
            }
        }

        if (isset($settings['sort'])) {
            $sort = $settings['sort'];
            $query->orderBy($sort['field'], $sort['order']);
        }

        $total = $query->get()->count();

        $records = $query->paginate($limit, ['*'], 'page', $page);

        return [$records->items(), $total];
    }
}
