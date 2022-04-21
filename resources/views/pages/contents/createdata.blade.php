@extends('pages.main.layout')
@section('content')

<div class="pagetitle">
    <h1>Daftar Data</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item">Daftar Data</li>
        <li class="breadcrumb-item active">Tambah Data</li>
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
            <form @if(Auth::user()->role_id == '1')
                action="/data_superadmin/store"
                @elseif(Auth::user()->role_id == '2')
                action="/data_walidata/store"
                @elseif(Auth::user()->role_id == '3')
                action="/data_produsen/store"
                @endif
                method="POST">
                @csrf
              <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Nama Data</label>
                <div class="col-sm-10">
                  <input id="nama_data" name="nama_data" type="text" class="form-control">
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Jenis Data</label>
                <div class="col-sm-10">
                  <select id="jenis_data" name="jenis_data" class="form-select" aria-label="Default select example">
                    <option selected>Pilih</option>
                    <option value="Indikator">Indikator</option>
                    <option value="Variabel">Variabel</option>
                  </select>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Produsen Data (PIC)</label>
                <div class="col-sm-10">
                  @if(Auth::user()->role_id == '1')
                  <select id="opd_id" name="opd_id" class="form-select" aria-label="Default select example">
                    <option value="" disabled selected hidden>Pilih</option>
                    @foreach($opd as $dt)
                    <option value="{{ $dt->id }}">{{ $dt->nama_opd }}</option>
                    @endforeach
                  </select>
                @elseif(Auth::user()->role_id == '2')
                <select id="opd_id" name="opd_id" class="form-select" aria-label="Default select example">
                  <option value="" disabled selected hidden>Pilih</option>
                  @foreach($opd as $dt)
                  <option value="{{ $dt->id }}">{{ $dt->nama_opd }}</option>
                  @endforeach
                </select>
                @elseif(Auth::user()->role_id == '3')
                <select id="opd_id" name="opd_id" class="form-select" aria-label="Default select example">
                  <option value="" disabled selected hidden>Pilih</option>
                  @foreach($data as $dt)
                  <option value="{{ $dt->id }}">{{ $dt->nama_opd }}</option>
                  @endforeach
                </select>
                @endif
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Sumber Data</label>
                <div class="col-sm-10">

                  <select id="sumber_data" name="sumber_data" class="form-select" aria-label="Default select example">
                    <option selected>Pilih</option>
                    <option value="RPJMD">RPJMD</option>
                    <option value="SPM">SPM</option>
                    <option value="SDGs">SDGs</option>
                  </select>
                </div>
              </div>


              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Submit Button</label>
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">Submit Form</button>
                </div>
              </div>

            </form><!-- End General Form Elements -->

          </div>
        </div>

      </div>

      
    </div>
  </section>
  @endsection