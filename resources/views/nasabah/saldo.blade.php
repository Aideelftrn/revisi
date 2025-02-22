@extends('layouts.sbadmin2')

@section('content')
<div class="card">
  <div class="card-header">{{ $nasabah->nama_nasabah }}</div>
  <div class="card-body">
    <h3>Saldo Nasabah: Rp.{{ number_format($saldo, 0, ',', '.') }}</h3>

    <h6>Rincian Transaksi:</h6>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Kode Transaksi</th>
          <th>Tanggal</th>
          <th>Pembeli</th>
          <th>Jumlah</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($transaksi as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->kode_transaksi }}</td>
          <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
          <td>{{ $item->pengepul->nama_pengepul }}</td>
          <td>Rp. {{ number_format($item->jumlah, 0, ',', '.') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-4">
      <h5>Form Penarikan Saldo</h5>
      <form action="{{ route('nasabah.tarikSaldo') }}" method="POST">
        @csrf
        <div class="form-group">
          <label for="jumlah">Jumlah Penarikan</label>
          <input type="number" class="form-control" id="jumlah" name="jumlah" min="0" required>
        </div>
        <div class="form-group">
          <label for="tujuan">Tujuan Penarikan</label>
          <select class="form-control" id="tujuan" name="tujuan" required>
            @if($akunBanks->isEmpty())
            <option disabled selected>Belum ada bank</option>
            @else
            @foreach($akunBanks as $akunBank)
            <option value="{{ $akunBank->nomor_akun }}">{{ ucfirst($akunBank->jenis) }} - {{ $akunBank->nomor_akun }}</option>
            @endforeach
            @endif
          </select>
        </div>

        <button type="submit" class="btn btn-danger">Tarik Saldo</button>
      </form>
    </div>
  </div>
</div>
@endsection