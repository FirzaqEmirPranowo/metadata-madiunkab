@extends('pages.main.layout')

@section('content')

    <div class="pagetitle">
        <h1>Detail Data: {{$data->nama_data}}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item">Daftar Data</li>
                <li class="breadcrumb-item active">{{$data->nama_data}}</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Detail Data</h5>

                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Nama Data</label>
                            <div class="col-sm-10">
                                <input id="nama_data" name="nama_data" type="text" class="form-control"
                                       value="{{$data->nama_data}}" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Jenis Data</label>
                            <div class="col-sm-10">
                                <select id="jenis_data" name="jenis_data" class="form-select" disabled>
                                    <option value="indikator" {{$data->jenis_data === 'indikator' ? 'checked' : ''}}>
                                        Indikator
                                    </option>
                                    <option value="variabel" {{$data->jenis_data === 'variabel' ? 'checked' : ''}}>
                                        Variabel
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" id="opd_id">Produsen Data(PIC)</label>
                            <div class="col-sm-10">
                                <select id="opd_id" name="opd_id" class="form-select" disabled>
                                    <option selected value="{{$data->opd_id}}">{{$data->opd->nama_opd}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Sumber Data</label>
                            <div class="col-sm-10">
                                <select id="sumber_data" name="sumber_data" class="form-select" aria-label="Sumber Data"
                                        disabled>
                                    <option value="RPJMD" {{ $data->sumber_data === 'RPJMD' ? 'checked' : '' }}>RPJMD
                                    </option>
                                    <option value="SPM" {{ $data->sumber_data === 'SPM' ? 'checked' : '' }}>SPM</option>
                                    <option value="SDGs" {{ $data->sumber_data === 'SDGs' ? 'checked' : '' }}>SDGs
                                    </option>
                                </select>
                            </div>
                        </div>

                        <a href="/data_{{auth()->user()->role->name}}/pengumpulan" class="btn btn-outline-secondary"><i
                                class="bi bi-arrow-left"></i> Kembali</a>

                    </div>
                </div>

            </div>


        </div>
    </section>

    @if($data->relationLoaded('verifikasi'))
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">Revisi Berkas Data</div>
                            <div class="table-responsive">
                                <table class="table table-stripped datatable">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Berkas</th>
                                        <th>Status</th>
                                        <th>Komentar</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data->berkas as $berkas)
                                        @php
                                            $v = $data->verifikasi->firstWhere('field', $berkas['id']);
                                        @endphp
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                <a href="{{route('filepreview', ['payload' => Crypt::encryptString($berkas->path)])}}"
                                                   target="_new">{{$berkas['name'] ?? '-'}} <i
                                                        class="bi bi-link"></i></a></td>
                                            <td><h5><span
                                                        class="badge {{$v && $v->accepted ? 'border-success text-success' : 'border-danger text-danger'}}">{{$v && $v->accepted ? 'Disetujui' : 'Revisi'}}</span>
                                                </h5></td>
                                            <td>
                                                <em>{{$v && $v->comment ? $v->comment : '-'}}</em>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Berkas Data</div>
                        <form class="form-control dropzone" id="berkas">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css"/>
    <script>
        window.Dropzone.autoDiscover = false;
        $(function () {
            let existingBerkas = @json($existingBerkas);
            let berkasDz = new Dropzone('#berkas', {
                paramName: 'berkas',
                url: {{auth()->user()->hasAnyRole('produsen') ? 1 : 0}} != 1 ? '#' : '{{route('upload-berkas', $data->id)}}',
                addRemoveLinks: {{auth()->user()->hasAnyRole('produsen') ? 1 : 0}} === 1,
            });

            @if (auth()->user()->hasAnyRole('produsen'))
            berkasDz.on('removedfile', function (file) {
                $.ajax({
                    url: file.deleteUrl,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                })
            });
            @endif

            berkasDz.on('addedfile', function (file) {
                file.previewElement.addEventListener('click', () => window.open(file.previewUrl))
                if (!('notify' in file)) {
                    Toast.fire({icon: 'success', title: 'Berkas berhasil diunggah'});
                }
            });

            $.each(existingBerkas, function (i, file) {
                file.notify = false;
                berkasDz.files.push(file);
                berkasDz.emit('addedfile', file);
                berkasDz.emit('complete', file);
            });

            $('#btnReadyVerification').on('click', function (e) {
                e.preventDefault();
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Pastikan semua metadata sudah terisi lengkap sebelum memasuki proses verifikasi!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ajukan Verifikasi!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{route('siap-verifikasi', $data->id)}}',
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': '{{csrf_token()}}'
                            }
                        })
                            .then((r) => Swal.fire(r.ok ? 'Sukses' : 'Gagal', r.message, r.ok ? 'success' : 'error'))
                            .catch(() => Swal.fire('Error', 'Terjadi galat saat memproses permintaan', 'error'));
                    }
                })
            });
        });
    </script>
@endpush
