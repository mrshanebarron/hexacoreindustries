<!-- Ensure this site is served over HTTPS and has a proper Content-Security-Policy in production. -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Hexacore Industries - Industrial-grade fasteners for aerospace, marine, defense, and construction. Precision and speed you can rely on.">
  <meta property="og:title" content="Hexacore Industries" />
  <meta property="og:description" content="Industrial-grade fasteners built for strength and stocked for speed." />
  <meta property="og:image" content="logo.webp" />
  <meta property="og:type" content="website" />
  <meta name="robots" content="index, follow">
  <title>Hexacore Industries | Industrial Fasteners & Supplies</title>
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
        <img class="h-24" src="logo.webp" loading="lazy" alt="Hexacore Industries Logo" />
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
  <!-- Video background container -->
  <div class="fixed inset-0 z-0">
    <video id="backgroundVideo" class="w-full h-full object-cover" autoplay muted playsinline aria-hidden="true" role="presentation" poster="background.webp" preload="none"></video>
    <button id="toggleVideo" class="absolute top-4 right-4 z-50 bg-gray-800 bg-opacity-70 text-white px-3 py-1 rounded focus:outline-none" aria-label="Toggle background video" aria-pressed="false">
      Pause background video
    </button>
    <script>
      // Hardcoded example video list
      const videos = ['videos/1.mp4', 'videos/2.mp4', 'videos/3.mp4', 'videos/4.mp4', 'videos/5.mp4', 'videos/6.mp4'];
      let currentVideo = 0;
      const videoElem = document.getElementById('backgroundVideo');
      function setVideo(idx) {
        videoElem.src = videos[idx];
        videoElem.load();
        videoElem.play();
      }
      setVideo(currentVideo);
      setInterval(() => {
        currentVideo = (currentVideo + 1) % videos.length;
        setVideo(currentVideo);
      }, 5000);
      const toggleBtn = document.getElementById('toggleVideo');
      toggleBtn.addEventListener('click', () => {
        if (videoElem.paused) {
          videoElem.play();
          toggleBtn.setAttribute('aria-pressed', 'false');
          toggleBtn.textContent = 'Pause background video';
        } else {
          videoElem.pause();
          toggleBtn.setAttribute('aria-pressed', 'true');
          toggleBtn.textContent = 'Play background video';
        }
      });
    </script>
  </div>
  <div class="min-h-full">
    <nav class="relative z-20 bg-gradient-to-r from-red-700 to-gray-600 shadow-lg text-white bg-opacity-90" x-data="{ openItem: null }" @click.away="openItem = null" role="navigation">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center w-full">
            <!-- Mobile menu button (hamburger) -->
            <div class="md:hidden flex items-center justify-between px-4 py-2 w-full">
              <button @click="openItem = !openItem" class="text-white focus:outline-none">
                <svg x-show="!openItem" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="openItem" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
            <!-- Desktop menu -->
            <div class="hidden md:block w-full">
              <div class="ml-10 flex items-baseline space-x-4">
                <?php include 'menu.php'; ?>
              </div>
            </div>
          </div>
        </div>
        <!-- Mobile menu, show/hide based on openItem -->
        <div :class="{'block': openItem, 'hidden': !openItem}" class="md:hidden px-4 pb-4">
          <div class="bg-gray-800 text-white rounded-lg shadow-lg divide-y divide-gray-700 overflow-hidden">
            <ul class="flex flex-col divide-y divide-gray-700">
              <?php include 'menu.php'; ?>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <div class="relative z-10 h-screen flex flex-col items-center justify-center text-center px-6 bg-gradient-to-b from-gray-900/70 to-black/90" data-aos="fade-up">
      <div class="max-w-3xl">
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-white mb-6">
          Industrial-Grade Fasteners & Supplies
        </h1>
        <p class="text-lg md:text-xl text-gray-300 mb-8 leading-relaxed">
          Serving professionals with top-tier bolts, nuts, washers, studs, and hardware — built for strength, stocked for speed.
        </p>
        <div class="text-left text-gray-300 space-y-4 mb-8">
          <p><strong>Precision Engineering:</strong> Every fastener in our catalog meets strict quality standards, including ISO 9001 and AS9100 certifications. Aerospace, defense, marine, and construction professionals trust our products for critical applications.</p>
          <p><strong>Massive In-Stock Inventory:</strong> We stock over 80,000 SKUs across stainless steel, titanium, and exotic alloy materials — ready for same-day shipping from our Florida warehouse.</p>
          <p><strong>Custom Fastener Solutions:</strong> Our team works with engineers and procurement specialists to create exact-fit fasteners, whether for aircraft fuselage panels or bridge anchor plates.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <a href="HexacoreIndustriesCatalog.pdf" target="_blank" rel="noopener noreferrer" data-pdf="HexacoreIndustriesCatalog.pdf" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded shadow-lg transition">
            Browse Catalog
          </a>
          <a href="HexacoreIndustriesCatalog.pdf" target="_blank" rel="noopener noreferrer" data-pdf="HexacoreIndustriesCatalog.pdf" class="bg-white hover:bg-gray-100 text-red-700 font-semibold px-6 py-3 rounded shadow-lg transition">
            Request a Quote
          </a>
        </div>
      </div>
    </div>



    <main>
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <!-- Main content can go here -->
      </div>
    </main>
    <section class="relative bg-gray-950 text-gray-200">
      <div class="max-w-7xl mx-auto px-4 py-16 grid md:grid-cols-2 gap-12 items-center">
        <div class="space-y-4" data-aos="fade-right">
          <h2 class="text-3xl font-bold text-white">Why Hexacore?</h2>
          <p class="text-lg text-gray-300 leading-relaxed">
            We supply mission-critical industrial fasteners for aerospace, marine, defense, construction, and infrastructure industries.
            Trusted by professionals. Powered by precision. Ready when you are.
          </p>
          <ul class="space-y-2 text-sm">
            <li>✔ ISO-certified materials and traceability</li>
            <li>✔ Same-day shipping on thousands of SKUs</li>
            <li>✔ Engineering-grade performance guarantees</li>
          </ul>
          <div class="flex gap-4 pt-4">
            <a href="HexacoreIndustriesCatalog.pdf" target="_blank" rel="noopener noreferrer" data-pdf="HexacoreIndustriesCatalog.pdf" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded shadow">Browse Full Catalog</a>
            <a href="mailto:walter@hexacoreindustries.com" class="bg-transparent border border-gray-500 hover:border-red-500 text-gray-300 hover:text-white px-6 py-3 rounded">Contact Sales</a>
          </div>
        </div>
        <div class="rounded-lg overflow-hidden shadow-xl" data-aos="zoom-in">
          <img src="/logo.webp" loading="lazy" alt="Industrial Shipyard" class="w-full h-auto object-cover">
        </div>
      </div>
    </section>
  </div>
