<?php

/**
 * Caching - class
 * FoNiX Framework - Mohamed Barhoun - https://github.com/FoNiXPr020
 * Copyright © 2024 All Rights Reserved.
 */

namespace Core;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class Caching
{
    private static $cache;
    private static $expiration;

    public function __construct()
    {
        self::$cache = new FilesystemAdapter();
        self::$expiration = new \DateTimeImmutable('+100 years');
    }

    public static function has(string $key): bool
    {
        return self::$cache->hasItem($key);
    }

    public static function get(string $key)
    {
        if (self::has($key)) {
            return self::$cache->getItem($key)->get();
        }
        return null;
    }

    public static function set(string $key, $data): void
    {
        $cacheItem = self::$cache->getItem($key)
            ->set($data)
            ->expiresAt(self::$expiration);

        self::$cache->save($cacheItem);
    }

    public static function delete(string $key): void
    {
        self::$cache->deleteItem($key);
    }
}
