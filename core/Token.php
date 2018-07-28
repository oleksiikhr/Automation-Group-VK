<?php declare(strict_types=1);

namespace core;

class Token
{
    /**
     * @var string
     */
    private static $_token;

    /**
     * @var string
     */
    private const STORAGE_TOKENS_FILE = D_ROOT . '/configs/tokens.php';

    /**
     * Receiving the required token with filters from the incoming data.
     *
     * @return void
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

        if (! $filteredTokens) {
            throw new \Exception('Tokens are absent');
        }

        self::$_token = $filteredTokens[array_rand($filteredTokens)]['token'];
    }

    /**
     * Get current token.
     *
     * @return string
     */
    public static function getToken(): string
    {
        return self::$_token;
    }

    /**
     * Parse input to get the correct token.
     *
     * @return array
     */
    private static function getFilterTokensRequest(): array
    {
        return [
            Request::getStringLowerCase('t_site'),
            Request::getStringLowerCase('t_type'),
            Request::getStringLowerCase('t_access')
        ];
    }
}
