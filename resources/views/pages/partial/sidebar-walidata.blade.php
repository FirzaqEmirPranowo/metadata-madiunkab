<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-heading">Dashboard</li>

        <li class="nav-item">
            <a class="nav-link {{request()->routeIs('d_walidata') ? 'collapse' : 'collapsed' }}" href="/d_walidata">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading">Perencanaan Data</li>


        <li class="nav-item">
            <a class="nav-link {{in_array(request()->path(), ['data_walidata/draft', 'data_walidata/selesai_konfirmasi_walidata', 'data/walidata_tolak_konfirmasi_walidata']) ? 'collapse' : 'collapsed'}}"
               href="/data_walidata/draft">
                <i class="bi bi-check-square"></i><span>Perencanaan Data</span>
            </a>
        </li>

        <li class="nav-heading">Pengumpulan Data</li>

        <li class="nav-item">
            <a class="nav-link {{Str::contains(request()->url(), 'data_walidata/pengumpulan') ? 'collapse' : 'collapsed'}}"
               href="/data_walidata/pengumpulan">
                <i class="bi bi-list-check"></i>
                <span>Pengumpulan Data</span>
            </a>
        </li>

        <li class="nav-heading">Pemeriksaan Data</li>

        <li class="nav-item">
            <a class="nav-link {{Str::contains(request()->url(), 'data_walidata/verifikasi') ? 'collapse' : 'collapsed'}}"
               href="/data_walidata/verifikasi">
                <i class="bi bi-folder-check"></i>
                <span>Verifikasi Data</span>
            </a>
        </li>

        <li class="nav-heading">Publikasi Data</li>
        <li class="nav-item">
            <a class="nav-link {{request()->routeIs('publikasi.*') ? 'collapse' : 'collapsed'}}" href="{{route('publikasi.index')}}">
                <i class="bi bi-send"></i>
                <span>Publikasi Data</span>
            </a>
        </li>

    </ul>

</aside>
