<?php

declare(strict_types=1);

namespace Hexacore\Services;

use Hexacore\Core\Application;

/**
 * Enterprise performance monitoring service
 * Tracks Core Web Vitals, server metrics, and application performance
 */
class PerformanceMonitoringService
{
    private Application $app;
    private CacheService $cache;
    private array $metrics = [];
    private float $startTime;
    private int $startMemory;

    public function __construct()
    {
        $this->app = Application::getInstance();
        $this->cache = new CacheService();
        $this->startTime = microtime(true);
        $this->startMemory = memory_get_usage(true);

        $this->initializeMetrics();
    }

    /**
     * Initialize performance metrics collection
     */
    private function initializeMetrics(): void
    {
        $this->metrics = [
            'timestamp' => time(),
            'request_uri' => $_SERVER['REQUEST_URI'] ?? '/',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'ip_address' => $this->getClientIP(),
            'server' => [
                'php_version' => PHP_VERSION,
                'memory_limit' => ini_get('memory_limit'),
                'max_execution_time' => ini_get('max_execution_time'),
                'opcache_enabled' => function_exists('opcache_get_status') && opcache_get_status(),
            ],
            'performance' => [],
            'database' => [],
            'cache' => [],
            'errors' => []
        ];
    }

    /**
     * Start timing a specific operation
     */
    public function startTimer(string $name): void
    {
        $this->metrics['timers'][$name] = [
            'start' => microtime(true),
            'memory_start' => memory_get_usage(true)
        ];
    }

    /**
     * End timing a specific operation
     */
    public function endTimer(string $name): float
    {
        if (!isset($this->metrics['timers'][$name])) {
            throw new \InvalidArgumentException("Timer '{$name}' was not started");
        }

        $startTime = $this->metrics['timers'][$name]['start'];
        $startMemory = $this->metrics['timers'][$name]['memory_start'];
        $endTime = microtime(true);
        $endMemory = memory_get_usage(true);

        $duration = $endTime - $startTime;
        $memoryUsed = $endMemory - $startMemory;

        $this->metrics['performance'][$name] = [
            'duration' => $duration,
            'memory_used' => $memoryUsed,
            'memory_peak' => memory_get_peak_usage(true)
        ];

        unset($this->metrics['timers'][$name]);

        return $duration;
    }

    /**
     * Record a database query
     */
    public function recordDatabaseQuery(string $query, float $duration, array $bindings = []): void
    {
        $this->metrics['database']['queries'][] = [
            'query' => $query,
            'duration' => $duration,
            'bindings' => $bindings,
            'timestamp' => microtime(true)
        ];

        $this->metrics['database']['total_queries'] = ($this->metrics['database']['total_queries'] ?? 0) + 1;
        $this->metrics['database']['total_time'] = ($this->metrics['database']['total_time'] ?? 0) + $duration;
    }

    /**
     * Record a cache operation
     */
    public function recordCacheOperation(string $operation, string $key, bool $hit = null, float $duration = null): void
    {
        $this->metrics['cache']['operations'][] = [
            'operation' => $operation,
            'key' => $key,
            'hit' => $hit,
            'duration' => $duration,
            'timestamp' => microtime(true)
        ];

        if ($hit !== null) {
            $this->metrics['cache']['hits'] = ($this->metrics['cache']['hits'] ?? 0) + ($hit ? 1 : 0);
            $this->metrics['cache']['misses'] = ($this->metrics['cache']['misses'] ?? 0) + ($hit ? 0 : 1);
        }
    }

    /**
     * Record an error or exception
     */
    public function recordError(\Throwable $error, array $context = []): void
    {
        $this->metrics['errors'][] = [
            'type' => get_class($error),
            'message' => $error->getMessage(),
            'file' => $error->getFile(),
            'line' => $error->getLine(),
            'trace' => $error->getTraceAsString(),
            'context' => $context,
            'timestamp' => microtime(true)
        ];
    }

    /**
     * Record Core Web Vitals from client-side
     */
    public function recordWebVitals(array $vitals): void
    {
        $this->metrics['web_vitals'] = [
            'cls' => $vitals['cls'] ?? null,
            'fid' => $vitals['fid'] ?? null,
            'lcp' => $vitals['lcp'] ?? null,
            'fcp' => $vitals['fcp'] ?? null,
            'ttfb' => $vitals['ttfb'] ?? null
        ];
    }

