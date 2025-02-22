@extends('layouts.sbadmin2')

@section('content')
<div class="card">
  <div class="card-header">
    {{ $judul }}
  </div>
  <div class="card-body">
    <table class="table table-bordered">
      <tr>
        <th>ID Transaksi</th>
        <td>{{ $transaksi->id }}</td>
      </tr>
      <tr>
        <th>Kode Transaksi</th>
        <td>{{ $transaksi->kode_transaksi }}</td>
      </tr>
      <tr>
        <th>Nama Nasabah</th>
        <td>{{ $transaksi->nasabah->nama_nasabah }}</td>
      </tr>
      <tr>
        <th>Nama Pengepul</th>
        <td>{{ $transaksi->pengepul->nama_pengepul }}</td>
      </tr>
      <tr>
        <th>Jumlah</th>
        <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <th>Tanggal Transaksi</th>
        <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
      </tr>
    </table>
    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
  </div>
</div>
@endsection