<nav
  id="navbar"
  class="fixed top-0 left-0 w-full z-50 bg-white pointer-events-auto
         transition-transform duration-300 ease-in-out"
>
  <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">

    <div class="font-bold text-lg text-white">TegalFood</div>

    <ul class="hidden md:flex gap-6 text-white">
      <li><a href="{{ route('welcome') }}" class="relative after:absolute after:-bottom-1 after:left-0
          after:w-0 after:h-[2px] after:bg-yellow-400
          after:transition-all after:duration-300
          hover:after:w-full hover:text-yellow-400">Beranda</a></li>
      <li><a href="/mitra-umkm" class="relative after:absolute after:-bottom-1 after:left-0
          after:w-0 after:h-[2px] after:bg-yellow-400
          after:transition-all after:duration-300
          hover:after:w-full hover:text-yellow-400">UMKM</a></li>
      <li><a href="{{ route('blog.index') }}" class="relative after:absolute after:-bottom-1 after:left-0
          after:w-0 after:h-[2px] after:bg-yellow-400
          after:transition-all after:duration-300
          hover:after:w-full hover:text-yellow-400">Artikel</a></li>
    </ul>

    <div class="hidden md:block">
      <a href="{{ route('umkm.register') }}" class="relative z-50 px-4 py-2 text-white rounded-md hover:bg-yellow-400">
        Daftar UMKM
      </a>
    </div>

    <button id="menuBtn" class="md:hidden text-white text-2xl">
      ☰
    </button>
  </div>

  <div
    id="mobileMenu"
    class="md:hidden
         absolute top-16 left-0 w-full
         bg-white/95 backdrop-blur-lg
         rounded-b-3xl
         shadow-2xl
         overflow-hidden
         max-h-0 opacity-0
         transition-all duration-300 ease-out"
  >
    <ul class="flex flex-col p-6 gap-6 text-gray-800 font-semibold">
      <li><a href="{{ route('welcome') }}" class="flex items-center gap-3 hover:text-yellow-500">🏠 Beranda</a></li>
      <li><a href="/mitra-umkm" class="flex items-center gap-3 hover:text-yellow-500">🏪 UMKM</a></li>
      <li><a href="{{ route('blog.index') }}" class="flex items-center gap-3 hover:text-yellow-500">📰 Artikel</a></li>
      <a href="{{ route('umkm.register') }}"
        style="position:relative; z-index:9999;"
        class="px-4 py-2 text-white bg-yellow-400 rounded-md hover:bg-yellow-500 justify-center flex">
          Daftar UMKM
      </a>
      </li>
    </ul>
  </div>
</nav>



<script>
  let lastScrollTop = 0;
  const navbar = document.getElementById("navbar");
  
  window.addEventListener("scroll", () => {
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > lastScrollTop) {
      // Scroll ke bawah
      navbar.classList.add("-translate-y-full");
    } else {
      // Scroll ke atas
      navbar.classList.remove("-translate-y-full");
    }

    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
  });
</script>

<script>
  const menuBtn = document.getElementById("menuBtn");
  const mobileMenu = document.getElementById("mobileMenu");

  let menuOpen = false;

  menuBtn.addEventListener("click", () => {
    menuOpen = !menuOpen;

    if (menuOpen) {
      mobileMenu.classList.remove("max-h-0", "opacity-0");
      mobileMenu.classList.add("max-h-[300px]", "opacity-100");

      // Stop navbar auto-hide
      navbar.classList.remove("-translate-y-full");
    } else {
      mobileMenu.classList.add("max-h-0", "opacity-0");
      mobileMenu.classList.remove("max-h-[300px]", "opacity-100");
    }
  });
</script>

