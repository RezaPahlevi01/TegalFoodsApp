<nav
  id="navbar"
  class="fixed top-0 left-0 w-full z-50 bg-white pointer-events-auto
         transition-transform duration-300 ease-in-out"
>
  <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">

    <div class="font-bold text-lg text-white">TegalFood</div>

    <ul class="hidden md:flex gap-6 text-white">
      <li><a href="#" class="hover:text-yellow-400">Beranda</a></li>
      <li><a href="/mitra-umkm" class="hover:text-yellow-400">UMKM</a></li>
      <li><a href="#" class="hover:text-yellow-400">Artikel</a></li>
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
    class="hidden md:hidden bg-white border-t"
  >
    <ul class="flex flex-col p-4 gap-4 text-black">
      <li><a href="/welcome">Beranda</a></li>
      <li><a href="/mitra-umkm">UMKM</a></li>
      <li><a href="#">Artikel</a></li>
      <li>
      <a href="{{ route('umkm.register') }}"
        style="position:relative; z-index:9999;"
        class="px-4 py-2 text-white bg-gray-400 rounded-md hover:bg-yellow-400">
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

  menuBtn.addEventListener("click", () => {
    mobileMenu.classList.toggle("hidden");
  });
</script>

