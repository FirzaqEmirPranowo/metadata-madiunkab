@extends('pages.main.layout')
@section('css')
<link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
@endsection
@section('content')

<div class="pagetitle">
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

          {{-- <a 
            @if(Auth::user()->role_id == '1')
            href="/data_administrator/create"
            @elseif(Auth::user()->role_id == '2')
            href="/data_walidata/create"
            @elseif(Auth::user()->role_id == '3')
            href="/data_produsen/create"
            @endif
            class="btn btn-md btn-primary mb-3 float-right">Tambah
                Data</a> --}}

          {{-- <a href="" class="btn btn-md btn-warning mb-3 float-right" data-bs-toggle="modal" data-bs-target="#basicModal">Import Excel</a>
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
                  @endif --}}
                  <div class="mb-4">
                    <form id="berita-acara" action="{{ url('/data_walidata/export-pdf2') }}" >
                    
                      <div class="row">
                        <div class="col-8">
                          <select id="opd_id" name="opd_id" class="form-select" aria-label="Default select example">
                            <option  selected value="">Pilih OPD</option>
                            <option   value="{{ encrypt('all') }}">Semua OPD</option>
                            @foreach($opd as $id => $nama)
                            <option value="{{ encrypt($id) }}">{{ $nama }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-4 d-flex" id="action-buttons">
                          <button class="btn btn-primary mx-2" type="button" href="/draft" onclick="getData()"> Cari </button>
                          
                          <button class="btn btn-success" id="btnijo" onclick="confirmBeritacara('berita-acara')" type="submit"><i class="bi bi-download"></i> Unduh Berita Acara </button>
                         
                          <a href="" class="btn btn-danger" id="btnred" data-bs-toggle="modal" data-bs-target="#beritaacara"><i class="bi bi-download"></i> Unduh Berita Acara</a>
                         
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
                         
                        </div>
                      </div>
                    </form>
                  </div>
          <!-- Table with stripped rows -->

          <table class="table" id="datatable">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nama Data</th>
                <th scope="col">Produsen (PIC)</th>
                <th scope="col">Jenis</th>
                <th scope="col">Sumber</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
        </table>
        <!-- End Table with stripped rows -->

      </div>
    </div>

  </div>
  </div>
</section>
@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script>
  function getData() {
    var value = $('#opd_id').val();
    if (value != ''){
      load(value);
    } 
  }
  
  // $(document).ready(function() {
  //   load('all');
  // });
  $( document ).ready(function() {
      $('#btnijo').hide();
      $('#btnred').hide();
    });

  function load(id) {
    if (id == 'all') {
      $url= `{{ route('getData') }}`
    }else{
      $url= `{{ route('getData') }}?id=${id}`
    }
    

    $('#datatable').dataTable({
      "ordering": false,
      bDestroy: true,
      ajax: {

        url: $url,
        data: {id:id},
        "dataSrc" : function (json){
          console.log(json.extra);
          if(json.draft_counter == 0){
            $('#btnijo').show();
            $('#btnred').hide();
          }
          else{
            $('#btnred').show();
            $('#btnijo').hide();
          }
          return json.data;
        }
        
      },
      
      columns: [
      {
        data: null,
        searchable: false,
        orderable: false,
        render: function (data, type, row, meta, draft_counter) {
       
         
          return meta.row + meta.settings._iDisplayStart + 1;
          

        }  
      },
      {
        data: 'nama_data', 
        name: 'nama_data'
      },
      {
        data: 'opd_id', 
        name: 'opd_id'
      },
      {
        data: 'jenis_data', 
        name: 'jenis_data'
      },
      {
        data: 'sumber_data', 
        name: 'sumber_data'
      },
      {
        data: 'status_id', 
        name: 'status_id'
      },
      ],
    });
  }
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
              //  buttons: true, 
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

@endpush