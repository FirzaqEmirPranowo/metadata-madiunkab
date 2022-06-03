@extends('pages.main.layout')
@section('content')

<div class="pagetitle">
    <h1>Struktur Data</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item">Daftar OPD</li>
        <li class="breadcrumb-item active">Tambah OPD</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Tambah Data</h5>

            <!-- General Form Elements -->
            <form
              action="/opd/store"
                method="POST">
                @csrf
              <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Nama OPD</label>
                <div class="col-sm-10">
                  <input id="nama_opd" name="nama_opd" type="text" class="form-control">
                </div>
              </div>


              <div class="row mb-3">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">SIMPAN</button>
                </div>
              </div>

            </form><!-- End General Form Elements -->

          </div>
        </div>

      </div>


    </div>
  </section>
  @endsection
