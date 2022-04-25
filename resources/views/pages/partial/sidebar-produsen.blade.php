<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-heading">Dashboard</li>

    <li class="nav-item ">
      <a class="nav-link collapse" href="/d_produsen">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li><!-- End Dashboard Nav -->

    {{-- <li class="nav-heading">Perencanaan Data</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="/data_produsen">
        <i class="bi bi-check-square"></i>
        <span>Konfirmasi Data</span>
      </a>
    </li><!-- End Dashboard Nav --> --}}
    <li class="nav-heading">Perencanaan Data</li>

    <li class="nav-item">
      <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-check-square"></i><span>Konfirmasi Data</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="components-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
        <li >
          <a class="nav-item {{ Request::segment(2) === 'draft' ? 'active' : null }}" href="/data_produsen/draft">
            <i class="bi bi-circle"></i><span>Draft</span>
          </a>
        </li>
        <li >
          <a class="nav-item {{ Request::segment(2) === 'tolak_konfirmasi' ? 'active' : null }}" href="/data_produsen/tolak_konfirmasi">
            <i class="bi bi-circle"></i><span>Ditolak</span>
          </a>
        </li>
        <li>
          <a class="nav-item {{ Request::segment(2) === 'selesai_konfirmasi' ? 'active' : null }}" href="/data_produsen/selesai_konfirmasi">
            <i class="bi bi-circle"></i><span>Disetujui</span>
          </a>
        </li>
      </ul>
    </li>

    <li class="nav-heading">Pengumpulan Data</li>

    <li class="nav-item">
      <a class="nav-link collapse" href="/data_produsen/verifikasi_data">
        <i class="bi bi-list-check"></i>
        <span>Daftar Data</span>
      </a>
    </li><!-- End Dashboard Nav -->


    

  </ul>

</aside><!-- End Sidebar-->