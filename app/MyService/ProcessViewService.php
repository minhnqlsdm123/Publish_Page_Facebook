<?php

namespace App\MyService;

use Illuminate\Support\Facades\DB;

class ProcessViewService
{
    public static function incrementViewProduct($table, $column, $key, $id)
    {
        $ip = get_client_ip();
        //Thiết lập thời gian tăng lượt xem sau 1h
        $timeNow = time();
        $timeThrottle = 60 * 60;
        $key = $key . '_' . md5($ip) . '_' . $id;
        if (\Session::exists($key)) {
            $itmeBefore = \Session::get($key);
            if ($timeNow - $itmeBefore < $timeThrottle) {
                return false;
            }
        }
        \Session::put($key, $timeNow);
        DB::table($table)->where('id', $id)->increment($column);
    }
}