// Modern JavaScript Entry Point
import Alpine from 'alpinejs';
import AOS from 'aos';

// Import CSS
import '../css/app.css';
import 'aos/dist/aos.css';

// Performance monitoring
class PerformanceMonitor {
    constructor() {
        this.metrics = {};
        this.init();
    }

    init() {
        // Core Web Vitals
        this.measureCLS();
        this.measureFID();
        this.measureLCP();

        // Custom metrics
        this.measurePageLoad();
        this.measureResourceTiming();
    }

    measureCLS() {
        let clsValue = 0;
        let clsEntries = [];

        let cls = new PerformanceObserver((entryList) => {
            for (const entry of entryList.getEntries()) {
                if (!entry.hadRecentInput) {
                    clsValue += entry.value;
                    clsEntries.push(entry);
                }
            }
            this.metrics.cls = clsValue;
        });

        cls.observe({entryTypes: ['layout-shift']});
    }

    measureFID() {
        new PerformanceObserver((entryList) => {
            for (const entry of entryList.getEntries()) {
                this.metrics.fid = entry.processingStart - entry.startTime;
                break;
            }
        }).observe({entryTypes: ['first-input']});
    }

    measureLCP() {
        new PerformanceObserver((entryList) => {
            const entries = entryList.getEntries();
            const lastEntry = entries[entries.length - 1];
            this.metrics.lcp = lastEntry.startTime;
        }).observe({entryTypes: ['largest-contentful-paint']});
    }

    measurePageLoad() {
        window.addEventListener('load', () => {
            const navigation = performance.getEntriesByType('navigation')[0];
            this.metrics.pageLoad = navigation.loadEventEnd - navigation.fetchStart;
            this.metrics.domContentLoaded = navigation.domContentLoadedEventEnd - navigation.fetchStart;
        });
    }

    measureResourceTiming() {
        window.addEventListener('load', () => {
            const resources = performance.getEntriesByType('resource');
            this.metrics.resources = resources.map(resource => ({
                name: resource.name,
                duration: resource.duration,
                size: resource.transferSize
            }));
        });
    }

    getMetrics() {
        return this.metrics;
    }
}

// Enhanced Video Background Manager
class VideoBackgroundManager {
    constructor() {
        this.videos = [
            'videos/1.mp4', 'videos/2.mp4', 'videos/3.mp4',
            'videos/4.mp4', 'videos/5.mp4', 'videos/6.mp4'
        ];
        this.currentVideo = 0;
        this.videoElem = document.getElementById('backgroundVideo');
        this.toggleBtn = document.getElementById('toggleVideo');
        this.isPlaying = true;
        this.intervalId = null;

        this.init();
    }

    init() {
        if (!this.videoElem) return;

        this.preloadVideos();
        this.setupEventListeners();
        this.startVideoRotation();
        this.handleVisibilityChange();
    }

    preloadVideos() {
        this.videos.forEach((src, index) => {
            if (index < 3) { // Preload first 3 videos
                const video = document.createElement('video');
                video.src = src;
                video.preload = 'metadata';
            }
        });
    }

    setupEventListeners() {
        this.videoElem.addEventListener('loadeddata', () => {
            this.videoElem.play().catch(console.error);
        });

        this.videoElem.addEventListener('error', () => {
            console.warn(`Video ${this.videos[this.currentVideo]} failed to load`);
            this.nextVideo();
        });

        if (this.toggleBtn) {
            this.toggleBtn.addEventListener('click', () => this.toggle());
        }
    }

    setVideo(index) {
        if (!this.videoElem || !this.videos[index]) return;

        this.videoElem.src = this.videos[index];
        this.videoElem.load();

        if (this.isPlaying) {
            this.videoElem.play().catch(console.error);
        }
    }

    nextVideo() {
        this.currentVideo = (this.currentVideo + 1) % this.videos.length;
        this.setVideo(this.currentVideo);
    }

