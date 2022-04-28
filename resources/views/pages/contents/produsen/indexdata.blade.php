@extends('pages.main.layout')

@section('content')

<div class="pagetitle">
  @include('sweetalert::alert')
    <h1>Daftar Data</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
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
            
            {{-- <a 
            @if(Auth::user()->role_id == '1')
            href="/data_superadmin/create"
            @elseif(Auth::user()->role_id == '2')
            href="/data_walidata/create"
            @elseif(Auth::user()->role_id == '3')
            href="/data_produsen/create"
            @endif
            class="btn btn-md btn-primary mb-3 float-right">Tambah
                Data</a> --}}

                {{-- <a href="" class="btn btn-md btn-warning mb-3 float-right" data-bs-toggle="modal" data-bs-target="#basicModal">Import Excel</a> --}}
                <!-- Table with stripped rows -->
                  <div class="modal fade" id="basicModal" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Import Excel</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/data_produsen/import" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="file" name="file" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="button-addon2">
                                    <button class="btn btn-primary" type="submit" id="button-addon2">Import</button>
                                </div>
                            </form>                    
                        </div>
                      </div>
                    </div>
                  </div>
                  @if(Auth::user()->role_id == '3')
                  <!-- Table with stripped rows -->
                  
                  @if($draft == "0")
                  {{-- <a href="{{ url('/data_produsen/export-pdf') }}" class="btn btn-md btn-danger mb-3 float-right" target="_blank">Unduh Berita Acara</a> --}}
                  <form id="berita-acara" action="{{ url('/data_produsen/export-pdf') }}" >
                      
                    <button type="button" class="btn btn-sm btn-success" onclick="confirmBeritacara('berita-acara')"><i class="bi bi-download"></i> Unduh Berita Acara</button>
                  </form>
                  @elseif($draft >= "0")
                  
                  <form id="berita-acara" >
                      
                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDraft('berita-acara')"><i class="bi bi-download"></i> Unduh Berita Acara</button>
                  </form>
                  {{-- <a href="" class="btn btn-md btn-danger mb-3 float-right" data-bs-toggle="modal" data-bs-target="#beritaacara"><i class="bi bi-download"></i> Unduh Berita Acara</a> --}}
                  <div class="modal fade" id="beritaacara" tabindex="-1">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Unduh Berita Acara</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          Anda belum bisa mengunduh berita acara dikarenakan masih ada DATA yang berstatus DRAFT
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
         
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif 
                  @endif
            <!-- Table with stripped rows -->
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
                    @endif
                  </td>
                  <td>
                        @if($dt->user_id != Auth::user()->id)
                        {{-- <form onsubmit="return confirm('Apakah anda Menyetujui data : {{ $dt->nama_data }} ?');" action="{{ url('/data_produsen/setuju/'.encrypt($dt->id)) }}">
                             
                          <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-check-circle"></i></button>
                        </form> --}}
                        <table>
                          <tr>
                            <td>
                              <form id="setuju-data" action="{{ url('/data_produsen/setuju/'.encrypt($dt->id)) }}" >
                                <button type="button" class="btn btn-sm btn-success" onclick="confirmSetuju('setuju-data')"><i class="bi bi-check-circle"></i></button>
                              </form>
                            </td>
                            <td>
                              <a href="" class="btn btn-sm btn-danger  float-right" data-bs-toggle="modal" data-bs-target="#alasan"><i class="bi bi-x-circle"></i></a>
                                <div class="modal fade" id="alasan" tabindex="-1">
                                  <div class="modal-dialog">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <div class="row">
                                              <h5 class="modal-title">Alasan Penolakan</h5>
                                              <br>
                                              <h7 class="modal-title">Pastikan bahwa data yang anda TOLAK bukan merupakan DATA anda!</h7>
                                              <h7 class="modal-title">Apakah anda sudah yakin untuk menolak? Jika sudah yakin, Silahkan isikan Alasan untuk MENOLAK DATA!</h7>
                                            </div>
                                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <div class="modal-body">
                                              <form action="{{ url('data_produsen/alasan', $dt->id) }}" method="post" enctype="multipart/form-data">
                                                  @csrf
                                                  <div class="input-group mb-3">
                                                      <input type="text" name="alasan" id="alasan" class="form-control" placeholder="Berikan Alasan" aria-label="Berikan Alasan" aria-describedby="button-addon2">
                                                      <button class="btn btn-primary" type="submit" id="button-addon2">Kirim</button>
                                                  </div>
                                              </form>                    
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                            </td>
                          </tr>
                        </table>
                        
                        {{-- <form onsubmit="return confirm('Apakah anda Menolak data : {{ $dt->nama_data }} ?');" action="{{ url('/data_produsen/tolak/'. encrypt($dt->id)) }}">
                          
                          <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-x-circle"></i></button>
                        </form> --}}
                        
                        
                        @endif
                    </td>
                </tr>
                  @endforeach
              </tbody>
            </table>
            <!-- End Table with stripped rows -->

          </div>
        </div>

      </div>
    </div>
  </section>
  
  <script>
   /* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
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
                     $('#'+item_id).submit();
                 } else {
                     swal("Cancelled Successfully");
                 }
             });
   };

</script>
<script type="text/javascript">
  function confirmTolak(item_id) {
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
                     $('#'+item_id).submit();
                 } else {
                     swal("Cancelled Successfully");
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
                     $('#'+item_id).submit();
                 } else {
                     swal("Cancelled Successfully");
                 }
             });
   };

</script>
<script type="text/javascript">
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
                     $('#'+item_id).submit();
                 } else {
                     swal("Cancelled Successfully");
                 }
             });
   };

</script>

@endsection