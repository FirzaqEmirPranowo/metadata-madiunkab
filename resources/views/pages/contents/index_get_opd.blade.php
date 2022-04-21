@extends('pages.main.layout')
@section('content')

<div class="pagetitle">
  <h1>Daftar Data</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
      <li class="breadcrumb-item">Daftar Data</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Daftar Data</h5>

          {{-- <a 
            @if(Auth::user()->role_id == '1')
            href="/data_superadmin/create"
            @elseif(Auth::user()->role_id == '2')
            href="/data_walidata/create"
            @elseif(Auth::user()->role_id == '3')
            href="/data_produsen/create"
            @endif
            class="btn btn-md btn-primary mb-3 float-right">Tambah
                Data</a> --}}

          {{-- <a href="" class="btn btn-md btn-warning mb-3 float-right" data-bs-toggle="modal" data-bs-target="#basicModal">Import Excel</a>
                <!-- Table with stripped rows -->
                  <div class="modal fade" id="basicModal" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Import Excel</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/data_produsen/import" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="file" name="file" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <button class="btn btn-primary" type="submit" id="button-addon2">Import</button>
                                </div>
                            </form>                    
                        </div>
                      </div>
                    </div>
                  </div>
                  @if(Auth::user()->role_id == '3')
                  @endif --}}
          <!-- Table with stripped rows -->
          <div class="row mb-3">
            <form action="{{ url('/get_all_opdall/cari') }}">
              @csrf
              <div class="col-sm-10">
                <select id="opd_id" name="opd_id" class="form-select" aria-label="Default select example">
                  <option  selected value="">Pilih OPD</option>
                  @foreach($opd as $id => $nama)
                  <option value="{{ $id }}">{{ $nama }}</option>
                  @endforeach
                </select>
              </div>
            <button class="btn btn-primary" type="submit">cari
            </button>
            </form>
          </div>
            
          <a href="{{ url('/data_walidata/export-pdf2') }}" class="btn btn-md btn-danger mb-3 float-right" target="_blank">Unduh Berita Acara</a>

          <table class="table datatable">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Data</th>
                <th scope="col">Produsen (PIC)</th>
                <th scope="col">Jenis</th>
                <th scope="col">Sumber</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              @foreach($data as $dt)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $dt->nama_data }}</td>
                <td>{{ $dt->opd->nama_opd }}</td>
                <td>{{ $dt->jenis_data }}</td>
                <td>{{ $dt->sumber_data }}</td>
                <td>{{ $dt->status->status }}</td>
                <td>
                  {{-- <div class="progress mt-0">
                      <div class="progress-bar" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">75%</div>
                    </div> --}}
                </td>
                {{-- <td>
                    @if(Auth::user()->role_id == '1')
                    <div class="form-group" style="margin-bottom: 0;">
                      <a href="/data_superadmin/edit/{{ $dt->id }}" class="btn btn-primary">Edit</a>
                <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ url('/data_superadmin/destroy/'.$dt->id) }}">

                  @csrf
                  <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                </form>
        </div>
        @elseif(Auth::user()->role_id == '2')
        <div class="form-group" style="margin-bottom: 0;">
          <a href="/data_walidata/edit/{{ $dt->id }}" class="btn btn-primary">Edit</a>
          <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ url('/data_walidata/destroy/'.$dt->id) }}">

            @csrf
            <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
          </form>
        </div>
        @elseif(Auth::user()->role_id == '3')
        <div class="btnConfirm" style="margin-bottom: 0;">
          <a href="/data_produsen/edit/{{ $dt->id }}" class="btn btn-sm btn-primary">Edit</a>
          <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ url('/data_produsen/destroy/'.$dt->id) }}">

            @csrf
            <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
          </form>
          <a href="/data_produsen/setuju/{{ $dt->id }}" class="btn btn-sm btn-success">Setujui</a>
          <a href="/data_produsen/tolak/{{ $dt->id }}" class="btn btn-sm btn-warning">Tolak</a>
        </div>
        @endif


        </td> --}}

        </tr>
        @endforeach
        </tbody>
        </table>
        <!-- End Table with stripped rows -->

      </div>
    </div>

  </div>
  </div>
</section>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  $(function() { 
    $('#opd_id').change(function() {
      window.location.href = '{{ url()->current() }}/?opd_id=' + $(this).val(); 
    });
  });
</script>

@endpush