<script>
// Handle top-level dropdowns (mouse and keyboard)
document.querySelectorAll('ul.nav_0 > li').forEach(function(li) {
  const open = () => li.classList.add('show-submenu');
  const close = () => li.classList.remove('show-submenu');
  li.addEventListener('mouseenter', open);
  li.addEventListener('mouseleave', close);
  li.addEventListener('focusin', open);
  li.addEventListener('focusout', close);
});

// Handle second-level dropdowns (mouse and keyboard)
document.querySelectorAll('ul.nav_1 > li').forEach(function(li) {
  const open = () => li.classList.add('show-submenu');
  const close = () => li.classList.remove('show-submenu');
  li.addEventListener('mouseenter', open);
  li.addEventListener('mouseleave', close);
  li.addEventListener('focusin', open);
  li.addEventListener('focusout', close);
});

// Handle third-level dropdowns (mouse and keyboard)
document.querySelectorAll('ul.nav_2 > li').forEach(function(li) {
  const open = () => li.classList.add('show-submenu');
  const close = () => li.classList.remove('show-submenu');
  li.addEventListener('mouseenter', open);
  li.addEventListener('mouseleave', close);
  li.addEventListener('focusin', open);
  li.addEventListener('focusout', close);
});
</script>
<footer class="relative z-10 bg-gray-950 text-gray-300 border-t border-gray-700 py-16 mt-12">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-12">
      <div class="flex items-center gap-4">
        <img src="logo.webp" loading="lazy" alt="Hexacore Logo" class="h-16 w-auto">
        <div>
          <h3 class="text-2xl font-bold text-white">Hexacore Industries</h3>
          <p class="text-sm text-gray-400 max-w-xs">
            Precision fasteners engineered for professionals in aerospace, construction, defense, and marine applications.
          </p>
        </div>
      </div>
      <div class="grid grid-cols-2 gap-8 text-sm">
        <div>
          <h4 class="font-semibold text-white mb-2">Contact</h4>
          <ul class="space-y-1">
            <li>
              <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 12l4.243-4.243M6.343 7.343L10.586 12l-4.243 4.243" />
              </svg>
              123 Industrial Blvd, Tampa, FL
            </li>
            <li>
              <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h2l.4 2M7 13h10l1.6-8H5.4M7 13l-1 5h12l-1-5M6 18h12M9 21h6" />
              </svg>
              <a href="tel:8636708586" class="hover:underline">863-670-8586</a>
            </li>
            <li>
              <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m0 0l4-4m-4 4l4 4" />
              </svg>
              walter@hexacoreindustries.com
            </li>
          </ul>
        </div>
        <div>
          <h4 class="font-semibold text-white mb-2">Quick Links</h4>
          <ul class="space-y-1">
            <li>
              <a href="HexacoreIndustriesCatalog.pdf" target="_blank" rel="noopener noreferrer" data-pdf="HexacoreIndustriesCatalog.pdf" class="hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Catalog
              </a>
            </li>
            <li>
              <a href="mailto:walter@hexacoreindustries.com" class="hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79V8a2 2 0 00-2-2H5a2 2 0 00-2 2v4.79a2 2 0 00.553 1.414l7.447 7.447a2 2 0 002.828 0l7.447-7.447A2 2 0 0021 12.79z" />
                </svg>
                Request Quote
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="text-center text-sm text-gray-500 border-t border-gray-700 pt-6">
      &copy; 2025 Hexacore Industries. All rights reserved.
    </div>
  </div>
 </footer>

