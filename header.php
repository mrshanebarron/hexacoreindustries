<!-- Ensure this site is served over HTTPS and has a proper Content-Security-Policy in production. -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="<?php echo isset($page_description) ? $page_description : 'Hexacore Industries - Industrial-grade fasteners for aerospace, marine, defense, and construction. Precision and speed you can rely on.'; ?>">
  <meta property="og:title" content="<?php echo isset($page_title) ? $page_title : 'Hexacore Industries LLC'; ?>" />
  <meta property="og:description" content="<?php echo isset($page_description) ? $page_description : 'Industrial-grade fasteners built for strength and stocked for speed.'; ?>" />
  <meta property="og:image" content="logo.webp" />
  <meta property="og:type" content="website" />
  <meta name="robots" content="index, follow">
  <title><?php echo isset($page_title) ? $page_title . ' | Hexacore Industries LLC' : 'Hexacore Industries LLC | Industrial Fasteners & Supplies'; ?></title>
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <style>
ul.nav_1, ul.nav_2 {
  display: none;
  opacity: 0;
  transform: translateY(10px);
  transition: opacity 250ms ease, transform 250ms ease;
  position: absolute;
  top: 100%;
  left: 0;
  background-color: #1f2937;
  color: #f9fafb;
  border-radius: 0.5rem;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
  width: max-content;
  max-width: 22rem;
  white-space: nowrap;
  min-width: 10rem;
  max-height: 60vh;
  overflow-y: auto;
  padding: 0.75rem 0.5rem;
  padding-left: 0.75rem;
  padding-right: 0.75rem;
  z-index: 60;
}

ul.nav_1 li + li, ul.nav_2 li + li {
  margin-top: 0.375rem;
}

ul.nav_1 li, ul.nav_2 li {
  width: 100%;
}
ul.nav_1 li a, ul.nav_2 li a {
  width: 100%;
  display: block;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  transition: background-color 200ms ease;
}
ul.nav_1 li a:hover, ul.nav_2 li a:hover {
  background-color: rgba(255, 255, 255, 0.1);
}

.show-submenu > ul.nav_1,
.show-submenu > ul.nav_2 {
  display: block;
  opacity: 1;
  transform: translateY(0);
  left: 0;
}

ul.nav_0 {
  display: flex;
  gap: 1.25rem;
  list-style: none;
  position: relative;
  flex-wrap: wrap;
  padding: 0.5rem 0;
}

ul.nav_0 > li {
  position: relative;
  transition: transform 200ms ease;
}

ul.nav_0 > li:hover {
  transform: translateY(-2px);
}

ul.nav_0 a {
  display: block;
  padding: 0.75rem 1.25rem;
  text-decoration: none;
  color: #f3f4f6;
  font-weight: 600;
  border-radius: 0.375rem;
  transition: background-color 200ms, color 200ms;
}

ul.nav_0 a:hover,
ul.nav_0 a:focus {
  background-color: #e7441c;
  color: #ffffff;
  outline: none;
}

@media (max-width: 767px) {
  ul.nav_1,
  ul.nav_2 {
    position: static !important;
    transform: none !important;
    opacity: 1 !important;
    display: block !important;
    background-color: #1f2937;
    box-shadow: none;
    max-height: none;
    overflow: visible;
    padding: 0;
    margin-top: 0.25rem;
    border-radius: 0.375rem;
  }

  ul.nav_1 > li,
  ul.nav_2 > li {
    padding-left: 1rem;
    padding-right: 1rem;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
  }

  .show-submenu > ul.nav_1,
  .show-submenu > ul.nav_2 {
    transform: none !important;
    left: 0 !important;
  }
}
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('nav a[href="#"]').forEach(a => {
        a.href = 'HexacoreIndustriesCatalog.pdf';
        a.target = '_blank';
      });
    });
  </script>
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      AOS.init({ once: true });
    });
  </script>
</head>
<body class="h-full bg-gray-900 text-gray-100 font-sans" x-data="{ showTerms: false }">
  <noscript>Your browser does not support JavaScript. Please enable it to view this site.</noscript>
  <header class="relative z-50 text-white bg-cover bg-center shadow-xl" style="background-image: url('background.webp');">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex items-center justify-between py-4">
      <div class="flex items-center space-x-4">
        <a href="index.php">
          <img class="h-24" src="logo.webp" loading="lazy" alt="Hexacore Industries LLC Logo" />
        </a>
      </div>
      <div class="flex items-center space-x-6">
        <div class="text-right">
          <p class="text-sm">Call us today</p>
          <p class="text-lg font-semibold"><a href="tel:8636708586" class="hover:underline">863-670-8586</a></p>
        </div>
        <a href="mailto:walter@hexacoreindustries.com" class="bg-white text-red-700 px-4 py-2 rounded font-semibold hover:bg-gray-200">Request Quote</a>
      </div>
    </div>
  </header>