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
        <img src="logo.webp" loading="lazy" alt="Hexacore Industries LLC Logo" class="h-16 w-auto">
        <div>
          <h3 class="text-2xl font-bold text-white">Hexacore Industries LLC</h3>
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
            <li>
              <a href="dsar.php" class="hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Data Subject Access Request (DSAR) Form
              </a>
            </li>
            <li>
              <a href="cookiepolicy.php" class="hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Cookie Policy
              </a>
            </li>
            <li>
              <a href="terms.php" class="hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline w-5 h-5 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Terms and Conditions
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="text-center text-sm text-gray-500 border-t border-gray-700 pt-6">
      &copy; 2025 Hexacore Industries LLC. All rights reserved.
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