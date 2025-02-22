@extends('layouts.sbadmin2')

@section('content')
<div class="card">
  <div class="card-header">
    Riwayat Penarikan Saldo untuk {{ $nasabah->nama_nasabah }}
  </div>
  <div class="card-body">
    <h3>Saldo saat ini: Rp.{{ number_format($nasabah->saldo, 0, ',', '.') }}</h3>
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Jumlah</th>
          <th>Tujuan</th>
          <th>Status</th>
          <th>Tanggal</th>
          <th>Bukti Pembayaran</th>
        </tr>
      </thead>
      <tbody>
        @foreach($penarikans as $penarikan)
        <tr>
          <td>{{ $penarikan->id }}</td>
          <td>Rp. {{ number_format($penarikan->jumlah, 0, ',', '.') }}</td>
          <td>{{ $penarikan->tujuan }}</td>
          <td>
            <span class="badge badge-pill 
                      @if($penarikan->status == 'approved')
                          badge-success
                      @elseif($penarikan->status == 'pending')
                          badge-primary
                      @else
                          badge-warning
                      @endif" style="font-size: 100% !important;">
              {{ $penarikan->status }}
            </span>
          </td>
          <td>{{ \Carbon\Carbon::parse($penarikan->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
          <td>
            @if($penarikan->bukti_pembayaran)
            <a href="{{ asset('storage/penarikan_images/' . $penarikan->bukti_pembayaran) }}" target="_blank">
              <img src="{{ asset('storage/penarikan_images/' . $penarikan->bukti_pembayaran) }}" alt="Gambar Penarikan" style="max-width: 100px; max-height: 100px;">
            </a>
            @else
            <span>Tidak ada bukti pembayaran</span>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection