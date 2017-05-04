<?php

namespace gvk;

class DB
{
    public static function getRandomData($table)
    {
        $count = \QB::table($table)->count();
        $rnd = rand(1, $count);

        return \QB::table($table)->where('id', '=', $rnd)->first();
    }
}
