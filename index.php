<?php include 'header.php'; ?>
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
<?php include 'footer.php'; ?>
