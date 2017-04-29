<?php

namespace gvk;

trait Methods
{
    /**
     * Letter 'i' to Upper register -> I.
     *
     * @param string $str
     *
     * @return string
     */
    function upperI($str)
    {
        $str = preg_replace('/\Ai\s/u', 'I ', $str); // Начало строки + i + пробел
        $str = preg_replace('/\si\z/u', ' I', $str); // Пробел + i + конец строки
        $str = preg_replace('/\si\s/u', ' I ', $str); // Пробел + i + пробел
        $str = preg_replace('/\si(\.|\?|\!)/u', ' I', $str); // Пробел + i + знаки препинания
        $str = preg_replace('/\si\\\'/u', ' I\'', $str); // Пробел + i + знак '

        return $str;
    }

    /**
     * First letter Upper.
     *
     * @param string $str
     *
     * @return string
     */
    function upperFirst($str)
    {
        return mb_strtoupper( mb_substr($str, 0, 1) ) . mb_substr($str, 1);
    }
}