    /**
     * Get performance report
     */
    public function getReport(): array
    {
        $this->finalizeMetrics();

        return [
            'summary' => $this->generateSummary(),
            'details' => $this->metrics,
            'recommendations' => $this->generateRecommendations(),
            'score' => $this->calculatePerformanceScore()
        ];
    }

    /**
     * Finalize metrics collection
     */
    private function finalizeMetrics(): void
    {
        $this->metrics['performance']['total_time'] = microtime(true) - $this->startTime;
        $this->metrics['performance']['memory_used'] = memory_get_usage(true) - $this->startMemory;
        $this->metrics['performance']['peak_memory'] = memory_get_peak_usage(true);

        // Server metrics
        if (function_exists('sys_getloadavg')) {
            $this->metrics['server']['load_average'] = sys_getloadavg();
        }

        // Cache hit rate
        if (isset($this->metrics['cache']['hits']) && isset($this->metrics['cache']['misses'])) {
            $totalRequests = $this->metrics['cache']['hits'] + $this->metrics['cache']['misses'];
            $this->metrics['cache']['hit_rate'] = $totalRequests > 0 ?
                $this->metrics['cache']['hits'] / $totalRequests : 0;
        }
    }

    /**
     * Generate performance summary
     */
    private function generateSummary(): array
    {
        $summary = [
            'request_time' => $this->metrics['performance']['total_time'] ?? 0,
            'memory_usage' => $this->formatBytes($this->metrics['performance']['memory_used'] ?? 0),
            'peak_memory' => $this->formatBytes($this->metrics['performance']['peak_memory'] ?? 0),
            'database_queries' => $this->metrics['database']['total_queries'] ?? 0,
            'database_time' => $this->metrics['database']['total_time'] ?? 0,
            'cache_hit_rate' => isset($this->metrics['cache']['hit_rate']) ?
                round($this->metrics['cache']['hit_rate'] * 100, 2) . '%' : 'N/A',
            'errors_count' => count($this->metrics['errors'] ?? [])
        ];

        // Add web vitals if available
        if (isset($this->metrics['web_vitals'])) {
            $summary['web_vitals'] = $this->metrics['web_vitals'];
        }

        return $summary;
    }

    /**
     * Generate performance recommendations
     */
    private function generateRecommendations(): array
    {
        $recommendations = [];

        // Response time recommendations
        $responseTime = $this->metrics['performance']['total_time'] ?? 0;
        if ($responseTime > 1.0) {
            $recommendations[] = [
                'type' => 'warning',
                'category' => 'response_time',
                'message' => 'Response time is over 1 second. Consider optimization.',
                'value' => round($responseTime, 3) . 's'
            ];
        }

        // Memory usage recommendations
        $memoryUsed = $this->metrics['performance']['memory_used'] ?? 0;
        $memoryLimit = $this->parseMemoryLimit(ini_get('memory_limit'));
        if ($memoryUsed > ($memoryLimit * 0.8)) {
            $recommendations[] = [
                'type' => 'warning',
                'category' => 'memory',
                'message' => 'Memory usage is high. Consider increasing memory limit or optimizing code.',
                'value' => $this->formatBytes($memoryUsed)
            ];
        }

        // Database recommendations
        $queryCount = $this->metrics['database']['total_queries'] ?? 0;
        if ($queryCount > 20) {
            $recommendations[] = [
                'type' => 'info',
                'category' => 'database',
                'message' => 'High number of database queries. Consider query optimization or caching.',
                'value' => $queryCount . ' queries'
            ];
        }

        // Cache recommendations
        if (isset($this->metrics['cache']['hit_rate']) && $this->metrics['cache']['hit_rate'] < 0.8) {
            $recommendations[] = [
                'type' => 'info',
                'category' => 'cache',
                'message' => 'Cache hit rate is below 80%. Review caching strategy.',
                'value' => round($this->metrics['cache']['hit_rate'] * 100, 2) . '%'
            ];
        }

        // Error recommendations
        $errorCount = count($this->metrics['errors'] ?? []);
        if ($errorCount > 0) {
            $recommendations[] = [
                'type' => 'error',
                'category' => 'errors',
                'message' => 'Errors occurred during request processing.',
                'value' => $errorCount . ' errors'
            ];
        }

        return $recommendations;
    }

