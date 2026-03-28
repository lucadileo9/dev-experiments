<?php

namespace Core;

class Session
{
    private const FLASH_KEY = '_flash';

    /**
     * Store a flash message for the next request
     */
    public static function flash($key, $value = null)
    {
        if ($value === null) {
            return self::get($key);
        }

        self::put($key, $value);
    }

    /**
     * Put a value in the flash array
     */
    public static function put($key, $value)
    {
        $_SESSION[self::FLASH_KEY][$key] = $value;
    }

    /**
     * Get a flash value and remove it
     */
    public static function get($key, $default = null)
    {
        $value = $_SESSION[self::FLASH_KEY][$key] ?? $default;

        unset($_SESSION[self::FLASH_KEY][$key]);

        return $value;
    }

    /**
     * Check if a flash key exists
     */
    public static function has($key)
    {
        return isset($_SESSION[self::FLASH_KEY][$key]);
    }

    /**
     * Get all flash data without removing it
     */
    public static function all()
    {
        return $_SESSION[self::FLASH_KEY] ?? [];
    }

    /**
     * Forget a specific flash key
     */
    public static function forget($key)
    {
        unset($_SESSION[self::FLASH_KEY][$key]);
    }

    /**
     * Clear all flash data
     */
    public static function flush()
    {
        unset($_SESSION[self::FLASH_KEY]);
    }

    public static function old($key, $default = '')
  {
    return Session::get('old')[$key] ?? $default;
    }
}
