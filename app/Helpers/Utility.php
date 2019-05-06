<?php

namespace App\Helpers;

use Keygen\Keygen;
use App\ActiveIp;
use App\User;

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
     * Check tel and combine tel and area code in single tel
     *
     * @param string mobile_number
     *
     * @return string tel
     */
    public static function checkTel($tel)
    {
        $telArray = explode('*', $tel);
        $telArray[1] = ltrim($telArray[1], 0);
        return $telArray[0] . $telArray[1];
    }

    /**
     * Check IP and block for 5 min if request is more than 5 times
     *
     * @return string type
     *
     * @return integer counter ip counter of use
     */
    public static function checkIp($ip, $type)
    {
        $date = new \DateTime();
        $date->modify('-5 minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');
        $checkIp = ActiveIp::where([['ip', $ip], ['type', $type], ['created_at', '>=', $formatted_date]])->first();
        if (is_null($checkIp)) {
            ActiveIp::where('ip', $ip)->delete();
            $active_ip = new ActiveIp();
            $active_ip->ip = $ip;
            $active_ip->type = $type;
            $active_ip->counter = 0;
            $active_ip->save();
            $counter = 1;
        } else
            $counter = $checkIp->counter;
        if ($counter < config('constants.activeIp.register.count')) {
            self::incrementIpCounter($ip, config('constants.activeIp.register.type'));
            return true;
        }
        return false;
    }

    /**
     *
     *
     * @return string type
     */
    public static function incrementIpCounter($ip, $type)
    {
        ActiveIp::where([['ip', $ip], ['type', $type]])->increment('counter', 1);
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
