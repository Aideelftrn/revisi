@extends('layouts.sbadmin2')

@section('content')
<div class="card">
  <div class="card-header">
    {{ $judul }}
  </div>
  <div class="card-body">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Kode Transaksi</th>
          <th>Nama Sampah</th>
          <!-- <th>Nama Pengepul</th> -->
          <th>Total Harga</th>
          <th>Tanggal</th>
          <th width="18%">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($transaksi as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->kode_transaksi }}</td>
          <td>{{ $item->penyetoranSampah->sampah->nama_sampah}}</td>
          <!-- <td>{{ $item->nasabah->nama_nasabah}}</td> -->
          <!-- <td>{{ $item->pengepul->nama_pengepul }}</td> -->
          <td>Rp. {{ number_format($item->jumlah , 0, ',', '.') }}</td>
          <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
          <td>
            <a href="{{ route('transaksi.show', $item->id) }}" class="btn btn-info">Detail</a>
            <form action="{{ route('transaksi.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
              @method('DELETE')
              @csrf
              <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
          </td>

        </tr>
        @empty
        <tr>
          <td colspan="7" class="text-center">Data tidak ada</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@if(auth()->user()->role == 'admin')
<div class="card mt-4">
  <div class="card-header">
    Daftar Uang Masuk
  </div>
  <div class="card-body">
    <p>Total Uang Masuk: <strong>Rp {{ number_format($totalSelisihAdmin, 0, ',', '.') }}</strong> </p>
    <p>Total Transaksi: <strong>Rp {{ number_format($totalTransaksi, 0, ',', '.') }}</strong> </p>
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

    <table class="table table-bordered" id="adminTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>ID Transaksi</th>
          <th>Kode Transaksi</th>
          <th>Nasabah</th>
          <th>Pengepul</th>
          <!-- <th>Selisih</th> -->
          <th>Saldo Masuk Nasabah</th>
          <th>Saldo Masuk Admin</th>
          <th>Saldo Pengeluaran Pengepul</th>
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
          <!-- <td>Rp {{ number_format($transaksi->penyetoranSampah->total_harga_jual - $transaksi->penyetoranSampah->total_harga, 0, ',', '.') }}</td> -->
          <td>Rp {{ number_format($transaksi->penyetoranSampah->total_harga, 0, ',', '.') }}</td>
          <td>Rp {{ number_format($transaksi->penyetoranSampah->total_harga_jual - $transaksi->penyetoranSampah->total_harga, 0, ',', '.') }}</td>
          <td>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
          <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endif

@endsection
