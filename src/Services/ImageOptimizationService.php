<?php

declare(strict_types=1);

namespace Hexacore\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Hexacore\Core\Application;

/**
 * Enterprise image optimization service
 * Handles WebP conversion, resizing, and caching for optimal performance
 */
class ImageOptimizationService
{
    private ImageManager $manager;
    private Application $app;
    private CacheService $cache;
    private string $cachePath;
    private array $allowedFormats = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    private array $webpQuality = 80;
    private array $jpegQuality = 85;

    public function __construct()
    {
        $this->app = Application::getInstance();
        $this->cache = new CacheService();
        $this->manager = new ImageManager(new Driver());
        $this->cachePath = dirname(__DIR__, 2) . '/public/cache/images/';

        // Create cache directory if it doesn't exist
        if (!is_dir($this->cachePath)) {
            mkdir($this->cachePath, 0755, true);
        }
    }

    /**
     * Optimize an image with WebP conversion and resizing
     */
    public function optimize(string $imagePath, array $options = []): array
    {
        if (!file_exists($imagePath)) {
            throw new \InvalidArgumentException("Image file not found: {$imagePath}");
        }

        $originalInfo = pathinfo($imagePath);
        $extension = strtolower($originalInfo['extension']);

        if (!in_array($extension, $this->allowedFormats)) {
            throw new \InvalidArgumentException("Unsupported image format: {$extension}");
        }

        $cacheKey = $this->generateCacheKey($imagePath, $options);
        $cached = $this->cache->get($cacheKey);

        if ($cached !== null) {
            return $cached;
        }

        try {
            $image = $this->manager->read($imagePath);
            $optimizedImages = [];

            // Original optimized version
            $optimizedImages['original'] = $this->processImage(
                $image,
                $imagePath,
                $extension,
                $options
            );

            // WebP version (if enabled and supported)
            if ($this->app->get('performance.webp_conversion_enabled', true)) {
                $optimizedImages['webp'] = $this->processImage(
                    $image,
                    $imagePath,
                    'webp',
                    $options
                );
            }

            // Generate responsive sizes
            if (isset($options['responsive']) && $options['responsive']) {
                $optimizedImages['responsive'] = $this->generateResponsiveSizes(
                    $image,
                    $imagePath,
                    $extension,
                    $options
                );
            }

            // Cache the results
            $this->cache->set($cacheKey, $optimizedImages, 86400); // 24 hours

            return $optimizedImages;
        } catch (\Exception $e) {
            $this->app->getLogger()->error('Image optimization failed', [
                'image' => $imagePath,
                'error' => $e->getMessage()
            ]);

            // Return original image info as fallback
            return [
                'original' => [
                    'path' => $imagePath,
                    'url' => $this->getPublicUrl($imagePath),
                    'width' => null,
                    'height' => null,
                    'size' => filesize($imagePath),
                    'format' => $extension
                ]
            ];
        }
    }

    /**
     * Process a single image with the given format
     */
    private function processImage($image, string $originalPath, string $format, array $options): array
    {
        $originalInfo = pathinfo($originalPath);
        $filename = $originalInfo['filename'];

        // Apply transformations
        if (isset($options['width']) || isset($options['height'])) {
            $image->scaleDown($options['width'] ?? null, $options['height'] ?? null);
        }

        if (isset($options['quality'])) {
            $quality = $options['quality'];
        } else {
            $quality = $format === 'webp' ? $this->webpQuality : $this->jpegQuality;
        }

        // Generate output filename
        $outputFilename = $filename . '_' . md5(serialize($options)) . '.' . $format;
        $outputPath = $this->cachePath . $outputFilename;

        // Save optimized image
        switch ($format) {
            case 'webp':
                $image->toWebP($quality)->save($outputPath);
                break;
            case 'jpeg':
            case 'jpg':
                $image->toJpeg($quality)->save($outputPath);
                break;
            case 'png':
                // PNG compression level (0-9)
                $image->toPng()->save($outputPath);
                break;
            case 'gif':
                $image->toGif()->save($outputPath);
                break;
            default:
                $image->save($outputPath);
        }

        return [
            'path' => $outputPath,
            'url' => $this->getPublicUrl($outputPath),
            'width' => $image->width(),
            'height' => $image->height(),
            'size' => filesize($outputPath),
            'format' => $format
        ];
    }

