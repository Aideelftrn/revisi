<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Bank Sampah </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <!-- JS Bootstrap -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link href="/custom-style-v2/assets/img/logo.png" rel="icon">
  <link href="/custom-style-v2/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="/custom-style-v2/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="/custom-style-v2/assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="/custom-style-v2/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/custom-style-v2/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/custom-style-v2/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/custom-style-v2/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="/custom-style-v2/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="/custom-style-v2/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="/custom-style-v2/assets/css/style.css" rel="stylesheet">

  <style>
    .table th a {
      color: black;
      text-decoration: none;
    }

    .table th a:hover {
      text-decoration: underline;
    }
  </style>


</head>

<body>
  @include('includes.navbar')
  <section id="riwayat" class="appointment section-bg">
    <div class="container">

      <div class="section-title">
        <h2>RIWAYAT NASABAH</h2>
      </div>
      @yield('contents')
    </div>
  </section>
  @include('includes.footer')

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="/custom-style-v2/assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="/custom-style-v2/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/custom-style-v2/assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="/custom-style-v2/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="/custom-style-v2/assets/vendor/php-email-form/validate.js"></script>
  <script src="{{ asset('custom-style') }}/vendor/jquery/jquery.min.js"></script>
  <script src="{{ asset('custom-style') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <script src="{{ asset('custom-style') }}/vendor/jquery-easing/jquery.easing.min.js"></script>

  <script src="{{ asset('custom-style') }}/js/sb-admin-2.min.js"></script>
  <script src="{{ asset('custom-style') }}/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="{{ asset('custom-style') }}/vendor/datatables/dataTables.bootstrap4.min.js"></script>



  <!-- Template Main JS File -->
  <script src="/custom-style-v2/assets/js/main.js"></script>

</body>

</html>