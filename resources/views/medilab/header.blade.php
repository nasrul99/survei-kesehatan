<header id="header" class="header sticky-top">

    <div class="topbar d-flex align-items-center">
        <div class="container d-flex justify-content-center justify-content-md-between">
            <div class="contact-info d-flex align-items-center">
                <marquee>
                    <i class="d-flex align-items-center ms-4"><span>
                            Selamat Datang di aplikasi SIMANTAN - Sistem Informasi Manajemen Skrining Kesehatan Pegawai
                            STT-NF & NF Academy
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
                <h1 class="sitename">SIMANTAN</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>


                    <li><a href="{{ url('/home') }}" class="active">Home<br></a></li>
                    <li><a href="{{ url('/gallery') }}">Gallery</a></li>
                    <li><a href="{{ url('/satgas') }}">Satgas</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            <a class="cta-btn d-none d-sm-block" href="{{ url('/pegawai/login') }}">Login</a>

        </div>

    </div>

</header>