    /**
     * Calculate overall performance score (0-100)
     */
    private function calculatePerformanceScore(): int
    {
        $score = 100;

        // Response time impact
        $responseTime = $this->metrics['performance']['total_time'] ?? 0;
        if ($responseTime > 0.5) $score -= 10;
        if ($responseTime > 1.0) $score -= 20;
        if ($responseTime > 2.0) $score -= 30;

        // Memory usage impact
        $memoryUsed = $this->metrics['performance']['memory_used'] ?? 0;
        $memoryLimit = $this->parseMemoryLimit(ini_get('memory_limit'));
        $memoryPercentage = $memoryUsed / $memoryLimit;
        if ($memoryPercentage > 0.7) $score -= 10;
        if ($memoryPercentage > 0.9) $score -= 20;

        // Database impact
        $queryCount = $this->metrics['database']['total_queries'] ?? 0;
        if ($queryCount > 10) $score -= 5;
        if ($queryCount > 20) $score -= 10;
        if ($queryCount > 50) $score -= 20;

        // Error impact
        $errorCount = count($this->metrics['errors'] ?? []);
        $score -= $errorCount * 10;

        // Cache performance boost
        if (isset($this->metrics['cache']['hit_rate']) && $this->metrics['cache']['hit_rate'] > 0.9) {
            $score += 5;
        }

        return max(0, min(100, $score));
    }

    /**
     * Store metrics for analysis
     */
    public function storeMetrics(): void
    {
        $report = $this->getReport();

        // Store in cache for dashboard
        $this->cache->set('performance_metrics_latest', $report, 3600);

        // Store historical data (simplified)
        $historical = $this->cache->get('performance_metrics_history', []);
        $historical[] = [
            'timestamp' => time(),
            'uri' => $this->metrics['request_uri'],
            'response_time' => $report['summary']['request_time'],
            'memory_usage' => $this->metrics['performance']['memory_used'] ?? 0,
            'score' => $report['score']
        ];

        // Keep only last 100 entries
        if (count($historical) > 100) {
            $historical = array_slice($historical, -100);
        }

        $this->cache->set('performance_metrics_history', $historical, 86400);

        // Log critical performance issues
        if ($report['score'] < 50) {
            $this->app->getLogger()->warning('Poor performance detected', [
                'score' => $report['score'],
                'uri' => $this->metrics['request_uri'],
                'response_time' => $report['summary']['request_time']
            ]);
        }
    }

    /**
     * Get client IP address
     */
    private function getClientIP(): string
    {
        $headers = [
            'HTTP_CF_CONNECTING_IP',     // Cloudflare
            'HTTP_X_FORWARDED_FOR',      // Load balancer/proxy
            'HTTP_X_FORWARDED',          // Proxy
            'HTTP_X_CLUSTER_CLIENT_IP',  // Cluster
            'HTTP_FORWARDED_FOR',        // Proxy
            'HTTP_FORWARDED',            // Proxy
            'REMOTE_ADDR'                // Standard
        ];

        foreach ($headers as $header) {
            if (!empty($_SERVER[$header])) {
                $ips = explode(',', $_SERVER[$header]);
                return trim($ips[0]);
            }
        }

        return 'unknown';
    }

    /**
     * Format bytes into human readable format
     */
    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $factor = floor((strlen((string)$bytes) - 1) / 3);

        return sprintf("%.2f %s", $bytes / pow(1024, $factor), $units[$factor]);
    }

    /**
     * Parse memory limit string to bytes
     */
    private function parseMemoryLimit(string $memoryLimit): int
    {
        $memoryLimit = trim($memoryLimit);
        $last = strtolower($memoryLimit[strlen($memoryLimit)-1]);
        $value = (int) $memoryLimit;

        switch ($last) {
            case 'g': $value *= 1024;
            case 'm': $value *= 1024;
            case 'k': $value *= 1024;
        }

        return $value;
    }
}