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
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Daftar Data</h5>

                        <ul class="nav nav-tabs nav-tabs-bordered d-flex text-center" role="tablist">
                            <li class="nav-item flex-fill" role="presentation">
                                <a href="/data_produsen/draft" class="nav-link {{!isset($status) ? 'active' : ''}} w-100" id="draft-tab">Draft</a>
                            </li>

                            <li class="nav-item flex-fill" role="presentation">
                                <a href="/data_produsen/selesai_konfirmasi" class="nav-link w-100 {{isset($status) && $status == 'disetujui' ? 'active' : ''}}" id="disetujui-tab">Disetujui</a>
                            </li>

                            <li class="nav-item flex-fill" role="presentation">
                                <a href="/data_produsen/tolak_konfirmasi" class="nav-link w-100 {{isset($status) && $status == 'ditolak' ? 'active' : ''}}" id="ditolak-tab">Ditolak</a>
                            </li>
                        </ul>

                        <div class="tab-content p-2">
                            <div class="tab-pane active" id="tab-draft">
                                @if(isset($status) && $status === 'disetujui')
                                    @if($draft == 0)
                                        <form id="berita-acara" action="{{ url('/data_produsen/export-pdf') }}">
                                             <button type="button" class="btn btn-sm btn-success" onclick="confirmBeritacara('berita-acara')"><i class="bi bi-download"></i> Unduh Berita Acara</button>
                                        </form>
                                    @elseif($draft >= 0)
                                        <form id="berita-acara"></form>
                                        <div class="modal fade" id="beritaacara" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Unduh Berita Acara</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Anda belum bisa mengunduh berita acara dikarenakan masih ada DATA yang
                                                        berstatus DRAFT
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                                            Close
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <table class="table datatable">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
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
                                    @foreach($data as $dt)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
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
                                                @if($dt->user_id != Auth::user()->id)
                                                    <table>
                                                        <tr>
                                                            <td>
                                                                <a href="{{ route('detail_produsen',['id'=>$dt->id])  }}"
                                                                   class="btn btn-sm btn-warning" style="color: white"
                                                                   data-bs-placement="bottom" title="Detail Data"><i
                                                                        class="bi bi-info-circle"></i></a>
                                                            </td>

                                                            @if (!isset($status))
                                                                <td>

                                                                    <a href="" class="btn btn-sm btn-success  float-right"
                                                                       data-bs-toggle="modal"
                                                                       data-bs-target="#menyetujui-{{ $dt->id }}"><i
                                                                            class="bi bi-check-circle"></i></a>
                                                                    <div class="modal fade" id="menyetujui-{{ $dt->id }}"
                                                                         tabindex="-1">
                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"
                                                                                        style="font-weight: bold; color:green">
                                                                                        SETUJUI DATA!</h5>
                                                                                    <button type="button" class="btn-close"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">

                                                                                    <h7 class="modal-title"><i
                                                                                            class="bi bi-caret-right-fill"></i>Apakah
                                                                                        anda sudah yakin untuk menyetujui data?
                                                                                    </h7>
                                                                                </div>
                                                                                <div class="modal-footer">

                                                                                    <form
                                                                                        action="{{ url('/data_produsen/setuju/'.encrypt($dt->id)) }}"
                                                                                        method="get" enctype="multipart/form-data">
                                                                                        @csrf
                                                                                        <div class="input-group mb-3">
                                                                                            <button type="button"
                                                                                                    class="btn btn-secondary"
                                                                                                    data-bs-dismiss="modal">Cancel
                                                                                            </button>
                                                                                            <button class="btn btn-primary"
                                                                                                    type="submit"
                                                                                                    id="button-addon2">Kirim
                                                                                            </button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </td>
                                                                <td>

                                                                    <a href="" class="btn btn-sm btn-danger  float-right"
                                                                       data-bs-toggle="modal"
                                                                       data-bs-target="#verticalycentered-{{ $dt->id }}"><i
                                                                            class="bi bi-x-circle"></i></a>
                                                                    <div class="modal fade" id="verticalycentered-{{ $dt->id }}"
                                                                         tabindex="-1">
                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title"
                                                                                        style="font-weight: bold; color:red">TOLAK DATA !</h5>
                                                                                    <button type="button" class="btn-close"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <h7 class="modal-title"><i
                                                                                            class="bi bi-caret-right-fill"></i>Pastikan
                                                                                        bahwa data yang anda TOLAK bukan atau tidak
                                                                                        sesuai dengan DATA anda!
                                                                                    </h7>
                                                                                    <br>
                                                                                    <h7 class="modal-title"><i
                                                                                            class="bi bi-caret-right-fill"></i>Apakah
                                                                                        anda sudah yakin untuk menolak? Jika sudah
                                                                                        yakin, Silahkan isikan Alasan untuk MENOLAK
                                                                                        DATA!
                                                                                    </h7>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary"
                                                                                            data-bs-dismiss="modal">Batal
                                                                                    </button>
                                                                                    <button type="button" class="btn btn-primary"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#alasan">Lanjutkan
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="modal fade" id="alasan" tabindex="-1">
                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title">Alasan Penolakan</h5>
                                                                                    <button type="button" class="btn-close"
                                                                                            data-bs-dismiss="modal"
                                                                                            aria-label="Close"></button>
                                                                                </div>
                                                                                <div class="modal-body px-3">
                                                                                    <form
                                                                                        action="{{ url('data_produsen/alasan', $dt->id) }}"
                                                                                        method="post" enctype="multipart/form-data">
                                                                                        @csrf
                                                                                        <div class="row mb-3">
                                                                                            <textarea type="text" name="alasan"
                                                                                                   id="alasan" class="form-control"
                                                                                                   placeholder="Berikan Alasan Penolakan"
                                                                                                   aria-label="Berikan Alasan Penolakan" required></textarea>
                                                                                        </div>

                                                                                        <button class="btn btn-primary" type="submit" id="button-addon2">
                                                                                            Kirim <i class="bi bi-send"></i>
                                                                                        </button>
                                                                                    </form>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>

                                                                <td>
                                                                    <form action="{{ url('/data_produsen/edit/'.($dt->id)) }}">

                                                                        <button type="submit" class="btn btn-sm btn-primary"><i
                                                                                class="bi bi-pencil-fill"></i></button>
                                                                    </form>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    </table>
                                                @endif
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


    <div class="modal fade" id="basicModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/data_produsen/import" method="post"
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

@endsection

@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
            integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

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
        function confirmSetuju(item_id) {
            swal({
                title: 'Apakah Anda Yakin Menyetujui Data?',
                text: "Anda Akan Menyetujui Data!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                //  dangerMode: true,
                // cancel: true,
                buttons: true,
                // dangerMode: true,
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

    <script type="text/javascript">
        function confirmBeritacara(item_id) {
            swal({
                title: 'Apakah Anda Yakin Mengunduh Berita Acara?',
                text: "Anda Akan Mengunduh Berita Acara!",
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
                        //  swal("Cancelled Successfully");
                    }
                });
        };

        function confirmDraft(item_id) {
            swal({
                title: 'Anda belum bisa mengunduh berita acara dikarenakan masih ada DATA yang berstatus DRAFT!',
                text: "Silakahan selesaikan Konfirmasi terlebih dahulu!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#d33',
                //  dangerMode: true,
                buttons: true,
                confirmButtonText: 'Yes, delete it!'
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $('#' + item_id).submit();
                    } else {
                        //  swal("Cancelled Successfully");
                    }
                });
        };

    </script>
@endpush
