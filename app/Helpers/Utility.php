<?php

namespace App\Helpers;

class Utility
{
    public static function array_remove_null($item)
    {
        if (!is_array($item)) {
            return $item;
        }

        return collect($item)
            ->reject(function ($item) {
                return is_null($item);
            })
            ->flatMap(function ($item, $key) {

                return is_numeric($key)
                    ? [array_remove_null($item)]
                    : [$key => array_remove_null($item)];
            })
            ->toArray();
    }

    public static function filterNullValue($collection)
    {
        return $collection->filter(function ($value, $key) {
            return $value != null;
        });
    }

    public static function paginate_collection($items, $perPage)
    {
        $pageStart = request('page', 1);
        $offSet = ($pageStart * $perPage) - $perPage;
        $itemsForCurrentPage = $items->slice($offSet, $perPage)->flatten();
        return new \Illuminate\Pagination\LengthAwarePaginator(
            $itemsForCurrentPage,
            $items->count(),
            $perPage,
            \Illuminate\Pagination\Paginator::resolveCurrentPage(),
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );
    }
}
