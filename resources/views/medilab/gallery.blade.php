@extends('medilab.index')
@section('content')
    <section id="gallery" class="gallery section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Gallery</h2>
            <p>Info Grafis Kesehatan bagi Masyarakat</p>
        </div><!-- End Section Title -->

        <div class="container-fluid" data-aos="fade-up" data-aos-delay="100">

            <div class="row g-0">

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="{{ asset('medilab/assets/img/gallery/gallery-1.png') }}" class="glightbox"
                           data-gallery="images-gallery">
                            <img src="{{ asset('medilab/assets/img/gallery/gallery-1.png') }}" alt="" class="img-fluid">
                        </a>
                    </div>
                </div><!-- End Gallery Item -->

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="{{ asset('medilab/assets/img/gallery/gallery-2.png') }}" class="glightbox"
                           data-gallery="images-gallery">
                            <img src="{{ asset('medilab/assets/img/gallery/gallery-2.png') }}" alt="" class="img-fluid">
                        </a>
                    </div>
                </div><!-- End Gallery Item -->

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="{{ asset('medilab/assets/img/gallery/gallery-3.png') }}" class="glightbox"
                           data-gallery="images-gallery">
                            <img src="{{ asset('medilab/assets/img/gallery/gallery-3.png') }}" alt="" class="img-fluid">
                        </a>
                    </div>
                </div><!-- End Gallery Item -->

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="{{ asset('medilab/assets/img/gallery/gallery-4.png') }}" class="glightbox"
                           data-gallery="images-gallery">
                            <img src="{{ asset('medilab/assets/img/gallery/gallery-4.png') }}" alt="" class="img-fluid">
                        </a>
                    </div>
                </div><!-- End Gallery Item -->

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="{{ asset('medilab/assets/img/gallery/gallery-5.png') }}" class="glightbox"
                           data-gallery="images-gallery">
                            <img src="{{ asset('medilab/assets/img/gallery/gallery-5.png') }}" alt="" class="img-fluid">
                        </a>
                    </div>
                </div><!-- End Gallery Item -->

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="{{ asset('medilab/assets/img/gallery/gallery-6.png') }}" class="glightbox"
                           data-gallery="images-gallery">
                            <img src="{{ asset('medilab/assets/img/gallery/gallery-6.png') }}" alt="" class="img-fluid">
                        </a>
                    </div>
                </div><!-- End Gallery Item -->

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="{{ asset('medilab/assets/img/gallery/gallery-7.png') }}" class="glightbox"
                           data-gallery="images-gallery">
                            <img src="{{ asset('medilab/assets/img/gallery/gallery-7.png') }}" alt="" class="img-fluid">
                        </a>
                    </div>
                </div><!-- End Gallery Item -->

                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item">
                        <a href="{{ asset('medilab/assets/img/gallery/gallery-8.png') }}" class="glightbox"
                           data-gallery="images-gallery">
                            <img src="{{ asset('medilab/assets/img/gallery/gallery-8.png') }}" alt="" class="img-fluid">
                        </a>
                    </div>
                </div><!-- End Gallery Item -->

            </div>

        </div>

    </section>
@endsection
