<?php

namespace gvk;

class DB
{
    /**
     * Get single data with Database.
     *
     * @param string $table
     *
     * @return object
     */
    public static function getRandomData($table)
    {
        $id = rand( 1, self::getCountRows($table) );

        return \QB::table($table)->where('id', $id)->first();
    }

    /**
     * Get count rows from table.
     *
     * @param string $table
     *
     * @return object
     */
    public static function getCountRows($table)
    {
        return \QB::table($table)->count();
    }
}
