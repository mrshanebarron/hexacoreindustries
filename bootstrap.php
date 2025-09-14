<?php

declare(strict_types=1);

/**
 * Bootstrap file for Hexacore Industries Enterprise Application
 * Initializes the application and core services
 */

require_once __DIR__ . '/vendor/autoload.php';

use Hexacore\Core\Application;
use Hexacore\Services\CacheService;

// Initialize the application
$app = Application::getInstance();
$app->boot();

// Initialize core services
$cache = new CacheService();

// Warm up cache for better performance
try {
    $cache->warmUp();
} catch (Exception $e) {
    $app->getLogger()->warning('Cache warm-up failed', [
        'error' => $e->getMessage()
    ]);
}

// Global helper functions
if (!function_exists('config')) {
    function config(string $key, $default = null) {
        global $app;
        return $app->get($key, $default);
    }
}

if (!function_exists('cache')) {
    function cache() {
        global $cache;
        return $cache;
    }
}

if (!function_exists('logger')) {
    function logger() {
        global $app;
        return $app->getLogger();
    }
}

if (!function_exists('asset')) {
    function asset(string $path): string {
        $baseUrl = rtrim(config('app.url', ''), '/');

        // Check if we're in development mode with Vite
        if (config('app.env') === 'local' && file_exists(__DIR__ . '/vite.config.js')) {
            return "http://localhost:5173/{$path}";
        }

        // Production assets with versioning
        return "{$baseUrl}/dist/{$path}";
    }
}

if (!function_exists('url')) {
    function url(string $path = ''): string {
        $baseUrl = rtrim(config('app.url', ''), '/');
        return $baseUrl . '/' . ltrim($path, '/');
    }
}

if (!function_exists('vite_asset')) {
    function vite_asset(string $path): string {
        static $manifest = null;

        // Development mode
        if (config('app.env') === 'local') {
            return "http://localhost:5173/{$path}";
        }

        // Production mode with manifest
        if ($manifest === null) {
            $manifestPath = __DIR__ . '/public/dist/.vite/manifest.json';
            if (file_exists($manifestPath)) {
                $manifest = json_decode(file_get_contents($manifestPath), true);
            } else {
                $manifest = false;
            }
        }

        if ($manifest && isset($manifest[$path])) {
            return url('dist/' . $manifest[$path]['file']);
        }

        return asset($path);
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field(): string {
        return '<input type="hidden" name="_token" value="' . csrf_token() . '">';
    }
}

if (!function_exists('sanitize_output')) {
    function sanitize_output(string $output): string {
        return htmlspecialchars($output, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}

if (!function_exists('format_phone')) {
    function format_phone(string $phone): string {
        $cleaned = preg_replace('/\D/', '', $phone);
        if (strlen($cleaned) === 10) {
            return sprintf('(%s) %s-%s',
                substr($cleaned, 0, 3),
                substr($cleaned, 3, 3),
                substr($cleaned, 6)
            );
        }
        return $phone;
    }
}

// Set global variables for templates
$GLOBALS['app'] = $app;
$GLOBALS['cache'] = $cache;