    startVideoRotation() {
        this.setVideo(this.currentVideo);
        this.intervalId = setInterval(() => this.nextVideo(), 8000); // Increased to 8 seconds
    }

    toggle() {
        if (!this.videoElem || !this.toggleBtn) return;

        if (this.videoElem.paused) {
            this.videoElem.play();
            this.toggleBtn.setAttribute('aria-pressed', 'false');
            this.toggleBtn.textContent = 'Pause background video';
            this.isPlaying = true;
        } else {
            this.videoElem.pause();
            this.toggleBtn.setAttribute('aria-pressed', 'true');
            this.toggleBtn.textContent = 'Play background video';
            this.isPlaying = false;
        }
    }

    handleVisibilityChange() {
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.videoElem?.pause();
                if (this.intervalId) clearInterval(this.intervalId);
            } else if (this.isPlaying) {
                this.videoElem?.play();
                this.startVideoRotation();
            }
        });
    }
}

// Enhanced Navigation Manager
class NavigationManager {
    constructor() {
        this.init();
    }

    init() {
        this.setupDropdowns();
        this.setupMobileMenu();
        this.setupKeyboardNavigation();
        this.setupPdfLinks();
    }

    setupDropdowns() {
        // Enhanced dropdown functionality with better accessibility
        const dropdownTriggers = document.querySelectorAll('[data-dropdown-trigger]');

        dropdownTriggers.forEach(trigger => {
            const dropdownId = trigger.getAttribute('data-dropdown-trigger');
            const dropdown = document.querySelector(`[data-dropdown="${dropdownId}"]`);

            if (!dropdown) return;

            let timeout;

            const show = () => {
                clearTimeout(timeout);
                dropdown.classList.add('show-submenu');
                trigger.setAttribute('aria-expanded', 'true');
            };

            const hide = () => {
                timeout = setTimeout(() => {
                    dropdown.classList.remove('show-submenu');
                    trigger.setAttribute('aria-expanded', 'false');
                }, 150);
            };

            // Mouse events
            trigger.addEventListener('mouseenter', show);
            trigger.addEventListener('mouseleave', hide);
            dropdown.addEventListener('mouseenter', show);
            dropdown.addEventListener('mouseleave', hide);

            // Keyboard events
            trigger.addEventListener('focus', show);
            trigger.addEventListener('blur', hide);

            // Click events for touch devices
            trigger.addEventListener('click', (e) => {
                if (dropdown.classList.contains('show-submenu')) {
                    hide();
                } else {
                    show();
                }
                e.preventDefault();
            });
        });
    }

    setupMobileMenu() {
        const mobileMenuButton = document.querySelector('[data-mobile-menu-button]');
        const mobileMenu = document.querySelector('[data-mobile-menu]');

        if (!mobileMenuButton || !mobileMenu) return;

        mobileMenuButton.addEventListener('click', () => {
            const isOpen = mobileMenu.classList.contains('show');

            if (isOpen) {
                mobileMenu.classList.remove('show');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                document.body.classList.remove('menu-open');
            } else {
                mobileMenu.classList.add('show');
                mobileMenuButton.setAttribute('aria-expanded', 'true');
                document.body.classList.add('menu-open');
            }
        });

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && mobileMenu.classList.contains('show')) {
                mobileMenu.classList.remove('show');
                mobileMenuButton.setAttribute('aria-expanded', 'false');
                document.body.classList.remove('menu-open');
            }
        });
    }

    setupKeyboardNavigation() {
        // Enhanced keyboard navigation for accessibility
        const navLinks = document.querySelectorAll('nav a, [role="menuitem"]');

        navLinks.forEach((link, index) => {
            link.addEventListener('keydown', (e) => {
                switch (e.key) {
                    case 'ArrowDown':
                        e.preventDefault();
                        const nextLink = navLinks[index + 1];
                        if (nextLink) nextLink.focus();
                        break;
                    case 'ArrowUp':
                        e.preventDefault();
                        const prevLink = navLinks[index - 1];
                        if (prevLink) prevLink.focus();
                        break;
                    case 'Home':
                        e.preventDefault();
                        navLinks[0]?.focus();
                        break;
                    case 'End':
                        e.preventDefault();
                        navLinks[navLinks.length - 1]?.focus();
                        break;
                }
            });
        });
    }

    setupPdfLinks() {
        // Enhanced PDF handling with loading states
        document.querySelectorAll('nav a[href="#"]').forEach(link => {
            link.href = 'HexacoreIndustriesCatalog.pdf';
            link.target = '_blank';
            link.rel = 'noopener noreferrer';

            link.addEventListener('click', (e) => {
                // Add loading state
                const originalText = link.textContent;
                link.textContent = 'Loading...';
                link.classList.add('loading');

                setTimeout(() => {
                    link.textContent = originalText;
                    link.classList.remove('loading');
                }, 2000);
            });
        });
    }
}

