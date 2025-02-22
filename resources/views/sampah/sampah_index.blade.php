@extends('layouts.sbadmin2')

@section('content')
<div class="card">
  <div class="card-header">
    {{ $judul }}
  </div>
  <div class="card-body">
    <a href="{{ route('sampah.create') }}" class="btn btn-primary mb-2">Tambah Sampah</a>

    <!-- Form pencarian -->
    <form action="{{ route('sampah.index') }}" method="GET" class="mb-3">
      <div class="input-group">
        <input type="text" class="form-control" name="q" placeholder="Cari sampah..." value="{{ request('q') }}">
        <div class="input-group-append">
          <button class="btn btn-primary" type="submit">Cari</button>
        </div>
      </div>
    </form>

    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>ID</th>
          {{-- <th>Jenis Sampah</th> --}}
          <th>Nama Sampah</th>
          <th>Berat</th>
          <th>Harga Jual</th>
          <th width="18%">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($sampahs as $sampah)
        <tr>
          <td>{{ $sampah->id }}</td>
          {{-- <td>{{ $sampah->jenis_sampah }}</td> --}}
          <td>{{ $sampah->nama_sampah }}</td>
          <td>{{ $sampah->berat }} Kg</td>
          <td>Rp. {{ number_format($sampah->harga_jual , 0, ',', '.') }}</td>
          <td>
            <a href="{{ route('sampah.edit', $sampah->id) }}" class="btn btn-primary">Edit</a>
            <form action="{{ route('sampah.destroy', $sampah->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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

    <!-- Pagination -->
    {{ $sampahs->links() }}
  </div>
</div>
@endsection
