<?php declare(strict_types=1);

namespace src;

use core\Request;

class Token
{
    /**
     * @var string
     */
    private $_token;

    /**
     * @var string
     */
    private const STORAGE_TOKENS_FILE = D_ROOT . '/configs/tokens.php';

    /**
     * @return void
     *
     * @throws \Exception
     */
    public static function parseInput()
    {
        if (! file_exists(self::STORAGE_TOKENS_FILE)) {
            throw new \Exception(self::STORAGE_TOKENS_FILE . ' - does not exist');
        }

        $tokens = require D_ROOT . '/configs/tokens.php';
        $filteredTokens = [];

        list($site, $type, $access) = self::getFilterTokensRequest();

        if (! empty($access)) {
            $access = explode(',', $access);
        }

        foreach ($tokens as $key => $token) {
            if (! empty($site) && $site !== $token['site']) {
                continue;
            }

            if (! empty($type) && $type !== $token['type']) {
                continue;
            }

            if (! empty($access)) {
                foreach ($access as $acs) {
                    if (! in_array($acs, $token['access'], true)) {
                        continue 2;
                    }
                }
            }

            $filteredTokens[] = $token;
        }

        // TODO Count tokens + rnd

        var_dump($tokens);
        echo '<br><br>';
        var_dump($filteredTokens);
    }

    /**
     * Parse input to get the correct token.
     *
     * @return array
     */
    private static function getFilterTokensRequest(): array {
        return [
            Request::getString('t_site'),
            Request::getString('t_type'),
            Request::getString('t_access')
        ];
    }
}
