<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<title>PT.Yutaka Karawang Indonesia</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
	<link rel="icon" href="{{ asset('template/img/yutaka logo.jpg') }}" type="image/x-icon"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Montserrat:300,400,500,700" rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link href="{{ asset('lib/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Libraries CSS Files -->
    <link href="{{ asset('lib/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ asset('lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{ asset('lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">
    <link href="{{ asset('lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{ asset('lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">
</head>
<body>
<header id="header">
    <div class="container-fluid">
        <div id="logo" class="pull-left">
            <a href="#intro"><img src="{{ asset('img/yutaka logo.jpg')}}" alt="" title="" /></a>
            <h1><a href="#intro" class="scrollto">PT.Yutaka KI</a></h1>
        </div>
        <nav id="nav-menu-container">
            <ul class="nav-menu">
                <li class="menu-active"><a href="#intro">Beranda</a></li>
                <li><a href="#about">Tentang</a></li>
                <li><a href="#services">Struktur Perusahaan</a></li>
                <li><a href="#portfolio">Portfolio</a></li>
                <li><a href="#clients">Kontak</a></li>
                <li>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/home') }}">Home</a>
                        @else
                            <a href="{{ route('login') }}">Login Karyawan</a>
                        @endauth
                    @endif
                </li>
            </ul>
        </nav>
    </div>
</header>


  <!--==========================
    Intro Section
  ============================-->
  <section id="intro">
    <div class="intro-container">
      <div id="introCarousel" data-ride="carousel">

        <div class="carousel-inner" role="listbox">

          <div class="carousel-item active">
            <div class="carousel-container">
              <div class="carousel-content">
                <h2>PT. Yutaka Karawang Indonesia</h2>
                <p>Pt. Yutaka Karawang Indonesia merupakan perusahaan yang bergerak dibidang General Kontraktor dan jasa menyediakan segala kebutuhan industri juga sebagai salah satu perusahaan support tenaga ahli dan kami juga menyediakan jasa Develop Control Manufacturing.</p>
              </div>
            </div>
          </div>
      </div>
    </div>
  </section><!-- #intro -->

  <main id="main">

    <!--==========================
      About Us Section
    ============================-->
    <section id="about">
      <div class="container">

        <header class="section-header">
          <h3>Tentang Kami</h3>
          <p>Visi Misi Perusahaan Kami.</p>
        </header>

        <div class="row about-cols">

        <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
            <div class="about-col">
                <div class="img">
                <img src="{{ asset('img/about-vision.jpg')}}" alt="" class="img-fluid">
                <div class="icon"><i class="ion-ios-eye-outline"></i></div>
                </div>
                <h2 class="title"><a href="#">Visi</a></h2>
                <p class="text-center">
                    Menjadi salah satu perusahaan yang unggul dan terpercaya
                </p>
            </div>
            </div>

            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.1s">
                <div class="about-col">
                  <div class="img">
                    <img src="{{ asset('img/about-plan.jpg')}}" alt="" class="img-fluid">
                    <div class="icon"><i class="ion-ios-list-outline"></i></div>
                  </div>
                  <h2 class="title"><a href="#">Kebijakan Mutu dan Lingkungan</a></h2>
                  <p>
                    1. Meningkatkan kepuasan pelanggan dengan menghasilkan dan mengirim barang yang berkualitas, tepat waktu dan efisien.
                  </p>
                  <p>
                    2. Memenuhi serta mentaati peraturan perundang-undangan pemerintah dan persyaratan lain yang terkait dengan standar mutu dan lingkungan.
                  </p>
                  <p>
                    3. Perbaiki Secara Berkesinambungan untuk peningkatan kinerja mutu dan lingkungan.
                  </p>
                </div>
              </div>

          <div class="col-md-4 wow fadeInUp">
            <div class="about-col">
              <div class="img">
                <img src="{{ asset('img/about-mission.jpg')}}" alt="" class="img-fluid">
                <div class="icon"><i class="ion-ios-speedometer-outline"></i></div>
              </div>
              <h2 class="title"><a href="#">Misi</a></h2>
              <p>
                Mewujudkan kepuasan konsumen atau pelanggan terhadap produk dan jasa yang berkualitas, melalui inovasi, Sistem manajemen dan sumberdaya manusia yang baik
              </p>
            </div>
          </div>

        </div>

      </div>
    </section>

    <!--==========================
      Services Section
    ============================-->
    <section id="services">
      <div class="container">

        <header class="section-header wow fadeInUp">
          <h3>Struktur Perusahaan</h3>
          <p>Struktur organisasi diperusahaan kami.</p>
        </header>
        <div class="align-center">
            <img src="img/organisasi.jpg" alt="Struktur Organisasi">
        </div>
      </div>
    </section><!-- #services -->

    <!--==========================
      Portfolio Section
    ============================-->
    <section id="portfolio"  class="section-bg" >
      <div class="container">

        <header class="section-header">
          <h3 class="section-title">Portfolio Kami</h3>
        </header><br>

        {{-- <div class="row">
          <div class="col-lg-12">
            <ul id="portfolio-flters">
              <li data-filter="*" class="filter-active">All</li>
              <li data-filter=".filter-app">App</li>
              <li data-filter=".filter-card">Card</li>
              <li data-filter=".filter-web">Web</li>
            </ul>
          </div>
        </div> --}}

        <div class="row portfolio-container">

            <div class="col-lg-4 col-md-6 portfolio-item filter-web wow fadeInUp" data-wow-delay="0.1s">
                <div class="portfolio-wrap">
                  <figure>
                    <img src="{{ asset('img/portfolio/canopy1.jpg')}}" class="img-fluid" alt="">
                    <a href="{{ asset('img/portfolio/canopy1.jpg')}}" class="link-preview" data-lightbox="portfolio" data-title="Web 3" title="Preview"><i class="ion ion-eye"></i></a>
                  </figure>

                  <div class="portfolio-info">
                    <h4><a href="#">Pemasangan Canopy</a></h4>
                    <p>PT.SSK Cikarang</p>
                  </div>
                </div>
              </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-app wow fadeInUp" data-wow-delay="0.2s">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{ asset('img/portfolio/pipa1.jpg')}}" class="img-fluid" alt="">
                <a href="i{{ asset('img/portfolio/pipa1.jpg')}}" class="link-preview" data-lightbox="portfolio" data-title="App 2" title="Preview"><i class="ion ion-eye"></i></a>
              </figure>

              <div class="portfolio-info">
                <h4><a href="#">Support Pipa</a></h4>
                <p>PT.SSK Cikarang</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card wow fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{ asset('img/portfolio/conveyor1.jpg')}}" class="img-fluid" alt="">
                <a href="{{ asset('img/portfolio/conveyor1.jpg')}}" class="link-preview" data-lightbox="portfolio" data-title="Card 2" title="Preview"><i class="ion ion-eye"></i></a>
              </figure>

              <div class="portfolio-info">
                <h4><a href="#">Pembuatan Conveyor</a></h4>
                <p>PT.MMWI</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web wow fadeInUp" data-wow-delay="0.1s">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{ asset('img/portfolio/cctower1.jpg')}}" class="img-fluid" alt="">
                <a href="{{ asset('img/portfolio/cctower1.jpg')}}" class="link-preview" data-lightbox="portfolio" data-title="Web 2" title="Preview"><i class="ion ion-eye"></i></a>
              </figure>

              <div class="portfolio-info">
                <h4><a href="#">Cleaning Cooling Tower</a></h4>
                <p>PT.Bekaert</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-app wow fadeInUp" data-wow-delay="0.2s">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{ asset('img/portfolio/handrail.jpg')}}" class="img-fluid" alt="">
                <a href="{{ asset('img/portfolio/handrail.jpg')}}" class="link-preview" data-lightbox="portfolio" data-title="App 3" title="Preview"><i class="ion ion-eye"></i></a>
              </figure>

              <div class="portfolio-info">
                <h4><a href="#">Pemasangan HandRail</a></h4>
                <p>PT.Bekaert</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card wow fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{ asset('img/portfolio/spool.jpg')}}" class="img-fluid" alt="">
                <a href="{{ asset('img/portfolio/spool.jpg')}}" class="link-preview" data-lightbox="portfolio" data-title="Card 1" title="Preview"><i class="ion ion-eye"></i></a>
              </figure>

              <div class="portfolio-info">
                <h4><a href="#">Service Mesin Spool</a></h4>
                <p>PT. Bekaert</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-card wow fadeInUp" data-wow-delay="0.1s">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{ asset('img/portfolio/pipa2.jpg')}}" class="img-fluid" alt="">
                <a href="{{ asset('img/portfolio/pipa2.jpg')}}" class="link-preview" data-lightbox="portfolio" data-title="Card 3" title="Preview"><i class="ion ion-eye"></i></a>
              </figure>

              <div class="portfolio-info">
                <h4><a href="#">Pemasangan Pipa</a></h4>
                <p>PT.Bekaert</p>
              </div>
            </div>
          </div>


          <div class="col-lg-4 col-md-6 portfolio-item filter-app wow fadeInUp">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{ asset('img/portfolio/cor.jpg')}}" class="img-fluid" alt="">
                <a href="{{ asset('img/portfolio/cor.jpg')}}" data-lightbox="portfolio" data-title="App 1" class="link-preview" title="Preview"><i class="ion ion-eye"></i></a>
              </figure>

              <div class="portfolio-info">
                <h4><a href="#">Pengecoran Jalan</a></h4>
                <p>PT.SSK Karawang</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 portfolio-item filter-web wow fadeInUp" data-wow-delay="0.2s">
            <div class="portfolio-wrap">
              <figure>
                <img src="{{ asset('img/portfolio/rebag.jpg')}}" class="img-fluid" alt="">
                <a href="{{ asset('img/portfolio/rebag.jpg')}}" class="link-preview" data-lightbox="portfolio" data-title="Web 1" title="Preview"><i class="ion ion-eye"></i></a>
              </figure>

              <div class="portfolio-info">
                <h4><a href="#">Rebag Dramix</a></h4>
                <p>PT.Bekaert</p>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- #portfolio -->

    <!--==========================
      Clients Section
    ============================-->
    <section id="clients" class="wow fadeInUp">
      <div class="container">

        <header class="section-header">
          <h3>Perusahaan Yang Bekerjasama</h3>
        </header>

        <div class="owl-carousel clients-carousel">
          <img src="{{ asset('img/clients/client-1.png')}}" alt="">
          <img src="{{ asset('img/clients/client-2.png')}}" alt="">
          <img src="{{ asset('img/clients/client-3.png')}}" alt="">
          <img src="{{ asset('img/clients/client-4.png')}}" alt="">
          <img src="{{ asset('img/clients/client-5.png')}}" alt="">
          {{-- <img src="{{ asset('img/clients/client-6.png')}}" alt="">
          <img src="{{ asset('img/clients/client-7.png')}}" alt="">
          <img src="{{ asset('img/clients/client-8.png')}}" alt=""> --}}
        </div>

      </div>
    </section><!-- #clients -->

    <!--==========================
      Contact Section
    ============================-->
    <section id="contact" class="section-bg wow fadeInUp">
      <div class="container">

        <div class="section-header">
          <h3>Kontak Kami</h3>
          <p>Silahkan Hubungi kontak dibawah ini</p>
        </div>

        <div class="row contact-info">

          <div class="col-md-4">
            <div class="contact-address">
            <a href="https://goo.gl/maps/6x1wd9xhjHht8dLU7">
              <i class="ion-ios-location-outline"></i>
              <h3>Alamat</h3>
              <address>Jl. Pasundan No.46, Adiarsa Barat, Kec.Karawang Barat, Kab.Karawang, Jawa Barat </address>
            </a>
            </div>
          </div>

          <div class="col-md-4">
            <div class="contact-email">
              <i class="ion-ios-email-outline"></i>
              <h3>Email</h3>
              <p><a href="mailto:info@example.com">pt.yki@yutakakarawang.com</a></p>
            </div>
          </div>

        </div>
      </div>
    </section><!-- #contact -->

  </main>
  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <!-- JavaScript Libraries -->
  <script src="{{ asset('lib/jquery/jquery.min.js')}}"></script>
  <script src="{{ asset('lib/jquery/jquery-migrate.min.js')}}"></script>
  <script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('lib/easing/easing.min.js')}}"></script>
  <script src="{{ asset('lib/superfish/hoverIntent.js')}}"></script>
  <script src="{{ asset('lib/superfish/superfish.min.js')}}"></script>
  <script src="{{ asset('lib/wow/wow.min.js')}}"></script>
  <script src="{{ asset('lib/waypoints/waypoints.min.js')}}"></script>
  <script src="{{ asset('lib/counterup/counterup.min.js')}}"></script>
  <script src="{{ asset('lib/owlcarousel/owl.carousel.min.js')}}"></script>
  <script src="{{ asset('lib/isotope/isotope.pkgd.min.js')}}"></script>
  <script src="{{ asset('lib/lightbox/js/lightbox.min.js')}}"></script>
  <script src="{{ asset('lib/touchSwipe/jquery.touchSwipe.min.js')}}"></script>
  <!-- Contact Form JavaScript File -->
  <script src="{{ asset('contactform/contactform.js')}}"></script>

  <!-- Template Main Javascript File -->
  <script src="{{ asset('js/main.js')}}"></script>

</body>
</html>
