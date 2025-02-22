@extends('layouts.sbadmin2')

@section('content')
<div class="card">
  <div class="card-header">Daftar Top Up</div>
  <div class="card-body">
    @if(session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
    @endif
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>ID</th>
          <th>Pengepul ID</th>
          <th>Jumlah</th>
          <th>Metode</th>
          <th>Status</th>
          <th>Bukti Pembayaran</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($topups as $topup)
        <tr>
          <td>{{ $topup->id }}</td>
          <td>{{ $topup->pengepul_id }}</td>
          <td>Rp. {{ number_format($topup->jumlah, 0, ',', '.') }}</td>
          <td>{{ ucfirst($topup->metode) }}</td>
          <td>
            <span class="badge badge-pill 
                      @if($topup->status == 'approved')
                          badge-success
                      @elseif($topup->status == 'pending')
                          badge-primary
                      @else
                          badge-danger
                      @endif" style="font-size: 100% !important;">
              {{ $topup->status }}
            </span>
          </td>
          <td>
            @if($topup->bukti_pembayaran)
            <a href="{{ asset('storage/' . $topup->bukti_pembayaran) }}" target="_blank">
              <img src="{{ asset('storage/' . $topup->bukti_pembayaran) }}" alt="Gambar Penarikan" style="max-width: 100px; max-height: 100px;">
              @else
              Tidak ada bukti
              @endif
          </td>
          <td>
            @if($topup->status == 'pending')
            <a href="{{ route('pengepul.topups.approve', $topup->id) }}" class="btn btn-primary btn-sm">Approve</a>
            <a href="{{ route('pengepul.topups.reject', $topup->id) }}" class="btn btn-danger btn-sm">Reject</a>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection