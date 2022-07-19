@extends('pages.main.layout')

@section('content')
    @include('sweetalert::alert')
    <div class="pagetitle">
        <h1>Daftar Data Siap Verifikasi</h1>
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
                        <table class="table datatable" id="tableVerifikasiData">
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
                                            <a class="btn btn-outline-primary btn-sm" href="/data_walidata/verifikasi/{{$dt->id}}/berkas"><i class="bi bi-file-binary-fill"></i> Verifikasi Berkas</a>
                                            <a class="btn btn-outline-info btn-sm" href="/data_walidata/verifikasi/{{$dt->id}}/{{strtolower($dt->jenis_data)}}"><i class="bi bi-bar-chart"></i> Verifikasi MetaData {{$dt->jenis_data}}</a>
                                            <a class="btn btn-outline-primary btn-sm btn-action" href="#" data-status-url="{{route('verifikasi.status', $dt->id)}}" data-complete-url="{{route('verifikasi.complete', $dt->id)}}"><i class="bi bi-three-dots"></i> Selesaikan?</a>
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
            $('#tableVerifikasiData').on('click', 'a.btn-action', function (e) {
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
