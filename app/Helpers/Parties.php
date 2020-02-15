<?php

namespace App\Helpers;

class Parties {

    public static function all() {
        $parties = \App\Parties::all();
        return response()->json($parties)->getContent();
    }

}