    /**
     * Generate responsive image sizes
     */
    private function generateResponsiveSizes($image, string $originalPath, string $format, array $options): array
    {
        $responsiveSizes = $options['sizes'] ?? [
            'thumbnail' => ['width' => 150, 'height' => 150],
            'small' => ['width' => 300, 'height' => null],
            'medium' => ['width' => 600, 'height' => null],
            'large' => ['width' => 1200, 'height' => null]
        ];

        $responsiveImages = [];

        foreach ($responsiveSizes as $sizeName => $sizeOptions) {
            $imageClone = clone $image;
            $responsiveImages[$sizeName] = $this->processImage(
                $imageClone,
                $originalPath,
                $format,
                array_merge($options, $sizeOptions)
            );
        }

        return $responsiveImages;
    }

    /**
     * Generate a cache key for the image optimization
     */
    private function generateCacheKey(string $imagePath, array $options): string
    {
        $fileTime = filemtime($imagePath);
        $optionsHash = md5(serialize($options));

        return 'image_opt_' . md5($imagePath) . '_' . $fileTime . '_' . $optionsHash;
    }

    /**
     * Convert file system path to public URL
     */
    private function getPublicUrl(string $filePath): string
    {
        $publicRoot = dirname(__DIR__, 2) . '/public/';
        $relativePath = str_replace($publicRoot, '', $filePath);

        return $this->app->get('app.url', '') . '/' . ltrim($relativePath, '/');
    }

    /**
     * Generate picture element with WebP support and fallbacks
     */
    public function generatePictureElement(string $imagePath, array $options = []): string
    {
        $optimized = $this->optimize($imagePath, $options);

        $alt = $options['alt'] ?? '';
        $classes = $options['class'] ?? '';
        $loading = $options['loading'] ?? 'lazy';

        $html = '<picture>';

        // WebP source
        if (isset($optimized['webp'])) {
            $html .= sprintf(
                '<source srcset="%s" type="image/webp">',
                $optimized['webp']['url']
            );
        }

        // Fallback image
        if (isset($optimized['original'])) {
            $html .= sprintf(
                '<img src="%s" alt="%s" class="%s" loading="%s" width="%d" height="%d">',
                $optimized['original']['url'],
                htmlspecialchars($alt),
                $classes,
                $loading,
                $optimized['original']['width'],
                $optimized['original']['height']
            );
        }

        $html .= '</picture>';

        return $html;
    }

    /**
     * Generate responsive image srcset
     */
    public function generateSrcset(string $imagePath, array $options = []): string
    {
        $options['responsive'] = true;
        $optimized = $this->optimize($imagePath, $options);

        $srcset = [];

        if (isset($optimized['responsive'])) {
            foreach ($optimized['responsive'] as $sizeName => $imageInfo) {
                $srcset[] = $imageInfo['url'] . ' ' . $imageInfo['width'] . 'w';
            }
        }

        return implode(', ', $srcset);
    }

    /**
     * Clean up old cached images
     */
    public function cleanupCache(int $maxAge = 604800): int // 7 days default
    {
        $deleted = 0;
        $cutoffTime = time() - $maxAge;

        if (!is_dir($this->cachePath)) {
            return $deleted;
        }

        $files = scandir($this->cachePath);

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $filePath = $this->cachePath . $file;

            if (is_file($filePath) && filemtime($filePath) < $cutoffTime) {
                if (unlink($filePath)) {
                    $deleted++;
                }
            }
        }

        return $deleted;
    }

    /**
     * Get optimized image URL for use in templates
     */
    public function url(string $imagePath, array $options = []): string
    {
        try {
            $optimized = $this->optimize($imagePath, $options);

            // Prefer WebP if available and browser supports it
            if (isset($optimized['webp']) && $this->supportsWebP()) {
                return $optimized['webp']['url'];
            }

            return $optimized['original']['url'] ?? $this->getPublicUrl($imagePath);
        } catch (\Exception $e) {
            $this->app->getLogger()->warning('Image optimization URL generation failed', [
                'image' => $imagePath,
                'error' => $e->getMessage()
            ]);

            return $this->getPublicUrl($imagePath);
        }
    }

    /**
     * Check if the browser supports WebP
     */
    private function supportsWebP(): bool
    {
        return isset($_SERVER['HTTP_ACCEPT']) &&
               strpos($_SERVER['HTTP_ACCEPT'], 'image/webp') !== false;
    }
}