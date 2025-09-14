<?php
$page_title = 'Data Subject Access Request (DSAR) Form';
$page_description = 'Submit a Data Subject Access Request (DSAR) form to Hexacore Industries - Request access to your personal data in accordance with privacy regulations.';
include 'header.php';
?>
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

    <main class="relative z-10">
      <div class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="bg-gray-900/90 backdrop-blur-sm rounded-lg shadow-2xl p-8" data-aos="fade-up">
          <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-white mb-4">
              Data Subject Access Request (DSAR) Form
            </h1>
            <p class="text-gray-300 text-lg">
              Submit your request to access your personal data in accordance with privacy regulations.
            </p>
          </div>

          <div class="bg-gray-800/50 rounded-lg p-1 backdrop-blur-sm border border-gray-700">
            <iframe
              src="https://app.termly.io/dsar/1d3c923b-999c-423e-8e24-bc81cd16f1ab"
              class="w-full h-[800px] rounded border-0"
              frameborder="0"
              loading="lazy"
              title="Data Subject Access Request Form"
            >
            </iframe>
          </div>

          <div class="mt-8 text-center">
            <p class="text-gray-400 text-sm">
              For questions about this form or our privacy practices, please contact us at
              <a href="mailto:walter@hexacoreindustries.com" class="text-red-400 hover:text-red-300 underline">walter@hexacoreindustries.com</a>
            </p>
          </div>
        </div>
      </div>
    </main>
  </div>

<?php include 'footer.php'; ?>