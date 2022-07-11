@extends('portal.landingpage.layout')

@section('content')

<div class="container">
    <div class="page-banner home-banner">
        <div class="row align-items-center flex-wrap-reverse h-100">
            <div class="col-md-6 py-5 wow fadeInLeft">
                <h1 class="mb-4">Data Terbuka Pemerintah Kabupaten Madiun</h1>
                <p class="text-lg text-grey mb-5">Di sini Anda bisa akses koleksi data dan artikel terlengkap di Kabupaten Madiun dengan cepat, mudah, dan akurat dibantu berbagai fitur bermanfaat.</p>
                <a href="#cari" data-role="smoothscroll" class="btn btn btn-ungu btn-split">Cari Data <div class="fab"><span class="mai-play"></span></div></a>
            </div>
            <div class="col-md-6 py-5 wow zoomIn">
                <div class="img-fluid text-center">
                    <img src="landing-assets/img/data.png" width="110%" class="rounded" alt="">
                </div>
            </div>
        </div>
        <a href="#cari" class="btn-scroll" data-role="smoothscroll"><span class="mai-arrow-down"></span></a>
    </div>
</div>


<!-- Blog -->
<div class="page-section">
{{--    <div class="container">--}}
{{--        <div class="text-center wow fadeInUp">--}}
{{--            <div class="subhead">Highlight Data</div>--}}
{{--            <h2 class="title-section">Portal Data</h2>--}}
{{--            <div class="divider mx-auto"></div>--}}
{{--        </div>--}}

