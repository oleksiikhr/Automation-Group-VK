<?php

namespace core\vk\enums;

final class Attachment
{
    const PHOTO = 'photo';
    // TODO

    /**
     * Getting the line for the attachment.
     *
     * @param  array  $arr
     * @return string|null
     */
    public static function generate(array $arr): ?string
    {
        $str = null;

        foreach ($arr as $key => $value) {
            if (! is_null($value)) {
                $str .= $key . '-' . G_ID . '_' . $value . ',';
            }
        }

        if (is_null($str)) {
            return null;
        }

        return mb_substr($str, 0, -1);
    }
}