<!-- Modal for PDF viewing -->
<div id="pdfViewerModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-70">
  <div class="bg-gray-900 rounded-lg shadow-2xl max-w-3xl w-full mx-4 relative flex flex-col">
    <button id="closePdfModal" class="absolute top-2 right-2 text-gray-400 hover:text-white text-2xl font-bold z-10">&times;</button>
    <div class="p-4 flex-1 flex flex-col" style="min-height: 60vh;">
      <iframe id="pdfIframe" src="" class="w-full h-[60vh] rounded border-0" allowfullscreen></iframe>
    </div>
  </div>
</div>

<script>
// PDF Modal logic with PDF.js (viewer setup to follow)
document.addEventListener('DOMContentLoaded', function() {
  // Select all links with data-pdf attribute
  function findPdfLinks() {
    return Array.from(document.querySelectorAll('a[data-pdf]'));
  }
  const modal = document.getElementById('pdfViewerModal');
  const iframe = document.getElementById('pdfIframe');
  const closeBtn = document.getElementById('closePdfModal');
  // Open modal and set PDF
  function openPdfModal(pdfFile) {
    // You can replace this with PDF.js viewer later
    iframe.src = pdfFile;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.classList.add('overflow-hidden');
  }
  // Close modal
  function closePdfModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    iframe.src = '';
    document.body.classList.remove('overflow-hidden');
  }
  closeBtn.addEventListener('click', closePdfModal);
  modal.addEventListener('click', function(e) {
    if (e.target === modal) closePdfModal();
  });
  // Attach click listeners to PDF links
  function attachPdfLinkHandlers() {
    findPdfLinks().forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const pdfFile = link.getAttribute('data-pdf');
        if (pdfFile) openPdfModal(pdfFile);
      });
    });
  }
  attachPdfLinkHandlers();
});
</script>

</body>
</html>
