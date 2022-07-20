@extends('pages.main.layout')
@section('content')

    <div class="pagetitle">
        @include('sweetalert::alert')
        <h1>Daftar Data</h1>
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

                        <a href="/data_walidata/create" class="btn btn-md btn-primary mb-3 float-right"><i class="bi bi-plus-circle"></i> Tambah Data</a>

                        {{-- inport --}}
                        <a href="" class="btn btn-md btn-success mb-3 float-right" data-bs-toggle="modal"
                           data-bs-target="#verticalycentered">
                            <i class="bi bi-file-earmark-spreadsheet"></i> Import Data
                        </a>

                        <a class="btn btn-md btn-outline-primary mb-3 float-right" href="/get_all_opdall">
                            <i class="bi bi-arrow-down-circle-fill"></i>
                            <span>Berita Acara</span>
                        </a>


                        <ul class="nav nav-tabs nav-tabs-bordered d-flex text-center" role="tablist">
                            <li class="nav-item flex-fill" role="presentation">
                                <a href="/data_walidata/draft" class="nav-link {{!isset($status) ? 'active' : ''}} w-100" id="draft-tab"><i class="bi bi-list-ul"></i> Draft</a>
                            </li>

                            <li class="nav-item flex-fill" role="presentation">
                                <a href="/data_walidata/selesai_konfirmasi_walidata" class="nav-link w-100 {{isset($status) && $status == 'disetujui' ? 'active' : ''}}" id="disetujui-tab"><i class="bi bi-list-check"></i> Disetujui</a>
                            </li>

                            <li class="nav-item flex-fill" role="presentation">
                                <a href="/data_walidata/tolak_konfirmasi_walidata" class="nav-link w-100 {{isset($status) && $status == 'ditolak' ? 'active' : ''}}" id="ditolak-tab"><i class="bi bi-list-nested me-2"></i> Ditolak</a>
                            </li>
                        </ul>

                        <div class="tab-content p-2">
                            <div class="tab-pane active" id="tab-draft">
                                <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Data</th>
                                <th scope="col">Produsen (PIC)</th>
                                <th scope="col">Jenis</th>
                                <th scope="col">Sumber</th>
                                <th scope="col">Dibuat</th>
                                <th scope="col">Status</th>
                                <th scope="col">Opsi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $no = 1; ?>
                            @foreach($data as $dt)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $dt->nama_data }}</td>
                                    <td>{{ $dt->nama_opd }}</td>
                                    <td>{{ $dt->jenis_data }}</td>
                                    <td>{{ $dt->sumber_data }}</td>
                                    <td>{{ $dt->name }}</td>
                                    <td>
                                        @if($dt->status_id == 3)
                                            <span class="badge bg-secondary"><i class="bi bi-collection me-1"></i>{{ $dt->status }}</span>
                                        @elseif($dt->status_id == 1)
                                            <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>{{ $dt->status }}</span>
                                        @elseif($dt->status_id == 2)
                                            <span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i>{{ $dt->status }}</span>
                                        @else
                                            <span class="badge bg-primary"><i class="bi bi-info-circle me-1"></i>{{ $dt->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btnConfirm" style="margin-bottom: 0;">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <a href="{{ route('detail_walidata',['id'=>$dt->id])  }}"
                                                           class="btn btn-sm btn-warning" style="color: white"
                                                           data-bs-placement="bottom" title="Detail Data"><i
                                                                class="bi bi-info-circle"></i></a>
                                                    </td>
                                                    @if (isset($status))
                                                        <td>
                                                            <form id="restore-data-{{ $dt->id }}"
                                                                  action="{{ url('/data_walidata/restore/'.$dt->id) }}">

                                                                <button type="button" class="btn btn-sm btn-success"
                                                                        onclick="confirmRestore('restore-data-{{ $dt->id }}')"
                                                                        data-bs-placement="bottom" title="Restore Data">
                                                                    <i class="bi bi-arrow-repeat"></i></button>
                                                            </form>
                                                        </td>
                                                    @else
                                                        <td>
                                                            <a href="{{ route('edit_walidata',['id'=>$dt->id])  }}"
                                                               class="btn btn-sm btn-primary" data-bs-placement="bottom"
                                                               title="Edit Data"><i class="bi bi-pencil-fill"></i></a>
                                                        </td>
                                                        <td>
                                                            <form id="delete-pegawai-{{ $dt->id }}"
                                                                  action=" {{ url('/data_walidata/destroy/'.$dt->id) }}">

                                                                <button type="button" class="btn btn-sm btn-danger"
                                                                        onclick="confirmDelete('delete-pegawai-{{ $dt->id }}')"
                                                                        data-bs-placement="bottom" title="Hapus Data"><i
                                                                        class="bi bi-trash"></i></button>
                                                            </form>
                                                        </td>
                                                    @endif
                                                </tr>
                                            </table>
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

            </div>
        </div>
    </section>

    <div class="modal fade" id="verticalycentered" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-weight: bold; color:green">IMPORT DATA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h6 class="modal-title"><i class="bi bi-caret-right-fill"></i>Sebelum import
                        data menggunakan file excel silahkan mengunduh template data melalui tombol berikut
                        <form action="{{ url('/up-download', 'DATA') }}">
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="bi bi-download"></i> Template Data
                            </button>
                        </form>
                    </h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#alasan">Lanjutkan
                    </button>
                </div>
            </div>
        </div>
    </div><!-- End Vertically centered Modal-->
    {{-- modal input --}}
    <div class="modal fade" id="alasan" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-weight: bold; color:green">IMPORT DATA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/data_walidata/import" method="post"
                          enctype="multipart/form-data">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="file" name="file" class="form-control"
                                   placeholder="Recipient's username"
                                   aria-label="Recipient's username"
                                   aria-describedby="button-addon2">
                            <button class="btn btn-primary" type="submit" id="button-addon2">
                                Import
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        function filterFunction() {
            var input, filter, ul, li, a, i;
            input = document.getElementById("myInput");
            filter = input.value.toUpperCase();
            div = document.getElementById("myDropdown");
            a = div.getElementsByTagName("a");
            for (i = 0; i < a.length; i++) {
                txtValue = a[i].textContent || a[i].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    a[i].style.display = "";
                } else {
                    a[i].style.display = "none";
                }
            }
        }
    </script>

    <script type="text/javascript">
        function confirmRestore(form_id) {
            swal({
                title: 'Apakah Anda Yakin Mengembalikan Data Menjadi DRAFT?',
                text: "Anda akan mengembalikan data menjadi status Draft!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                buttons: true,
                confirmButtonText: 'Yes, delete it!'
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#' + form_id).submit();
                    } else {

                    }
                });
        };

        function confirmDelete(item_id) {
            swal({
                title: 'Apakah Anda Yakin Menghapus Data?',
                text: "Anda Tidak Akan Dapat Mengembalikannya!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                buttons: true,
                confirmButtonText: 'Yes, delete it!'
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#' + item_id).submit();
                    } else {
                        // swal("Cancelled Successfully");
                    }
                });
        };

    </script>

@endsection
