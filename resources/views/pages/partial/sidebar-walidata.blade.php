<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-heading">Dashboard</li>

    <li class="nav-item">
      <a class="nav-link" href="/d_walidata">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-heading">Perencanaan Data</li>


    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-menu-button-wide"></i><span>Konfirmasi Data</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="components-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
        <li>
          <a class="nav-link {{ Request::segment(2) === 'draft' ? 'active' : null }}" href="/data_walidata/draft">
            <i class="bi bi-circle"></i><span>Draft</span>
          </a>
        </li>
        <li>
          <a class="nav-link {{ Request::segment(2) === 'selesai_konfirmasi_walidata' ? 'active' : null }}" href="/data_walidata/selesai_konfirmasi_walidata">
            <i class="bi bi-circle"></i><span>Disetujui</span>
          </a>
        </li>
        <li>
          <a class="nav-link {{ Request::segment(2) === 'tolak_konfirmasi_walidata' ? 'active' : null }}" href="/data_walidata/tolak_konfirmasi_walidata">
            <i class="bi bi-circle"></i><span>Ditolak</span>
          </a>
        </li>

      </ul>
    </li>
    {{-- <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="/get_all_opdall">
        <i class="bi bi-menu-button-wide"></i><span>Berita Acara</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="components-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
        <li>
          <a class="nav-link {{ Request::segment(1) === 'get_data_opd' ? 'active' : null }}" href="/get_data_opd">
            <i class="bi bi-circle"></i><span>Semua Opd</span>
          </a>
        </li>
        <li>
          <a class="nav-link {{ Request::segment(1) === 'get_all_opdall' ? 'active' : null }}" href="/get_all_opdall">
            <i class="bi bi-circle"></i><span>Opd Tertentu</span>
          </a>
        </li>
      </ul>
    </li> --}}
    <li class="nav-item">
      <a class="nav-link collapsed" href="/get_all_opdall">
        <i class="bi bi-arrow-down-circle-fill"></i>
        <span>Berita Acara</span>
      </a>
    </li>

    <li class="nav-heading">Pengumpulan Data</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/data_walidata/pengumpulan">
        <i class="bi bi-list-check"></i>
        <span>Daftar Data</span>
      </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-heading">Pemeriksaan Data</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/data_walidata/verifikasi">
        <i class="bi bi-folder-check"></i>
        <span>Validasi Data</span>
      </a>
    </li><!-- End Blank Page Nav -->

  </ul>

</aside><!-- End Sidebar-->