{{--        <div class="row mt-5">--}}
{{--            <div class="col-lg-4 py-3 wow fadeInUp">--}}
{{--                <div class="card-blog">--}}
{{--                    <div class="header">--}}
{{--                        <div class="post-thumb">--}}
{{--                            <img src="../landing-assets/img/blog/blog-1.jpg" alt="">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="body">--}}
{{--                        <h5 class="post-title"><a href="/berita">Data makanan sehat</a></h5>--}}
{{--                        <div class="post-date">Posted on <a href="/berita">27 Jan 2022</a></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-lg-4 py-3 wow fadeInUp">--}}
{{--                <div class="card-blog">--}}
{{--                    <div class="header">--}}
{{--                        <div class="post-thumb">--}}
{{--                            <img src="../landing-assets/img/blog/blog-2.jpg" alt="">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="body">--}}
{{--                        <h5 class="post-title"><a href="/berita">Data Transportasi</a></h5>--}}
{{--                        <div class="post-date">Posted on <a href="/berita">27 Jan 2022</a></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-lg-4 py-3 wow fadeInUp">--}}
{{--                <div class="card-blog">--}}
{{--                    <div class="header">--}}
{{--                        <div class="post-thumb">--}}
{{--                            <img src="../landing-assets/img/blog/blog-3.jpg" alt="">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="body">--}}
{{--                        <h5 class="post-title"><a href="/berita">Data Teknologi</a></h5>--}}
{{--                        <div class="post-date">Posted on <a href="/berita">27 Jan 2020</a></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-12 mt-4 text-center wow fadeInUp">--}}
{{--                <a href="blog.html" class="btn btn-ungu">Selengkapnya</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</div>

<div class="page-section banner-seo-check" id="cari">
    <div class="wrap bg-image">
        <div class="container text-center">
            <div class="row justify-content-center wow fadeInUp">
                <div class="col-lg-8">
                    <h3>Pencarian Dataset</h3>
                    <form action="{{route('dataset')}}">
                        <input type="text" class="form-control" name="q" placeholder="Cari data">
                        <button type="submit" class="btn btn-ungu">Cari</button>
                    </form>
                </div>
            </div>
        </div> <!-- .container -->
    </div> <!-- .wrap -->
</div> <!-- .page-section -->

<div class="page-section">
    <div class="container">
        <div class="row pt-0">
            <div class="col-lg-12">
                <div class="text-center wow fadeInUp">
                    <div class="subhead">Highlight Data</div>
                    <h2 class="title-section">Portal Data</h2>
                    <div class="divider mx-auto"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="card-service wow fadeInUp">
                    <div class="header">
                        <img style="width: 100px;" src="../landing-assets/img/services/covid19.gif" alt="">
                    </div>
                    <div class="body">
                        <h5 class="text-secondary">Covid 19</h5>
                        <a href="{{route('dataset')}}" class="btn btn-ungu">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card-service wow fadeInUp">
                    <div class="header">
                        <img style="width: 100px;" src="../landing-assets/img/services/kependudukan.gif" alt="">
                    </div>
                    <div class="body">
                        <h5 class="text-secondary">Kependudukan</h5>
                        <a href="{{route('dataset')}}" class="btn btn-ungu">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card-service wow fadeInUp">
                    <div class="header">
                        <img style="width: 100px;" src="../landing-assets/img/services/kesehatan.gif" alt="">
                    </div>
                    <div class="body">
                        <h5 class="text-secondary">Kesehatan</h5>
                        <a href="{{route('dataset')}}" class="btn btn-ungu">Lihat</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="card-service wow fadeInUp">
                    <div class="header">
                        <img style="width: 100px;" src="../landing-assets/img/services/keuangan.gif" alt="">
                    </div>
                    <div class="body">
                        <h5 class="text-secondary">Keuangan</h5>
                        <a href="{{route('dataset')}}" class="btn btn-ungu">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card-service wow fadeInUp">
                    <div class="header">
                        <img style="width: 100px;" src="../landing-assets/img/services/lingkungan.gif" alt="">
                    </div>
                    <div class="body">
                        <h5 class="text-secondary">Lingkungan Hidup</h5>
                        <a href="{{route('dataset')}}" class="btn btn-ungu">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card-service wow fadeInUp">
                    <div class="header">
                        <img style="width: 100px;" src="../landing-assets/img/services/pariwisata.gif" alt="">
                    </div>
                    <div class="body">
                        <h5 class="text-secondary">Pariwisata&Kebudayaan</h5>
                        <a href="{{route('dataset')}}" class="btn btn-ungu">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card-service wow fadeInUp">
                    <div class="header">
                        <img style="width: 100px;" src="../landing-assets/img/services/pekerjaan.gif" alt="">
                    </div>
                    <div class="body">
                        <h5 class="text-secondary">Pekerjaan Umum</h5>
                        <a href="{{route('dataset')}}" class="btn btn-ungu">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card-service wow fadeInUp">
                    <div class="header">
                        <img style="width: 100px;" src="../landing-assets/img/services/pendidikan.gif" alt="">
                    </div>
                    <div class="body">
                        <h5 class="text-secondary">Pendidikan</h5>
                        <a href="{{route('dataset')}}" class="btn btn-ungu">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card-service wow fadeInUp">
                    <div class="header">
                        <img style="width: 100px;" src="../landing-assets/img/services/bencana.gif" alt="">
                    </div>
                    <div class="body">
                        <h6 class="text-secondary">Penanggulangan Bencana</h6>
                        <a href="{{route('dataset')}}" class="btn btn-ungu">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card-service wow fadeInUp">
                    <div class="header">
                        <img style="width: 100px;" src="../landing-assets/img/services/perhubungan.gif" alt="">
                    </div>
                    <div class="body">
                        <h5 class="text-secondary">Perhubungan</h5>
                        <a href="{{route('dataset')}}" class="btn btn-ungu">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card-service wow fadeInUp">
                    <div class="header">
                        <img style="width: 100px;" src="../landing-assets/img/services/sosial.gif" alt="">
                    </div>
                    <div class="body">
                        <h5 class="text-secondary">Sosial</h5>
                        <a href="{{route('dataset')}}" class="btn btn-ungu">Lihat</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card-service wow fadeInUp">
                    <div class="header">
                        <img style="width: 100px;" src="../landing-assets/img/services/teknologi.gif" alt="">
                    </div>
                    <div class="body">
                        <h5 class="text-secondary">Teknologi</h5>
                        <a href="{{route('dataset')}}" class="btn btn-ungu">Lihat</a>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- .container -->
</div> <!-- .page-section -->

@endsection
