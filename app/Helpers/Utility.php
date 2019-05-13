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

    /**
     * Check IP and block for 5 min if request is more than 5 times
     *
     * @return string type
     *
     * @return integer counter ip counter of use
     */
    public static function checkIp($ip)
    {
        $date = new \DateTime();
        $date->modify('-5 minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');
        $checkIp = Session::where([['ip_address', $ip], ['created_at', '>=', $formatted_date]])->first();
        if (is_null($checkIp)) {
            Session::where('ip_address', $ip)->delete();
            $session = new Session();
            $session->ip_address = $ip;
            $session->counter = 0;
            $session->save();
            $counter = 1;
        } else
            $counter = $checkIp->counter;
        if ($counter < config('constants.session.register.count')) {
            self::incrementIpCounter($ip);
            return true;
        }
        return false;
    }

    /**
     *
     *
     * @return string type
     */
    public static function incrementIpCounter($ip)
    {
        Session::where([['ip_address', $ip]])->increment('counter', 1);
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
