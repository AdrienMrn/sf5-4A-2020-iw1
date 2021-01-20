<?php

namespace App\Services;

class IPLocationService
{
    public function getLocationByIP($ip)
    {
        $access_key = '054b411c1a6910fb2d0bd3b995af2c1a';

        $ch = curl_init('http://api.ipstack.com/'.$ip.'?access_key='.$access_key.'');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $json = curl_exec($ch);
        curl_close($ch);

        return json_decode($json, true);
    }
}