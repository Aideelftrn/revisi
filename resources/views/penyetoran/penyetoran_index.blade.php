@extends('layouts.sbadmin2')

@section('content')
<div class="card">
    <div class="card-header">
        {{ $judul }}
    </div>
    <div class="card-body">
        @if (auth()->user()->role == 'admin')
        <a href="{{ route('penyetoran.create') }}" class="btn btn-primary mb-2">Tambah Penjualan Sampah</a>
        @endif

        <form action="{{ route('penyetoran.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="q" placeholder="Cari penyetoran..." value="{{ request('q') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <!-- <th>Nama Nasabah</th> -->
                    <th>Nama Sampah</th>
                    <th>Berat (Kg)</th>
                    @if (auth()->user()->role == 'admin')
                    <th>Harga Awal</th>
                    <th>Harga Jual</th>
                    @else
                    <th>Total Harga</th>
                    @endif
                    <th>Tanggal</th>
                    <th>Status</th>
                    @if (auth()->user()->role == 'admin')
                    <th width="15%">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($penyetoranSampahs as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <!-- <td>{{ $item->nasabah->nama_nasabah }}</td> -->
                    <td>{{ $item->sampah->nama_sampah }}</td>
                    <td>{{ $item->berat }}</td>
                    @if (auth()->user()->role == 'admin')
                    <td>Rp. {{ number_format($item->total_harga , 0, ',', '.') }}</td>
                    <td>Rp. {{ number_format($item->total_harga_jual , 0, ',', '.') }}</td>
                    @else
                    <td>Rp. {{ number_format($item->total_harga_jual , 0, ',', '.') }}</td>
                    @endif
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                    <td>
                        <span class="badge badge-pill
                        @if($item->status == 'baru')
                            badge-primary
                        @elseif($item->status == 'terjual')
                            badge-success
                        @elseif($item->status == 'pending')
                            badge-warning
                        @else
                            badge-secondary
                        @endif">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    @if (auth()->user()->role == 'admin')
                    <td>
                        @if ($item->status == 'pending')
                        <a href="/penyetoran/{{ $item->id }}/edit" class="btn btn-sm btn-primary">Tambah Harga Jual</a>
                        @elseif ($item->status == 'baru' || $item->status == 'terjual')
                        <a href="/penyetoran/{{ $item->id }}" class="btn btn-sm btn-info">Detail</a>
                        @endif
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->role == 'admin' ? 9 : 6 }}" class="text-center">Data tidak ada</td>
                </tr>
                @endforelse
            </tbody>
        </table>
         <!-- button info -->
         <div class="d-flex justify-content-center">
            <button class="btn btn-link text-secondary mt-3" type="button" data-toggle="collapse" data-target="#tabelTambahan" aria-expanded="false" aria-controls="tabelTambahan">
                Info Harga Sampah <br>
                <i class="fas fa-chevron-down"></i> <!-- Icon panah ke bawah -->
            </button>
        </div>
        <!-- Tabel sampah -->
        <div class="collapse mt-3" id="tabelTambahan">
            <div class="card card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="col-1 text-center">Nomor</th>
                            <th>Nama Sampah</th>
                            <td>Berat</td>
                            <th>Harga per Kg</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach($sampahs as $sampah)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                {{-- <td>{{ $sampah->jenis_sampah }}</td> --}}
                                <td>{{ $sampah->nama_sampah }}</td>
                                <td>{{ $sampah->berat }} Kg</td>
                                <td>Rp. {{ number_format($sampah->harga_jual , 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
