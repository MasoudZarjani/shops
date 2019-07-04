<?php

namespace App\Helpers;

use Keygen\Keygen;
use App\User;
use App\Session;

class Utility
{
    /**
     * Create 5 numeric random code for send sms
     *
     * @return string
     */
    public static function ReagentRandomCode()
    {
        $reagentCode = Keygen::numeric(8)->generate();
        $count = User::where('reagent_code', $reagentCode)->count();
        if ($count == 0) {
            return $reagentCode;
        } else {
            return self::ReagentRandomCode();
        }
    }

    /**
     * Check mobile and combine mobile and area code in single mobile
     *
     * @param string mobile_number
     *
     * @return string mobile
     */
    public static function checkMobile($mobile)
    {
        $mobileArray = explode('*', $mobile);
        $mobileArray[1] = ltrim($mobileArray[1], 0);
        return $mobileArray[0] . $mobileArray[1];
    }

    public static function convertMobileFormatToDefault($mobile)
    {
        if ($mobile) {
            if (substr($mobile, 0, 2) == '98') {
                $mobile = substr_replace($mobile, '0', 0, 2);
                return $mobile;
            }
            return $mobile;
        }
        return false;
    }

    /**
     * Check IP and block for 5 min if request is more than 5 times
     *
     * @return string type
     *
     * @return integer counter ip counter of use
     */
    public static function checkIp()
    {
        $date = new \DateTime();
        $date->modify('-5 minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');
        $checkIp = Session::where([['ip', request()->ip()], ['created_at', '>=', $formatted_date]])->first();
        if (is_null($checkIp)) {
            Session::where('ip', request()->ip())->delete();
            $session = new Session();
            $session->ip = request()->ip();
            $session->counter = 0;
            $session->save();
            $counter = 1;
        } else
            $counter = $checkIp->counter;
        if ($counter < config('constants.session.register.count')) {
            self::incrementIpCounter();
            return true;
        }
        return false;
    }

    /**
     *
     *
     * @return string type
     */
    public static function incrementIpCounter()
    {
        Session::where([['ip', request()->ip()]])->increment('counter', 1);
    }


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

    public static function meta($list)
    {
        return $list->pagination = [
            'total' => $list->total(),
            'count' => $list->count(),
            'per_page' => $list->perPage(),
            'current_page' => $list->currentPage(),
            'total_pages' => $list->lastPage()
        ];
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

    public static function rounded($items)
    {
        $avg = 0;
        foreach ($items as $item) {
            $avg += $item->value;
        }

        $avg /= count($items);

        return round($avg);
    }
}