// PDF Modal Manager
class PDFModalManager {
    constructor() {
        this.modal = document.getElementById('pdfViewerModal');
        this.iframe = document.getElementById('pdfIframe');
        this.closeBtn = document.getElementById('closePdfModal');

        this.init();
    }

    init() {
        if (!this.modal || !this.iframe || !this.closeBtn) return;

        this.setupEventListeners();
        this.attachPdfLinkHandlers();
    }

    setupEventListeners() {
        this.closeBtn.addEventListener('click', () => this.close());

        this.modal.addEventListener('click', (e) => {
            if (e.target === this.modal) this.close();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !this.modal.classList.contains('hidden')) {
                this.close();
            }
        });
    }

    open(pdfFile) {
        this.iframe.src = pdfFile;
        this.modal.classList.remove('hidden');
        this.modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');

        // Focus management for accessibility
        this.closeBtn.focus();
    }

    close() {
        this.modal.classList.add('hidden');
        this.modal.classList.remove('flex');
        this.iframe.src = '';
        document.body.classList.remove('overflow-hidden');
    }

    attachPdfLinkHandlers() {
        const updatePdfLinks = () => {
            document.querySelectorAll('a[data-pdf]').forEach(link => {
                const pdfFile = link.getAttribute('data-pdf');
                if (!pdfFile) return;

                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.open(pdfFile);
                });
            });
        };

        updatePdfLinks();

        // Re-attach handlers for dynamically added links
        const observer = new MutationObserver(updatePdfLinks);
        observer.observe(document.body, { childList: true, subtree: true });
    }
}

// Service Worker Registration
function registerServiceWorker() {
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('SW registered:', registration);

                registration.addEventListener('updatefound', () => {
                    if (confirm('New content available. Reload?')) {
                        window.location.reload();
                    }
                });
            })
            .catch(error => {
                console.log('SW registration failed:', error);
            });
    }
}

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Initialize performance monitoring
    const performanceMonitor = new PerformanceMonitor();
    window.performanceMonitor = performanceMonitor;

    // Initialize managers
    new VideoBackgroundManager();
    new NavigationManager();
    new PDFModalManager();

    // Initialize AOS (Animate On Scroll)
    AOS.init({
        duration: 600,
        easing: 'ease-out-cubic',
        once: true,
        offset: 50
    });

    // Initialize Alpine.js
    Alpine.start();

    // Register service worker for PWA functionality
    registerServiceWorker();

    // Log performance metrics after page load
    window.addEventListener('load', () => {
        setTimeout(() => {
            console.log('Performance Metrics:', performanceMonitor.getMetrics());
        }, 2000);
    });
});

// Global utilities
window.HexacoreUtils = {
    formatCurrency: (amount) => new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(amount),

    debounce: (func, delay) => {
        let timeoutId;
        return (...args) => {
            clearTimeout(timeoutId);
            timeoutId = setTimeout(() => func.apply(null, args), delay);
        };
    },

    throttle: (func, delay) => {
        let inThrottle;
        return (...args) => {
            if (!inThrottle) {
                func.apply(null, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, delay);
            }
        };
    }
};