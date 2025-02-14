<header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <marquee>
                    <i class="d-flex align-items-center ms-4"><span>
                            Selamat Datang di Aplikasi SISEHAT - Sistem Informasi Kesehatan Masyarakat
                            </span></i>
                </marquee>
            </div>

        </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-center">

        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="index.blade.php" class="logo d-flex align-items-center me-auto">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 class="sitename">SISEHAT</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ url('/home') }}" class="{{ Request::is('home') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ url('/gallery') }}" class="{{ Request::is('gallery') ? 'active' : '' }}">Info
                            Kesehatan</a>
                    </li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            <a class="cta-btn d-none d-sm-block" href="{{ url('/masyarakat/login') }}">Login</a>

        </div>

    </div>

</header>
