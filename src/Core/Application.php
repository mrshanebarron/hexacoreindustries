<?php

declare(strict_types=1);

namespace Hexacore\Core;

use Dotenv\Dotenv;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;
use Symfony\Component\Cache\Adapter\RedisAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/**
 * Main application class for Hexacore Industries
 * Handles initialization, configuration, and core services
 */
class Application
{
    private static ?Application $instance = null;
    private array $config = [];
    private ?Logger $logger = null;
    private $cache = null;
    private array $middleware = [];

    private function __construct()
    {
        $this->loadEnvironment();
        $this->initializeLogger();
        $this->initializeCache();
        $this->registerErrorHandler();
    }

    public static function getInstance(): Application
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function loadEnvironment(): void
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));

        if (file_exists(dirname(__DIR__, 2) . '/.env')) {
            $dotenv->load();
        }

        $this->config = [
            'app' => [
                'name' => $_ENV['APP_NAME'] ?? 'Hexacore Industries',
                'env' => $_ENV['APP_ENV'] ?? 'production',
                'debug' => filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN),
                'url' => $_ENV['APP_URL'] ?? 'https://hexacoreindustries.com',
            ],
            'database' => [
                'connection' => $_ENV['DB_CONNECTION'] ?? 'mysql',
                'host' => $_ENV['DB_HOST'] ?? '127.0.0.1',
                'port' => $_ENV['DB_PORT'] ?? '3306',
                'database' => $_ENV['DB_DATABASE'] ?? 'hexacore_industries',
                'username' => $_ENV['DB_USERNAME'] ?? 'root',
                'password' => $_ENV['DB_PASSWORD'] ?? '',
            ],
            'cache' => [
                'driver' => $_ENV['CACHE_DRIVER'] ?? 'file',
                'redis_host' => $_ENV['REDIS_HOST'] ?? '127.0.0.1',
                'redis_port' => $_ENV['REDIS_PORT'] ?? 6379,
                'redis_password' => $_ENV['REDIS_PASSWORD'] ?? null,
            ],
            'mail' => [
                'mailer' => $_ENV['MAIL_MAILER'] ?? 'smtp',
                'host' => $_ENV['MAIL_HOST'] ?? 'localhost',
                'port' => $_ENV['MAIL_PORT'] ?? 587,
                'username' => $_ENV['MAIL_USERNAME'] ?? '',
                'password' => $_ENV['MAIL_PASSWORD'] ?? '',
                'encryption' => $_ENV['MAIL_ENCRYPTION'] ?? 'tls',
                'from_address' => $_ENV['MAIL_FROM_ADDRESS'] ?? 'noreply@hexacoreindustries.com',
                'from_name' => $_ENV['MAIL_FROM_NAME'] ?? 'Hexacore Industries',
            ],
            'analytics' => [
                'google_analytics_id' => $_ENV['GOOGLE_ANALYTICS_ID'] ?? '',
                'google_tag_manager_id' => $_ENV['GOOGLE_TAG_MANAGER_ID'] ?? '',
            ],
            'security' => [
                'session_secure_cookie' => filter_var($_ENV['SESSION_SECURE_COOKIE'] ?? true, FILTER_VALIDATE_BOOLEAN),
                'session_http_only' => filter_var($_ENV['SESSION_HTTP_ONLY'] ?? true, FILTER_VALIDATE_BOOLEAN),
                'session_same_site' => $_ENV['SESSION_SAME_SITE'] ?? 'strict',
            ],
            'performance' => [
                'opcache_enabled' => filter_var($_ENV['OPCACHE_ENABLED'] ?? true, FILTER_VALIDATE_BOOLEAN),
                'image_optimization_enabled' => filter_var($_ENV['IMAGE_OPTIMIZATION_ENABLED'] ?? true, FILTER_VALIDATE_BOOLEAN),
                'webp_conversion_enabled' => filter_var($_ENV['WEBP_CONVERSION_ENABLED'] ?? true, FILTER_VALIDATE_BOOLEAN),
            ],
        ];
    }

    private function initializeLogger(): void
    {
        $this->logger = new Logger('hexacore');

        $logLevel = $this->config['app']['debug'] ? Logger::DEBUG : Logger::INFO;

        // File logging
        $this->logger->pushHandler(
            new RotatingFileHandler(
                dirname(__DIR__, 2) . '/storage/logs/app.log',
                0,
                $logLevel
            )
        );

        // Error logging
        $this->logger->pushHandler(
            new StreamHandler('php://stderr', Logger::ERROR)
        );
    }

    private function initializeCache(): void
    {
        try {
            if ($this->config['cache']['driver'] === 'redis') {
                $redis = new \Redis();
                $redis->connect(
                    $this->config['cache']['redis_host'],
                    (int) $this->config['cache']['redis_port']
                );

                if ($this->config['cache']['redis_password']) {
                    $redis->auth($this->config['cache']['redis_password']);
                }

                $this->cache = new RedisAdapter($redis);
            } else {
                $this->cache = new FilesystemAdapter(
                    '',
                    0,
                    dirname(__DIR__, 2) . '/storage/cache'
                );
            }
        } catch (\Exception $e) {
            // Fallback to filesystem cache
            $this->cache = new FilesystemAdapter(
                '',
                0,
                dirname(__DIR__, 2) . '/storage/cache'
            );

            $this->logger->warning('Redis cache unavailable, falling back to filesystem cache', [
                'error' => $e->getMessage()
            ]);
        }
    }

    private function registerErrorHandler(): void
    {
        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);

        if (!$this->config['app']['debug']) {
            ini_set('display_errors', '0');
            ini_set('log_errors', '1');
        }
    }

    public function handleError(int $severity, string $message, string $file = '', int $line = 0): bool
    {
        if (!(error_reporting() & $severity)) {
            return false;
        }

        $this->logger->error('PHP Error', [
            'severity' => $severity,
            'message' => $message,
            'file' => $file,
            'line' => $line
        ]);

        return true;
    }

    public function handleException(\Throwable $exception): void
    {
        $this->logger->error('Uncaught Exception', [
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTraceAsString()
        ]);

        if ($this->config['app']['debug']) {
            throw $exception;
        }

        http_response_code(500);
        require dirname(__DIR__, 2) . '/resources/views/errors/500.php';
        exit;
    }

    public function get(string $key, $default = null)
    {
        $keys = explode('.', $key);
        $value = $this->config;

        foreach ($keys as $k) {
            if (!isset($value[$k])) {
                return $default;
            }
            $value = $value[$k];
        }

        return $value;
    }

    public function getLogger(): Logger
    {
        return $this->logger;
    }

    public function getCache()
    {
        return $this->cache;
    }

    public function addMiddleware(string $name, callable $middleware): void
    {
        $this->middleware[$name] = $middleware;
    }

    public function runMiddleware(string $name, $request = null)
    {
        if (isset($this->middleware[$name])) {
            return call_user_func($this->middleware[$name], $request);
        }

        return $request;
    }

    public function boot(): void
    {
        // Set up security headers
        $this->setSecurityHeaders();

        // Initialize session with secure settings
        $this->initializeSecureSession();

        // Set up performance optimizations
        $this->optimizePerformance();
    }

    private function setSecurityHeaders(): void
    {
        // Content Security Policy
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://cdn.tailwindcss.com https://cdn.jsdelivr.net https://www.googletagmanager.com https://www.google-analytics.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.tailwindcss.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:; connect-src 'self' https://www.google-analytics.com; frame-src 'self' https:; object-src 'none'; base-uri 'self';");

        // Other security headers
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: DENY');
        header('X-XSS-Protection: 1; mode=block');
        header('Referrer-Policy: strict-origin-when-cross-origin');
        header('Permissions-Policy: geolocation=(), microphone=(), camera=()');

        // HSTS (only in production)
        if ($this->config['app']['env'] === 'production') {
            header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
        }
    }

    private function initializeSecureSession(): void
    {
        ini_set('session.cookie_httponly', $this->config['security']['session_http_only'] ? '1' : '0');
        ini_set('session.cookie_secure', $this->config['security']['session_secure_cookie'] ? '1' : '0');
        ini_set('session.cookie_samesite', $this->config['security']['session_same_site']);
        ini_set('session.use_strict_mode', '1');

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function optimizePerformance(): void
    {
        // Enable OPcache if available and configured
        if ($this->config['performance']['opcache_enabled'] && function_exists('opcache_get_status')) {
            ini_set('opcache.enable', '1');
            ini_set('opcache.memory_consumption', '256');
            ini_set('opcache.interned_strings_buffer', '16');
            ini_set('opcache.max_accelerated_files', '20000');
            ini_set('opcache.validate_timestamps', $this->config['app']['debug'] ? '1' : '0');
        }

        // Output compression
        if (!ob_get_level() && extension_loaded('zlib')) {
            ob_start('ob_gzhandler');
        }
    }
}