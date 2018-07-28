<?php declare(strict_types=1);

namespace core;

class Token
{
    private const STORAGE_TOKENS_FILE = D_ROOT . '/configs/tokens.php';

    /**
     * @var object
     */
    private static $_token;

    /**
     * @var array
     */
    private static $_additionalTokens;

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
        $filteredTokens = self::filterTokens($tokens);

        if (! $filteredTokens) {
            throw new \Exception('Tokens are absent');
        }

        shuffle($filteredTokens);

        self::$_token = array_pop($filteredTokens);
        self::$_additionalTokens = $filteredTokens;
    }

    /**
     * Get the main token.
     *
     * @return string
     */
    public static function getToken(): string
    {
        return self::$_token['token'];
    }

    /**
     * Get additional tokens.
     *
     * @return array
     */
    public static function getAdditionalTokens(): array
    {
        $tokens = [];

        foreach (self::$_additionalTokens as $token) {
            $tokens[] = $token['token'];
        }

        return $tokens;

    }

    /**
     * Are there additional tokens?
     *
     * @return bool
     */
    public static function hasAdditionalTokens(): bool
    {
        return count(self::$_additionalTokens) > 0;
    }

    /**
     * Filter tokens using GET parameters.
     *
     * @param  array  $tokens
     * @return array
     */
    private static function filterTokens(array $tokens)
    {
        list($site, $type, $access) = self::getFilterTokensRequest();

        $filteredTokens = [];

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

        return $filteredTokens;
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
