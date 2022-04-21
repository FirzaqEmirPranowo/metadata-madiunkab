@extends('pages.main.layout')
@section('content')

<div class="pagetitle">
    <h1>Daftar OPD</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item">Daftar OPD</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Daftar OPD</h5>
            
            <a href="/opd/create" class="btn btn-md btn-success mb-3 float-right">Tambah OPD</a>
                
            <a href="" class="btn btn-md btn-success mb-3 float-right" data-bs-toggle="modal" data-bs-target="#basicModal">Import Excel</a>
            <!-- Table with stripped rows -->
              <div class="modal fade" id="basicModal" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Import Excel</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/opd/import" method="post" enctype="multipart/form-data">
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
            <table class="table datatable">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nama Data</th>
                  <th scope="col">Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; ?>
                  @foreach($data as $dt)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $dt->nama_opd }}</td>
                  <td><div class="form-group" style="margin-bottom: 0;">
                    <a href="{{ url('/opd/edit/'.$dt->id) }}" class="btn btn-primary">Edit</a>
                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ url('/opd/destroy/'.$dt->id) }}">
                                
                      @csrf
                      <button type="submit" class="btn btn-sm btn-danger">HAPUS</button>
                  </form>
                </div></td>
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