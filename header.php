<?php require_once __DIR__ . '/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

  <!-- Primary Meta Tags -->
  <title><?= isset($pageTitle) ? sanitize_output($pageTitle) . ' | ' : '' ?>Hexacore Industries | Industrial Fasteners & Supplies</title>
  <meta name="title" content="Hexacore Industries | Industrial Fasteners & Supplies">
  <meta name="description" content="<?= isset($pageDescription) ? sanitize_output($pageDescription) : 'Hexacore Industries - Industrial-grade fasteners for aerospace, marine, defense, and construction. Precision and speed you can rely on.' ?>">
  <meta name="keywords" content="industrial fasteners, aerospace bolts, marine hardware, defense fasteners, construction supplies, stainless steel, titanium, precision engineering">
  <meta name="author" content="Hexacore Industries LLC">
  <meta name="robots" content="index, follow, max-image-preview:large">
  <link rel="canonical" href="<?= url($_SERVER['REQUEST_URI'] ?? '') ?>">

  <!-- Open Graph / Facebook -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= url($_SERVER['REQUEST_URI'] ?? '') ?>">
  <meta property="og:title" content="<?= isset($pageTitle) ? sanitize_output($pageTitle) . ' | ' : '' ?>Hexacore Industries">
  <meta property="og:description" content="<?= isset($pageDescription) ? sanitize_output($pageDescription) : 'Industrial-grade fasteners built for strength and stocked for speed.' ?>">
  <meta property="og:image" content="<?= url('logo.webp') ?>">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:site_name" content="Hexacore Industries">
  <meta property="og:locale" content="en_US">

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="<?= url($_SERVER['REQUEST_URI'] ?? '') ?>">
  <meta name="twitter:title" content="<?= isset($pageTitle) ? sanitize_output($pageTitle) . ' | ' : '' ?>Hexacore Industries">
  <meta name="twitter:description" content="<?= isset($pageDescription) ? sanitize_output($pageDescription) : 'Industrial-grade fasteners built for strength and stocked for speed.' ?>">
  <meta name="twitter:image" content="<?= url('logo.webp') ?>">

  <!-- Favicon and App Icons -->
  <link rel="icon" href="/favicon.ico" type="image/x-icon">
  <link rel="apple-touch-icon" sizes="180x180" href="/icons/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png">
  <link rel="manifest" href="/manifest.json">
  <meta name="theme-color" content="#dc2626">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

  <!-- Preconnect for Performance -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <!-- Critical CSS and Assets -->
  <?php if (config('app.env') === 'local'): ?>
    <script type="module" src="http://localhost:5173/@vite/client"></script>
    <script type="module" src="<?= vite_asset('resources/js/app.js') ?>"></script>
    <link rel="stylesheet" href="<?= vite_asset('resources/css/app.css') ?>">
  <?php else: ?>
    <link rel="stylesheet" href="<?= asset('assets/app.css') ?>">
    <script type="module" src="<?= asset('assets/app.js') ?>" defer></script>
  <?php endif; ?>

  <!-- Fallback Styles for Critical Path -->
  <style>
    /* Critical above-the-fold styles */
    body { font-family: Inter, system-ui, sans-serif; margin: 0; background: #111827; color: #f9fafb; }
    .hero-gradient { background: linear-gradient(135deg, rgba(17, 24, 39, 0.95) 0%, rgba(0, 0, 0, 0.85) 100%); }
    .btn-primary { background: #dc2626; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; display: inline-block; }
    .loading { opacity: 0.7; pointer-events: none; }
  </style>

  <!-- Structured Data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "Hexacore Industries LLC",
    "url": "<?= config('app.url') ?>",
    "logo": "<?= url('logo.webp') ?>",
    "sameAs": [],
    "contactPoint": {
      "@type": "ContactPoint",
      "telephone": "+1-863-670-8586",
      "contactType": "Customer Service",
      "availableLanguage": "English"
    },
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "123 Industrial Blvd",
      "addressLocality": "Tampa",
      "addressRegion": "FL",
      "addressCountry": "US"
    }
  }
  </script>

  <?php if (config('analytics.google_analytics_id')): ?>
  <!-- Google Analytics 4 -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=<?= config('analytics.google_analytics_id') ?>"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '<?= config('analytics.google_analytics_id') ?>', {
      page_title: '<?= isset($pageTitle) ? sanitize_output($pageTitle) : 'Home' ?>',
      custom_map: {'custom_parameter_1': 'industrial_fasteners'}
    });
  </script>
  <?php endif; ?>

  <?php if (config('analytics.google_tag_manager_id')): ?>
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','<?= config('analytics.google_tag_manager_id') ?>');</script>
  <?php endif; ?>
</head>
<body class="h-full bg-gray-900 text-gray-100 font-sans" x-data="{ showTerms: false }">
  <noscript>
    <p>Your browser does not support JavaScript. Please enable it to view this site.</p>
    <?php if (config('analytics.google_tag_manager_id')): ?>
    <!-- Google Tag Manager (noscript) -->
    <iframe src="https://www.googletagmanager.com/ns.html?id=<?= config('analytics.google_tag_manager_id') ?>"
    height="0" width="0" style="display:none;visibility:hidden"></iframe>
    <?php endif; ?>
  </noscript>

  <header class="relative z-50 text-white bg-cover bg-center shadow-xl" style="background-image: url('background.webp');">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex items-center justify-between py-4">
      <div class="flex items-center space-x-4">
        <img class="h-24" src="logo.webp" loading="lazy" alt="Hexacore Industries Logo" width="96" height="96" />
      </div>
      <div class="flex items-center space-x-6">
        <div class="text-right">
          <p class="text-sm">Call us today</p>
          <p class="text-lg font-semibold">
            <a href="tel:8636708586" class="hover:underline" aria-label="Call Hexacore Industries at <?= format_phone('8636708586') ?>">
              <?= format_phone('8636708586') ?>
            </a>
          </p>
        </div>
        <a href="mailto:walter@hexacoreindustries.com"
           class="btn-primary hover:bg-red-700 transition-colors duration-200"
           aria-label="Request a quote from Hexacore Industries">
          Request Quote
        </a>
      </div>
    </div>
  </header>