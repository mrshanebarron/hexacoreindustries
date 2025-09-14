<?php

declare(strict_types=1);

namespace Hexacore\Services;

use Hexacore\Core\Application;
use Psr\Cache\CacheItemPoolInterface;

/**
 * High-performance caching service for enterprise applications
 */
class CacheService
{
    private CacheItemPoolInterface $cache;
    private Application $app;

    public function __construct()
    {
        $this->app = Application::getInstance();
        $this->cache = $this->app->getCache();
    }

    /**
     * Get an item from the cache
     */
    public function get(string $key, $default = null, int $ttl = 3600)
    {
        try {
            $item = $this->cache->getItem($this->sanitizeKey($key));

            if ($item->isHit()) {
                return $item->get();
            }

            // If default is callable, execute it and cache the result
            if (is_callable($default)) {
                $value = call_user_func($default);
                $this->set($key, $value, $ttl);
                return $value;
            }

            return $default;
        } catch (\Exception $e) {
            $this->app->getLogger()->error('Cache get error', [
                'key' => $key,
                'error' => $e->getMessage()
            ]);

            return is_callable($default) ? call_user_func($default) : $default;
        }
    }

    /**
     * Set an item in the cache
     */
    public function set(string $key, $value, int $ttl = 3600): bool
    {
        try {
            $item = $this->cache->getItem($this->sanitizeKey($key));
            $item->set($value);
            $item->expiresAfter($ttl);

            return $this->cache->save($item);
        } catch (\Exception $e) {
            $this->app->getLogger()->error('Cache set error', [
                'key' => $key,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Delete an item from the cache
     */
    public function delete(string $key): bool
    {
        try {
            return $this->cache->deleteItem($this->sanitizeKey($key));
        } catch (\Exception $e) {
            $this->app->getLogger()->error('Cache delete error', [
                'key' => $key,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Check if an item exists in the cache
     */
    public function has(string $key): bool
    {
        try {
            return $this->cache->hasItem($this->sanitizeKey($key));
        } catch (\Exception $e) {
            $this->app->getLogger()->error('Cache has error', [
                'key' => $key,
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Clear all cache items
     */
    public function clear(): bool
    {
        try {
            return $this->cache->clear();
        } catch (\Exception $e) {
            $this->app->getLogger()->error('Cache clear error', [
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Cache multiple items at once
     */
    public function setMultiple(array $items, int $ttl = 3600): bool
    {
        try {
            $cacheItems = [];

            foreach ($items as $key => $value) {
                $item = $this->cache->getItem($this->sanitizeKey($key));
                $item->set($value);
                $item->expiresAfter($ttl);
                $cacheItems[] = $item;
            }

            return $this->cache->saveDeferred(...$cacheItems) && $this->cache->commit();
        } catch (\Exception $e) {
            $this->app->getLogger()->error('Cache setMultiple error', [
                'error' => $e->getMessage()
            ]);

            return false;
        }
    }

    /**
     * Get multiple items from cache
     */
    public function getMultiple(array $keys): array
    {
        try {
            $sanitizedKeys = array_map([$this, 'sanitizeKey'], $keys);
            $items = $this->cache->getItems($sanitizedKeys);
            $results = [];

            foreach ($items as $key => $item) {
                if ($item->isHit()) {
                    $results[$key] = $item->get();
                }
            }

            return $results;
        } catch (\Exception $e) {
            $this->app->getLogger()->error('Cache getMultiple error', [
                'keys' => $keys,
                'error' => $e->getMessage()
            ]);

            return [];
        }
    }

    /**
     * Cache page fragments for better performance
     */
    public function cacheFragment(string $key, callable $callback, int $ttl = 3600): string
    {
        $cached = $this->get($key);

        if ($cached !== null) {
            return $cached;
        }

        ob_start();
        call_user_func($callback);
        $content = ob_get_clean();

        $this->set($key, $content, $ttl);

        return $content;
    }

    /**
     * Cache database queries
     */
    public function cacheQuery(string $sql, array $params = [], int $ttl = 1800): array
    {
        $key = 'query:' . md5($sql . serialize($params));

        return $this->get($key, function () use ($sql, $params) {
            // This would normally execute the database query
            // For now, return empty array as we don't have database setup
            return [];
        }, $ttl);
    }

    /**
     * Cache configuration values
     */
    public function cacheConfig(string $key, int $ttl = 7200)
    {
        return $this->get('config:' . $key, function () use ($key) {
            return $this->app->get($key);
        }, $ttl);
    }

    /**
     * Warm up cache with commonly accessed data
     */
    public function warmUp(): void
    {
        $commonCacheKeys = [
            'navigation_menu',
            'featured_products',
            'company_info',
            'contact_details'
        ];

        foreach ($commonCacheKeys as $key) {
            if (!$this->has($key)) {
                $this->preloadData($key);
            }
        }
    }

    /**
     * Sanitize cache key to meet PSR-6 requirements
     */
    private function sanitizeKey(string $key): string
    {
        // PSR-6 compliant key: alphanumeric, dots, underscores, hyphens only
        return preg_replace('/[^a-zA-Z0-9._-]/', '_', $key);
    }

    /**
     * Preload data for specific cache keys
     */
    private function preloadData(string $key): void
    {
        switch ($key) {
            case 'navigation_menu':
                // This would normally load from database or file
                $this->set($key, $this->loadNavigationMenu(), 7200);
                break;
            case 'featured_products':
                $this->set($key, $this->loadFeaturedProducts(), 3600);
                break;
            case 'company_info':
                $this->set($key, $this->loadCompanyInfo(), 86400);
                break;
            case 'contact_details':
                $this->set($key, $this->loadContactDetails(), 86400);
                break;
        }
    }

    private function loadNavigationMenu(): array
    {
        // Placeholder - would normally load from database
        return [
            'menu_items' => [],
            'cached_at' => time()
        ];
    }

    private function loadFeaturedProducts(): array
    {
        // Placeholder - would normally load from database
        return [
            'products' => [],
            'cached_at' => time()
        ];
    }

    private function loadCompanyInfo(): array
    {
        return [
            'name' => 'Hexacore Industries LLC',
            'address' => '123 Industrial Blvd, Tampa, FL',
            'phone' => '863-670-8586',
            'email' => 'walter@hexacoreindustries.com',
            'cached_at' => time()
        ];
    }

    private function loadContactDetails(): array
    {
        return [
            'primary_contact' => 'walter@hexacoreindustries.com',
            'phone' => '863-670-8586',
            'business_hours' => '8 AM - 6 PM EST',
            'cached_at' => time()
        ];
    }
}