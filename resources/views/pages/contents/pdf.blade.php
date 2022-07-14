<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
    .page-break {
        page-break-after: always;
    }
    .kop{
      text-align: center;
      font-family: "Helvetica Neue",Helvetica,Arial;
    }
    .head-isi{
      align-items: center;
      text-align: center;
      font-family: "Helvetica Neue",Helvetica,Arial;
      padding-left: 130px;
    }
    .menyatakan{
      padding-left: 50px;
    }
    .ttd{
      padding-left: 300px;
    }
    .tbl{
      border: 1px solid black;
      border-collapse: collapse;
      position : relative,
      Border : collapse,
      width   : max-width,
      Margin : auto (otomatis),
      Padding : 10px,
      Text-Align : center,
    }

  </style>

</head>
<body>
  <table >
    <tr>
      <td><img src="<?php echo $pict ?>" width="120px" height="150px" alt=""></td>
      <td class="kop">
        <font size="5"><b>PEMERINTAH KABUPATEN MADIUN</b></font>
        <font size="7"><b>SEKRETARIAT DAERAH</b></font><br>
        <font size="2">Jalan Alun – alun Utara Nomor 1-3 Madiun</font><br>
        <font size="2">Telepon ( 0351 ) 448000 - 44870007</font><br>
        <font size="2">Website http://www.madiunkab.go.id</font><br>
        <font size="3">CARUBAN – 63153</font>
      </td>
    </tr>
    <tr>
      <td colspan="2"><hr></td>
    </tr>
  </table>
  <table>
    <tr>
    <td class="head-isi">
        <font size="3"><b>BERITA ACARA</b></font> <br>
        <font size="3"><b>HASIL KESEPAKATAN</b></font><br>
        <font size="3"><b>PENYUSUNAN DAFTAR DATA DAN DATA PRIORITAS</b></font><br>
        <font size="3"><b>PERANGKAT DAERAH TAHUN {{ $tahun }}</b></font><br>
      </td>
    </tr>
  </table>
  <br>
  <table>
    <tr>
    <td class="">
        <font size="3">Pada hari {{ $hari }} tanggal {{ $tgl }} bulan {{ $bln }} Tahun {{ $tahun }} bertempat di Madiun telah diselenggarakan penyepakatan Daftar
        Data dan Data Prioritas dengan @foreach($opd as $nama) {{ $nama -> nama_opd }}@endforeach.</font> <br>
        <br>
        <font size="3">MENYEPAKATI</font>
      </td>
    </tr>
  </table>
  <br>
  <table class="menyatakan">
    <tr>
      <td><font size="3">KESATU</font></td>
      <td><font width="100px"> :</font></td>
      <td style="padding-top:20px"><font width="100px"> Daftar Data dan Data Prioritas @foreach($opd as $nama) {{ $nama -> nama_opd }}@endforeach sebagaimana
        tercantum dalam LAMPIRAN berita acara ini.</font></td>
    </tr>
    <tr>
      <td></td>
    </tr>
    <br>
    <tr>
      <td><font size="3">KEDUA</font></td>
      <td><font width="100px"> :</font></td>
      <td style="padding-top:20px"><font width="100px"> @foreach($opd as $nama) {{ $nama -> nama_opd }}@endforeach wajib menyediakan data sesuai LAMPIRAN berita acara
        ini sesuai waktu yang telah ditetapkan.</font></td>
    </tr>
    <br>
    <tr>
      <td><font size="3">KETIGA</font></td>
      <td><font width="100px"> :</font></td>
      <td style="padding-top:20px"><font width="100px"> Dalam hal pengumpulan data dilaksanakan melaui portal Satu Data
        Kabupuaten Madiun di laman www.data.madiunkab.go.id</font></td>
    </tr>
  </table>
  <br>
  <table>
    <tr>
    <td class="">
        <font size="3">Demikian berita acara ini dibuat dan disahkan untuk digunakan sebagaimana mestinya.</font> <br>
      </td>
    </tr>
  </table>
  <br>
  <br>
  <table align="center" >
    <tr>
    <td >
      <center><font size="3">Madiun, {{ $tgl }} {{ $bln }} {{ $tahun }}</font> <br>
      </center>
         </td>
    </tr>
  </table>
  <br>
  <br>
  <table>
    <tr>
    <td >
      <table>
        <tr>
        <td align="center">
          <font size="3">Produsen Data</font>
          <center>
            <font size="3">@foreach($opd as $nama) {{ $nama -> nama_opd }}@endforeach
            <br>

            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            .........................
            </font> <br>
          </center>
          </td>
        </tr>
      </table>
    </td>
    <td class="ttd">
      <table>
        <tr>
        <td align="center">
          <font size="3">Walidata</font>
          <center>
            <font size="3">Dinas Komunikasi dan Informatika
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            .........................
            </font> <br>
          </center>
          </td>
        </tr>
      </table>
    </td>
    </tr>
  </table>







<div class="page-break"></div>
<h1 style="text-align: center">LAMPIRAN</h1>
<table  class="tbl" style="margin-left:auto;margin-right:auto" cellpadding="10" border="1 solid" posisi="Relative">
    <thead>
      <tr>
        <th scope="col">No</th>
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
</body>
</html>
