<?php declare(strict_types=1);

namespace core\vk;

class Attachment
{
    const PHOTO = 'photo';
    const POLL  = 'poll';

    /**
     * Getting the line for the attachment.
     *
     * @param  array $arr
     * @param  string  $pageId
     * @return string|null
     */
    public static function generate(array $arr, string $pageId = '-' . G_ID): ?string
    {
        $str = null;

        foreach ($arr as $key => $value) {
            if (! is_null($value)) {
                $str .= $key . $pageId . '_' . $value . ',';
            }
        }

        if (is_null($str)) {
            return null;
        }

        return mb_substr($str, 0, -1);
    }
}
