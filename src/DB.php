<?php

namespace gvk;

class DB
{
    /**
     * Get unique values from the database
     *
     * @param string $table
     * @param int    $count
     * @param string $row
     *
     * @return mixed
     */
    public static function getDistinctData($table, $count, $row = 'id')
    {
        $total = self::getCountRows($table);
        $i = 0;
        $arr = [];

        if ($count > $total)
            return \QB::table($table)->select('*')->get();

        while ($i < $count) {
            $temp = mt_rand(1, $total);

            if ( in_array($temp, $arr) )
                continue;

            $arr[$i++] = $temp;
        }

        return \QB::table($table)->whereIn($row, $arr)->get();
    }

    /**
     * Get single data with Database.
     *
     * @param string $table
     * @param string $row
     *
     * @return object
     */
    public static function getRandomData($table, $row = 'id')
    {
        $id = rand( 1, self::getCountRows($table) );

        return \QB::table($table)->where($row, $id)->first();
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
