<style>
    .page-break {
        page-break-after: always;
    }
</style>
<h1>BERITA ACARA</h1>
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