<!-- ======= Top Bar ======= -->
<div id="topbar" class="d-flex align-items-center fixed-top">
  <div class="container d-flex justify-content-between">
    <div class="contact-info d-flex align-items-center">
      <i class="bi bi-envelope"></i> <a href="mailto:prtamaamalia@gmail.com">prtamaamalia@gmail.com</a>
      <i class="bi bi-phone"></i> +62 12349876
    </div>
    <div class="d-none d-lg-flex social-links align-items-center">
      <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
      <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
      <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
      <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
    </div>
  </div>
</div>

<header id="header" class="fixed-top">
  <div class="container d-flex align-items-center">

    <h1 class="logo me-auto"><a href="/home">Bank Sampah</a></h1>

    <nav id="navbar" class="navbar order-last order-lg-0">
      <ul>
        <li><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/home">Home</a></li>
        @guest
        <li><a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="/login">Login</a></li>
        <li><a class="nav-link" href="/register">Register</a></li>
        @else
        <li><a class="nav-link {{ request()->is('daftarOnline') ? 'active' : '' }}" href="/daftarOnline">Daftar</a></li>

        <li><a class="nav-link {{ request()->is('riwayat-pendaftaran') ? 'active' : '' }}" href="/riwayat-pendaftaran">Riwayat</a></li>

        <li class="nav-item dropdown">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
            {{ Auth::user()->name }}
          </a>

          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <div class="dropdown-divider"></div>
            <a class="dropdown-item d-flex justify-content-center align-items-center" href="/logout">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-1 text-gray-400"></i>
              <span style="margin-left: 5px;">Logout</span>
            </a>
          </div>

        </li>
        @endguest
      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav>
  </div>
</header>