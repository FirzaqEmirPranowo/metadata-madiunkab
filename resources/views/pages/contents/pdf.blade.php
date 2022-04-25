<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style type="text/css">
    body {font-family:'Times New Roman', Times, serif; background-color: #ccc}
    .rangkasurat {width: 80px; margin:0 auto; background-color: #fff ;height: 500px; padding: 20px;}
    table {border-buttons: 5px solid #000; padding: 2px}
    .tengah{text-align: center;line-height: 5px;}
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
  <div class="rangkasurat">
    <table width="100%">
<tr>
  <td><img src="{{ '../../../../public/assets/img/logo.png' }}" width="140px"></td>
  <td class="tengah">
    <h2>PEMERINTAH KABUPATEN MADIUN</h2>
    <h2>SEKRETARIAT DAERAH</h2>
    <b>Jalan Alun - alun Utara Nomer 1-2 Madiun</b><br>
    <b>Telepon ( 0351 ) 448000 - 44870007</b><br>
    <b>Website http://www.madiunkab.go.id</b><br>
    <b>CARUBAN - 63153</b><br>
  </td>
</tr>
    </table>
  </div>
  
</body>
</html>
{{-- <h1>BERITA ACARA</h1> --}}


<div class="page-break"></div>
<table class="table datatable">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nama Data</th>
        <th scope="col">Produsen (PIC)</th>
        <th scope="col">Jenis</th>
        <th scope="col">Sumber</th>
        {{-- <th scope="col">Status</th> --}}
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; ?>
        @foreach($data as $dt)
      <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $dt->nama_data }}</td>
        <td>{{ $dt->opd->nama_opd }}</td>
        <td>{{ $dt->jenis_data }}</td>
        <td>{{ $dt->sumber_data }}</td>
        {{-- <td>{{ $dt->status->status }}</td> --}}
      </tr>
        @endforeach
    </tbody>
  </table>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>