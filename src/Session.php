<?php

declare(strict_types=1);

namespace CoRex\Session;

class Session
{
    /**
     * Clear session.
     *
     * @param string $namespace Default '*'.
     */
    public static function clear(string $namespace = '*'): void
    {
        self::initialize();
        if (isset($_SESSION[$namespace])) {
            unset($_SESSION[$namespace]);
        }
    }

    /**
     * Set session-variable.
     *
     * @param string $name
     * @param mixed $value
     * @param string $namespace Default '*'.
     */
    public static function set(string $name, $value, string $namespace = '*'): void
    {
        self::initialize();
        $_SESSION[$namespace][$name] = $value;
    }

    /**
     * Get session-variable.
     *
     * @param string $name
     * @param mixed $defaultValue Default null.
     * @param string $namespace Default '*'.
     * @return mixed
     */
    public static function get(string $name, $defaultValue = null, string $namespace = '*')
    {
        self::initialize();
        if (self::has($name, $namespace)) {
            return $_SESSION[$namespace][$name];
        }
        return $defaultValue;
    }

    /**
     * Get array.
     *
     * @param string $namespace Default '*'.
     * @return mixed[]
     */
    public static function getArray(string $namespace = '*'): array
    {
        self::initialize();
        if (isset($_SESSION[$namespace])) {
            return $_SESSION[$namespace];
        }
        return [];
    }

    /**
     * Check if session-variable exists.
     *
     * @param string $name
     * @param string $namespace Default '*'.
     * @return bool
     */
    public static function has(string $name, string $namespace = '*'): bool
    {
        self::initialize();
        return isset($_SESSION[$namespace]) && array_key_exists($name, $_SESSION[$namespace]);
    }

    /**
     * Delete session-varable.
     *
     * @param string $name
     * @param string $namespace
     */
    public static function delete(string $name, string $namespace = '*'): void
    {
        self::initialize();
        if (isset($_SESSION[$namespace][$name])) {
            unset($_SESSION[$namespace][$name]);
            if (count($_SESSION[$namespace]) === 0) {
                unset($_SESSION[$namespace]);
            }
        }
    }

    /**
     * Clear session by page filename.
     *
     * @param string $page Default null which means current page PHP_SELF.
     */
    public static function pageClear(?string $page = null): void
    {
        if ($page === null) {
            $page = $_SERVER['PHP_SELF'];
        }
        self::clear($page);
    }

    /**
     * Set session-variable by page-filename.
     *
     * @param string $name
     * @param mixed $value
     * @param string $page Default null which means current page PHP_SELF.
     */
    public static function pageSet(string $name, $value, ?string $page = null): void
    {
        if ($page === null) {
            $page = $_SERVER['PHP_SELF'];
        }
        self::set($name, $value, $page);
    }

    /**
     * Get session-variable by page-filename.
     *
     * @param string $name
     * @param mixed $defaultValue Default null.
     * @param string $page Default null which means current page PHP_SELF.
     * @return mixed
     */
    public static function pageGet(string $name, $defaultValue = null, ?string $page = null)
    {
        if ($page === null) {
            $page = $_SERVER['PHP_SELF'];
        }
        return self::get($name, $defaultValue, $page);
    }

    /**
     * Get session array by page filename.
     *
     * @param string $page Default null which means current page PHP_SELF.
     * @return mixed[]
     */
    public static function pageGetArray(?string $page = null): array
    {
        if ($page === null) {
            $page = $_SERVER['PHP_SELF'];
        }
        return self::getArray($page);
    }

    /**
     * Check if session-variable exists by page-filename.
     *
     * @param string $name
     * @param string $page Default null which means current page PHP_SELF.
     * @return bool
     */
    public static function pageHas(string $name, ?string $page = null): bool
    {
        if ($page === null) {
            $page = $_SERVER['PHP_SELF'];
        }
        return self::has($name, $page);
    }

    /**
     * Delete session-varable by page-filename.
     *
     * @param string $name
     * @param string $page Default null which means current page PHP_SELF.
     */
    public static function pageDelete(string $name, ?string $page = null): void
    {
        if ($page === null) {
            $page = $_SERVER['PHP_SELF'];
        }
        self::delete($name, $page);
    }

    /**
     * Initialize.
     */
    public static function initialize(): void
    {
        if (session_status() === PHP_SESSION_NONE && PHP_SAPI !== 'cli') {
            // @codeCoverageIgnoreStart
            session_start();
            // @codeCoverageIgnoreEnd
        }
    }
}