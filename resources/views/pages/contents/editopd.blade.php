@extends('pages.main.layout')
@section('content')

<div class="pagetitle">
    <h1>Data OPD</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item">Daftar OPD</li>
        <li class="breadcrumb-item active">Edit OPD</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Edit Data</h5>

            <!-- General Form Elements -->
            <form 
              action="{{ url('/opd/update/'.$data->id) }}"
                method="POST">
                @csrf
              <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Nama OPD</label>
                <div class="col-sm-10">
                  <input id="nama_opd" name="nama_opd" type="text" class="form-control" value="{{ $data->nama_opd }}">
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