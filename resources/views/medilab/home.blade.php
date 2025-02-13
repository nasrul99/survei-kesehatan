@extends('medilab.index')
@section('content')
    <section id="hero" class="hero section light-background">

        <img src="{{ asset('medilab/assets/img/hero-bg.jpg') }}" alt="" data-aos="fade-in">

        <div class="container position-relative">

            <div class="welcome position-relative" data-aos="fade-down" data-aos-delay="100">
                <h2>WELCOME TO SISEHAT</h2>
                <p>Sistem Informasi Survei Kesehatan Masyarakat</p>
            </div><!-- End Welcome -->

            <div class="content row gy-4">
                <div class="col-lg-4 d-flex align-items-stretch">
                    <div class="why-box" data-aos="zoom-out" data-aos-delay="200">
                        <h3>SISEHAT ?</h3>
                        <p align="justify">
                            Sistem informasi survei kesehatan masyarakat (SISEHAT) yang dikembangkan, memiliki
                            peran penting dalam memantau kesehatan dan kondisi fisik masyarakat.
                            <br/>
                            Dengan adanya sistem ini, masyarakat dapat melakukan deteksi dini
                            terhadap
                            risiko kesehatan, memberikan rekomendasi tindak lanjut yang tepat, serta
                            menyusun
                            program kesehatan preventif yang lebih efektif bagi para masyarakat.
                        </p>
                    </div>
                </div><!-- End Why Box -->

                <div class="col-lg-8 d-flex align-items-stretch">
                    <div class="d-flex flex-column justify-content-center">
                        <div class="row gy-4">

                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box" data-aos="zoom-out" data-aos-delay="300">
                                    <i class="bi bi-clipboard-data"></i>
                                    <h4>Skrining Kesehatan</h4>
                                    <p align="justify">
                                        SISEHAT memungkinkan pemantauan kesehatan secara terintegrasi, mulai dari
                                        pengumpulan
                                        data pemeriksaan kesehatan rutin, pengolahan hasil skrining seperti gula darah,
                                        kolesterol, tekanan darah, asam urat hingga rekomendasi gizi dan kebugaran
                                        fisik.
                                    </p>
                                </div>
                            </div><!-- End Icon Box -->

                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box" data-aos="zoom-out" data-aos-delay="400">
                                    <i class="bi bi-gem"></i>
                                    <h4>Pelaporan</h4>
                                    <p align="justify">
                                        Sistem ini juga memfasilitasi pelaporan yang cepat dan akurat,
                                        memungkinkan manajemen
                                        untuk mengambil keputusan berbasis data terkait kesehatan karyawan. SISEHAT
                                        menyediakan
                                        antarmuka yang mudah digunakan untuk petugas medis dan pihak terkait, sehingga
                                        mereka dapat
                                        melacak
                                        perkembangan kesehatan masyarakat dengan lebih efisien.
                                    </p>
                                </div>
                            </div><!-- End Icon Box -->

                            <div class="col-xl-4 d-flex align-items-stretch">
                                <div class="icon-box" data-aos="zoom-out" data-aos-delay="500">
                                    <i class="bi bi-inboxes"></i>
                                    <h4>Manfaat</h4>
                                    <p align="justify"> Dalam jangka panjang, SISEHAT berpotensi mengurangi biaya
                                        kesehatan masyarakat
                                        karena
                                        berfokus pada pencegahan dan deteksi dini. Sistem ini memberikan laporan
                                        komprehensif
                                        yang dapat membantu pengambilan keputusan strategis terkait investasi dalam
                                        program
                                        kesehatan masyarakat. </p>
                                </div>
                            </div><!-- End Icon Box -->

                        </div>
                    </div>
                </div>
            </div><!-- End  Content-->

        </div>

    </section><!-- /Hero Section -->
@endsection
