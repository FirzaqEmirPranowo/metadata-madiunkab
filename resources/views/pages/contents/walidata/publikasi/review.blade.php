@extends('pages.main.layout')

@section('title', 'Publikasi Data - Organisasi')

@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Penyebarluasan Data - Review</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Daftar Publikasi</li>
                <li class="breadcrumb-item">Data - {{$data->nama_data}}</li>
                <li class="breadcrumb-item">Review</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Review</h5>

                        <div class="mb-3">
                            @include('pages.contents.walidata.publikasi.tab-header')
                        </div>

                        <form method="POST" action="{{route('publikasi.publish', $data->id)}}" id="formPublikasi">
                            @csrf
                            <div class="tab-content pt-2" id="borderedTabJustifiedContent">
                                <div class="tab-pane fade active show" id="tab-org" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="row mb-3">
                                        <label for="nama_data" class="col-sm-2 col-form-label">Nama Data</label>
                                        <div class="col-sm-10">
                                            <input id="nama_data" name="judul_kegiatan" type="text" class="form-control" placeholder="Nama Data" value="{{$data->nama_data}}" disabled>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="org_id" class="col-sm-2 col-form-label">Organisasi/OPD</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" id="org_id" name="org_id" disabled>
                                                <option value="-1" {{empty(optional($data->publikasi)->org_id) ? 'selected' : ''}}>- Pilih Data -</option>
                                                @foreach($orgs as $org)
                                                    <option value="{{$org['id']}}" {{old('org_id', optional($data->publikasi)->org_id) == $org['id'] ? 'selected' : ''}}>{{$org['display_name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="title" class="col-sm-2 col-form-label">Judul Dataset</label>
                                        <div class="col-sm-10">
                                            <input id="title" name="title" type="text" class="form-control" placeholder="Judul Dataset" value="{{old('title', optional($data->publikasi)->title ?? $data->nama_data)}}" readonly>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="description" class="col-sm-2 col-form-label">Deskripsi <i class="bi bi-markdown"></i></label>
                                        <div class="col-sm-10">
                                            <div class="" id="description_editor" spellcheck="false"></div>
                                            <textarea class="d-none" name="description" id="description" disabled>{{old('description', optional($data->publikasi)->description)}}</textarea>
                                        </div>
                                    </div>

                                    <br>
                                    <br>

                                    <div class="row mb-3">
                                        <label for="visibility" class="col-sm-2 col-form-label">Visibilitas</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" name="visibility" id="visibility" disabled>
                                                <option value="0" {{old('visibility', optional($data->publikasi)->visibility) == 0 ? 'selected' : ''}}>Private</option>
                                                <option value="1" {{old('visibility', optional($data->publikasi)->visibility) == 1 ? 'selected' : ''}}>Publik</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-2">Berkas</div>
                                        <div class="col-sm-10">

                                            <table class="table table-stripped table-responsive">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Berkas</th>
                                                    <th>Ukuran</th>
                                                    <th>Diunggah pada</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($data->berkas as $berkas)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>
                                                            <a href="{{route('filepreview', ['payload' => Crypt::encryptString($berkas->path)])}}"
                                                               target="_new">{{$berkas['name'] ?? '-'}} <i class="bi bi-link"></i>
                                                            </a>
                                                        </td>
                                                        <td>{{Storage::exists($berkas->path) ? \App\Models\Berkas::humanFileSize(Storage::size($berkas->path)) : 'Data Hilang'}}</td>
                                                        <td>{{$berkas['created_at'] ? $berkas['created_at']->format('d/m/Y H:i') : '-'}}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    @if($data->status_id == \App\Models\Data::STATUS_SIAP_PUBLIKASI)
                                        <div class="row mb-3">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-10">
                                                <button class="btn btn-lg btn-outline-primary" id="btnConfirmation"><i class="bi bi-send-check"></i> Publikasi</button>
                                            </div>
                                        </div>
                                    @endif

                                    <a href="{{route('publikasi.index')}}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('js')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/quilljs-markdown@latest/dist/quilljs-markdown-common-style.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quilljs-markdown@latest/dist/quilljs-markdown.js"></script>
    <script>
        $(function() {
            let description = new Quill('#description_editor', {
                readOnly: true,
                theme: 'snow'
            });
            new QuillMarkdown(description);

            description.setText('{{old('description', optional($data->publikasi)->description)}}')

            description.on('text-change', function () {
                $('#description').val(description.getText());
            });

            $('#btnConfirmation').on('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Konfirmasi publikasi ke CKAN?',
                    text: 'Data ini akan diunggah ke CKAN, untuk mengubah informasi yang sudah terunggah Anda harus mengubah melalui CKAN.',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    confirmButtonText: 'Publikasi',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formPublikasi').submit();
                    }
                });
            });
        });

        function humanFileSize(bytes, si=false, dp=1) {
            const thresh = si ? 1000 : 1024;

            if (Math.abs(bytes) < thresh) {
                return bytes + ' B';
            }

            const units = si
                ? ['kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
                : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
            let u = -1;
            const r = 10**dp;

            do {
                bytes /= thresh;
                ++u;
            } while (Math.round(Math.abs(bytes) * r) / r >= thresh && u < units.length - 1);


            return bytes.toFixed(dp) + ' ' + units[u];
        }
    </script>
@endpush
