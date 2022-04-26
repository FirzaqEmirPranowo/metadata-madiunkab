@extends('pages.main.layout')
@section('content')

<div class="pagetitle">
    <h1>Daftar Data</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item">Daftar Data</li>
        <li class="breadcrumb-item active">Edit Data</li>
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
            <form @if(Auth::user()->role_id == '1')
                action="{{ url('data_superadmin/update', $data->id) }}"
                @elseif(Auth::user()->role_id == '2')
                action="{{ url('data_walidata/update', $data->id) }}"
                @elseif(Auth::user()->role_id == '3')
                action="{{ url('data_produsen/update', $data->id) }}"
                @endif
                method="POST">
                @csrf
              <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label">Nama Data</label>
                <div class="col-sm-10">
                  <input id="nama_data" name="nama_data" type="text" class="form-control" value="{{$data->nama_data}}">
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Jenis Data</label>
                <div class="col-sm-10">
                  <select id="jenis_data" name="jenis_data" class="form-select" aria-label="Default select example" value="{{$data->jenis_data}}">
                    <option selected value="{{$data->jenis_data}}">{{$data->jenis_data}}</option>
                    <option value="Indikator">Indikator</option>
                    <option value="Variabel">Variabel</option>
                  </select>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Produsen Data(PIC)</label>
                <div class="col-sm-10">
                  <select id="opd_id" name="opd_id" class="form-select" aria-label="Default select example" value="{{$data->opd_id}}">
                    <option  selected value="{{$data->opd_id}}">{{$data->opd->nama_opd}}</option>
                    @foreach($opd as $dt)
                    <option value="{{ $dt->id }}">{{ $dt->nama_opd }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Sumber Data</label>
                <div class="col-sm-10">
                  <select id="sumber_data" name="sumber_data" class="form-select" aria-label="Default select example" value="{{$data->sumber_data}}">
                    <option selected value="{{$data->sumber_data}}">{{$data->sumber_data}}</option>
                    <option value="RPJMD">RPJMD</option>
                    <option value="SPM">SPM</option>
                    <option value="SDGs">SDGs</option>
                  </select>
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