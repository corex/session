<?php

declare(strict_types=1);

namespace CoRex\Session;

class Token
{
    /** @var string */
    public static $namespace = '-token-';

    /**
     * Clear all tokens.
     */
    public static function clear(): void
    {
        Session::clear(self::$namespace);
    }

    /**
     * Create token.
     *
     * @param string $name
     * @param int $lifetime Default 300 seconds.
     * @return string
     */
    public static function create(string $name, int $lifetime = 300): string
    {
        $token = sha1(microtime());
        $tokenData = [
            'token' => $token,
            'time' => time(),
            'lifetime' => $lifetime
        ];
        Session::set($name, $tokenData, self::$namespace);
        return $token;
    }

    /**
     * Get token.
     *
     * @param string $name
     * @return string|null
     */
    public static function get(string $name): ?string
    {
        $data = Session::get($name, null, self::$namespace);
        if (is_array($data) && array_key_exists('token', $data)) {
            return $data['token'];
        }
        return null;
    }

    /**
     * Has.
     *
     * @param string $name
     * @return bool
     */
    public static function has(string $name): bool
    {
        return Session::has($name, self::$namespace);
    }

    /**
     * Is token valid.
     *
     * @param string $name
     * @param string $token
     * @return bool
     */
    public static function isValid(string $name, string $token): bool
    {
        $savedToken = Session::get($name, null, self::$namespace);
        if (isset($savedToken['token'])) {
            if (time() >= $savedToken['time'] + $savedToken['lifetime']) {
                $savedToken['token'] = '';
            }
            return $token === $savedToken['token'];
        }
        return false;
    }

    /**
     * Delete.
     *
     * @param string $name
     */
    public static function delete(string $name): void
    {
        Session::delete($name, self::$namespace);
    }
}