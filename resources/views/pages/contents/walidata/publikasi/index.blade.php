@extends('pages.main.layout')

@section('content')
    <div class="pagetitle">
        <h1>Daftar Data Siap Publikasi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
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
                        <table class="table datatable" id="tablePublikasi">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Data</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Produsen Data</th>
                                <th scope="col">Status</th>
                                <th scope="col">Terakhir diubah</th>
                                <th scope="col">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $dt)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $dt->nama_data }}</td>
                                    <td>{{ $dt->jenis_data }}</td>
                                    <td>{{ $dt->opd->nama_opd }}</td>
                                    <td>{{ $dt->status->status }}</td>
                                    <td>{{ $dt->updated_at->format('d/m/Y H:i A') }}</td>
                                    <td>
                                        <div class="d-flex flex-column gap-2">
                                            <a class="btn btn-outline-primary btn-sm" href="{{route('publikasi.organisasi', $dt->id)}}"><i class="bi bi-info-circle"></i> Detail</a>

                                            @if($dt->status_id == \App\Models\Data::STATUS_TERPUBLIKASI)
                                                <a class="btn btn-outline-success btn-sm" href="{{route('export-data', $dt->id)}}"><i class="bi bi-file-zip"></i> Export</a>

                                                @if(!empty(optional($dt->publikasi)->slug))
                                                    <a href="{{config('ckan_api.url')}}/dataset/{{$dt->publikasi->slug}}" class="btn btn-outline-primary btn-sm" target="_new">CKAN <i class="bi bi-app-indicator"></i></a>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection

@push('js')
    <script>
        $(function() {
            $('#tablePublikasi').on('click', 'a.btn-action', function (e) {
                e.preventDefault();
                Swal.showLoading();
                let completeUrl = $(this).data('completeUrl');
                $.get($(this).data('statusUrl'))
                    .then(function(r) {
                        if (Swal.isLoading()) Swal.hideLoading();

                        if (r.ok === false) {
                            Toast.fire({icon: 'error', title: r.message});
                            return;
                        }

                        Swal.fire({
                            icon: r.code === 1 ? 'info' : 'warning',
                            title: 'Konfirmasi Selesai Proses Verifikasi',
                            text: r.message,
                            showCancelButton: true,
                            cancelButtonText: 'Batal',
                            confirmButtonText: 'Ya, Selesai',
                            showLoaderOnConfirm: true,
                            preConfirm: (comment) => {
                                return $.ajax({url: completeUrl, method: 'PATCH'})
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error(response.message)
                                        }
                                        return response;
                                    })
                                    .catch(error => {
                                        Swal.showValidationMessage(
                                            `Request gagal: ${error}`
                                        )
                                    })
                            },
                            allowOutsideClick: () => !Swal.isLoading()
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Toast.fire({icon: result.value.ok ? 'success' : 'error', title: result.value.message});
                                setTimeout(() => window.location.reload(), 2000);
                            }
                        });
                    });
            })
        });
    </script>
@endpush
