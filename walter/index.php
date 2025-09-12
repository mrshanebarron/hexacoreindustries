<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Hexacore Industries</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
  <style>
ul.nav_1, ul.nav_2 {
  display: none;
  opacity: 0;
  transition: opacity 150ms ease-in-out;
  position: absolute;
  background-color: #374151;
  color: #f9fafb;
  border-radius: 0.25rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  min-width: 12rem;
  max-width: 16rem;
  z-index: 60;
}

.show-submenu > ul.nav_1,
.show-submenu > ul.nav_2 {
  display: block;
  opacity: 1;
}

ul.nav_0 {
  display: flex;
  gap: 1rem;
  list-style: none;
  position: relative;
  flex-wrap: wrap; /* supports mobile wrapping */
}

ul.nav_0 > li {
  position: relative;
}

ul.nav_0 a {
  display: block;
  padding: 0.5rem 1rem;
  text-decoration: none;
  color: #fff;
}

ul.nav_0 a:hover,
ul.nav_0 a:focus {
  background-color: #e7441c;
  color: #fff;
  outline: none;
}
  </style>
</head>
<body class="h-full bg-gray-900 text-gray-100 font-sans">
  <header class="relative z-50 bg-white bg-opacity-30 backdrop-blur-md text-gray-900 shadow-lg">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex items-center justify-between py-4">
      <div class="flex items-center space-x-4">
        <img class="h-24" src="logo.webp" alt="Hexacore Industries Logo" />
      </div>
      <div class="flex items-center space-x-6">
        <div class="text-right">
          <p class="text-sm">Call us today</p>
          <p class="text-lg font-semibold">(123) 456-7890</p>
        </div>
        <a href="#" class="bg-white text-red-700 px-4 py-2 rounded font-semibold hover:bg-gray-200">Request Quote</a>
      </div>
    </div>
  </header>
  <!-- Video background container -->
  <div class="fixed inset-0 z-0">
    <video id="backgroundVideo" class="w-full h-full object-cover" autoplay muted playsinline></video>
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
    </script>
  </div>
  <div class="min-h-full">
    <nav class="relative z-20 bg-gradient-to-r from-red-700 to-gray-600 shadow-lg text-white bg-opacity-90">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
          <div class="flex items-center">
            <div class="hidden md:block">
              <div class="ml-10 flex items-baseline space-x-4" x-data="{ openItem: null }" @click.away="openItem = null">
                <?php include 'menu.php'; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <div class="relative z-10 h-screen flex items-center justify-center bg-black bg-opacity-60">
      <div class="text-center px-4">
        <div class="inline-flex items-center justify-center bg-yellow-400 text-black font-bold px-6 py-3 rounded-full shadow-lg animate-pulse">
          🚧 Website Under Construction 🚧
        </div>
        <p class="mt-6 text-lg text-gray-200">We are working hard to build something amazing. Check back soon for updates.</p>
      </div>
    </div>

    <main>
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <!-- Main content can go here -->
      </div>
    </main>
  </div>
<script>
// Handle top-level dropdowns
document.querySelectorAll('ul.nav_0 > li').forEach(function(li) {
  li.addEventListener('mouseenter', function() {
    li.classList.add('show-submenu');
  });
  li.addEventListener('mouseleave', function() {
    li.classList.remove('show-submenu');
  });
});

// Handle second-level dropdowns
document.querySelectorAll('ul.nav_1 > li').forEach(function(li) {
  li.addEventListener('mouseenter', function() {
    li.classList.add('show-submenu');
  });
  li.addEventListener('mouseleave', function() {
    li.classList.remove('show-submenu');
  });
});

// Handle third-level dropdowns
document.querySelectorAll('ul.nav_2 > li').forEach(function(li) {
  li.addEventListener('mouseenter', function() {
    li.classList.add('show-submenu');
  });
  li.addEventListener('mouseleave', function() {
    li.classList.remove('show-submenu');
  });
});
</script>
</body>
</html>
