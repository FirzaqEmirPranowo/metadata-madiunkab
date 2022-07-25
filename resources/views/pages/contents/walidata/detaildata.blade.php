@extends('pages.main.layout')
@section('content')

    <div class="pagetitle">
        <h1>Detail Data</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item">Daftar Data</li>
                <li class="breadcrumb-item active">Detail Data</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>

                        <!-- General Form Elements -->
                        <!-- End General Form Elements -->
                        <!-- Default Tabs -->
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                        aria-selected="true"><i class="bi bi-card-list"></i> Detail Data
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                                        type="button" role="tab" aria-controls="profile" aria-selected="false"><i
                                        class="bi bi-clock-history"></i> History Data
                                </button>
                            </li>
                            {{-- <li class="nav-item" role="presentation">
                              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
                            </li> --}}
                        </ul>
                        <div class="tab-content pt-2" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <form @if(Auth::user()->role_id == '1')
                                          action="{{ url('data_administrator/update', $data->id) }}"
                                      @elseif(Auth::user()->role_id == '2')
                                          action="{{ url('data_walidata/update', $data->id) }}"
                                      @elseif(Auth::user()->role_id == '3')
                                          action="{{ url('data_produsen/update', $data->id) }}"
                                      @endif
                                      method="POST">
                                    @csrf
                                    <div class="row mb-3" style="padding-top:20px">
                                        <label for="inputText" class="col-sm-2 col-form-label">Nama Data</label>
                                        <div class="col-sm-10">
                                            <input id="nama_data" name="nama_data" type="text" class="form-control"
                                                   value="{{$data->nama_data}}" disabled>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Jenis Data</label>
                                        <div class="col-sm-10">
                                            <select id="jenis_data" name="jenis_data" class="form-select"
                                                    aria-label="Default select example" value="{{$data->jenis_data}}"
                                                    disabled>
                                                <option selected
                                                        value="{{$data->jenis_data}}">{{$data->jenis_data}}</option>
                                                <option value="Indikator">Indikator</option>
                                                <option value="Variabel">Variabel</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Produsen Data(PIC)</label>
                                        <div class="col-sm-10">
                                            <select id="opd_id" name="opd_id" class="form-select"
                                                    aria-label="Default select example" value="{{$data->opd_id}}"
                                                    disabled>
                                                <option selected
                                                        value="{{$data->opd_id}}">{{$data->opd->nama_opd}}</option>
                                                @foreach($opd as $dt)
                                                    <option value="{{ $dt->id }}">{{ $dt->nama_opd }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Sumber Data</label>
                                        <div class="col-sm-10">
                                            <select id="sumber_data" name="sumber_data" class="form-select"
                                                    aria-label="Default select example" value="{{$data->sumber_data}}"
                                                    disabled>
                                                <option selected
                                                        value="{{$data->sumber_data}}">{{$data->sumber_data}}</option>
                                                <option value="RPJMD">RPJMD</option>
                                                <option value="SPM">SPM</option>
                                                <option value="SDGs">SDGs</option>
                                            </select>
                                        </div>
                                    </div>
                                    @if (!empty($data->alasan) && $data->status_id == \App\Models\Data::STATUS_TOLAK)
                                    <div class="row mb-3">
                                        <label for="inputText" class="col-sm-2 col-form-label">Alasan Ditolak</label>
                                        <div class="col-sm-10">
                                            <textarea id="nama_data" name="nama_data" type="text" class="form-control" disabled>{{$data->alasan}}</textarea>
                                        </div>
                                    </div>
                                    @endif

                                </form>

                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-10">
                                        <a href="{{route('export-data', $data->id)}}" download="" class="btn btn-outline-success"><i class="bi bi-file-zip"></i> Export Data</a>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                @foreach($detail as $dt)
                                    <nav style="--bs-breadcrumb-divider: '>';">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href=""><i
                                                        class="bi bi-clock-history"></i> {{ $dt->name }}</a></li>
                                            <li class="breadcrumb-item active">{{ $dt->description }} :
                                                "{{ $dt->nama_data }}"
                                            </li>
                                            <li class="breadcrumb-item"><a
                                                    href="#">{{ Carbon\Carbon::parse($dt->created_at)->diffForHumans() }}</a>
                                            </li>
                                        </ol>
                                    </nav>
                                @endforeach
                            </div>
                        </div><!-- End Default Tabs -->

                    </div>
                </div>

            </div>


        </div>
    </section>
@endsection
