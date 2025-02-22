<!-- @extends('layouts.sbadmin2')

@section('content')
<div class="card">
  <div class="card-header">
    Laporan Uang Masuk
  </div>
  <div class="card-body">
    <form action="{{ route('transaksi.generatePdf') }}" method="GET" class="mb-4">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="tanggal_awal">Tanggal Awal</label>
          <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" value="{{ now()->subMonth(1)->format('Y-m-d') }}">
        </div>
        <div class="form-group col-md-6">
          <label for="tanggal_akhir">Tanggal Akhir</label>
          <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ now()->format('Y-m-d') }}">
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Download PDF</button>
    </form>
    <table class="table table-bordered" id="laporanTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>ID Transaksi</th>
          <th>Kode Transaksi</th>
          <th>Nasabah</th>
          <th>Pengepul</th>
          <th>Jumlah Transaksi</th>
          <th>Uang Masuk</th>
          <th>Tanggal Transaksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($transaksiAdmin as $transaksi)
        <tr>
          <td>{{ $transaksi->id }}</td>
          <td>{{ $transaksi->kode_transaksi }}</td>
          <td>{{ $transaksi->nasabah->nama_nasabah }}</td>
          <td>{{ $transaksi->pengepul->nama_pengepul }}</td>
          <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
          <td>Rp {{ number_format($transaksi->penyetoranSampah->total_harga_jual - $transaksi->penyetoranSampah->total_harga, 0, ',', '.') }}</td>
          <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection -->