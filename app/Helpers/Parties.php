<?php

namespace App\Helpers;

use GuzzleHttp\Client as Guzzle;

class Parties {

    public static function guzzle() {
        return new Guzzle();
    }

    public static function all() {
        $parties = \App\Parties::all();
        return response()->json($parties)->getContent();
    }

    public static function auth($method = 'POST', $action, $data = NULL, $data_key_mode = 'form_params', $special_condition = []) {
        $parties = json_decode(static::all());
        foreach ($parties as $party_key => $party) {
            $http_response[$party_key] = \App\Helpers\Parties::guzzle()->request($method, $party->app_url . $action, [
                $data_key_mode => $data
            ]);
        }
    }

}
