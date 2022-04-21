@include('pages.partial.header')
@include('pages.partial.navbar')

@if(Auth::user()->role_id == 1)
@include('pages.partial.sidebar-superadmin')
@elseif(Auth::user()->role_id == '2')
@include('pages.partial.sidebar-walidata')
@elseif(Auth::user()->role_id == '3')
@include('pages.partial.sidebar-produsen')
@endif

 {{-- content --}}
 <main id="main" class="main">
  @yield('content')
 </main>

 @include('pages.partial.footer')

  <!-- Vendor JS Files -->
  <script src="../../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../../assets/vendor/chart.js/chart.min.js"></script>
  <script src="../../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../../assets/vendor/quill/quill.min.js"></script>
  <script src="../../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../../assets/js/main.js"></script>
  @stack('js')

</body>

</html>