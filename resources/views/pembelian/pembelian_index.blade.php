@extends('layouts.sbadmin2')

@section('content')
    @foreach ($penyetoranSampahs as $key => $T)
        <div class="card shadow mb-4">
            <a href="#collapseCardExample{{ preg_replace('/\s+/', '-', $key) }}" class="d-block card-header py-3"
                data-toggle="collapse" role="button" aria-expanded="true"
                aria-controls="collapseCardExample{{ preg_replace('/\s+/', '-', $key) }}">
                <h6 class="m-0 font-weight-bold text-primary">Penjualan Sampah Bulan : {{ $key }}
                </h6>
            </a>
            <div class="collapse fade" id="collapseCardExample{{ preg_replace('/\s+/', '-', $key) }}">
                <div class="card-body">
                    <div class="card">
                        <div class="card-header">
                            <a class="card-link" data-toggle="collapse" href="#collapseDetailSampah">
                                Detail Sampah
                            </a>
                        </div>
                        <div id="collapseDetailSampah" class="collapse show">
                            <div class="card-body">
                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Sampah</th>
                                            <th>Berat (Kg)</th>
                                            <th>Harga Per/Kg</th>
                                            <th>Total Harga</th>
                                            <th>Harga Jual Per/Kg</th>
                                            <th>Total Harga Jual</th>
                                            <th>Laba</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($T as $penyetoran)
                                            <tr>
                                                <td>{{ $penyetoran->id }}</td>
                                                <td>{{ $penyetoran->sampah->nama_sampah }}</td>
                                                <td>{{ number_format($penyetoran->berat, 2) }} kg</td>
                                                <td>Rp. {{ number_format($penyetoran->sampah->harga_jual, 0, ',', '.') }}
                                                </td>
                                                <td>Rp.
                                                    {{ number_format($penyetoran->sampah->harga_jual * $penyetoran->berat, 0, ',', '.') }}
                                                </td>
                                                <td>Rp.
                                                    {{ number_format($penyetoran?->pembelian?->harga_pembelian, 0, ',', '.') }}
                                                </td>
                                                <td>Rp.
                                                    {{ number_format(($penyetoran?->pembelian?->harga_pembelian ?? 0) * $penyetoran->berat, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    @php
                                                        $laba =
                                                            ($penyetoran?->pembelian?->harga_pembelian ?? 0) *
                                                                $penyetoran->berat -
                                                            $penyetoran->sampah->harga_jual * $penyetoran->berat;
                                                        $laba = $laba < 0 ? 0 : $laba;
                                                    @endphp
                                                    Rp. {{ number_format($laba, 0, ',', '.') }}
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-pill {{ $penyetoran->status == 'baru' ? 'badge-primary' : ($penyetoran->status == 'terjual' ? 'badge-success' : ($penyetoran->status == 'pending' ? 'badge-warning' : 'badge-secondary')) }}">
                                                        {{ ucfirst($penyetoran->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if ($penyetoran->status == 'terjual')
                                                        <form action="{{ route('penjualan.cancel', $penyetoran->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm">Batalkan
                                                                Penjualan</button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('penjualan.jual') }}" method="post"
                                                            style="display:inline;">
                                                            @method('post')
                                                            @csrf
                                                            <input type="hidden" name="penyetoran_sampah_id"
                                                                value="{{ $penyetoran->id }}">
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#penjualanModal{{ $penyetoran->id }}">
                                                                Jual ke Pengepul
                                                            </button>

                                                            <!-- Modal -->
                                                            <div class="modal fade"
                                                                id="penjualanModal{{ $penyetoran->id }}" tabindex="-1"
                                                                role="dialog"
                                                                aria-labelledby="penjualanModalLabel{{ $penyetoran->id }}"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title"
                                                                                id="penjualanModalLabel{{ $penyetoran->id }}">
                                                                                Penjualan ke
                                                                                Pengepul</h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="form-group">
                                                                                <label for="harga_jual">Harga Jual</label>
                                                                                <input type="number" class="form-control"
                                                                                    id="harga_jual" name="harga_jual"
                                                                                    value="{{ $penyetoran->sampah->harga_jual }}"
                                                                                    required>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="status_jual">Status
                                                                                    Jual</label>
                                                                                <select class="form-control"
                                                                                    id="status_jual" name="status_jual"
                                                                                    required>
                                                                                    <option value="terjual">Terjual
                                                                                    </option>
                                                                                    <option value="pending">Pending
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label for="pengepul">Pengepul</label>
                                                                                <select class="form-control" id="pengepul"
                                                                                    name="pengepul" required>
                                                                                    @foreach ($pengepul as $p)
                                                                                        <option
                                                                                            value="{{ $p->id }}">
                                                                                            {{ $p->nama_pengepul }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary"
                                                                                data-dismiss="modal">Batal</button>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Simpan</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td colspan="9" class="text-right font-weight-bold">Harga Berdasarkan Nama
                                                Sampah</td>
                                            <td>
                                                @foreach ($T->groupBy('sampah.nama_sampah') as $nama_sampah => $items)
                                                    <div>{{ $nama_sampah }}: Rp.
                                                        {{ number_format($items->first()->sampah->harga_jual, 0, ',', '.') }}
                                                    </div>
                                                @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="9" class="text-right font-weight-bold">Total Laba</td>
                                            <td>
                                                @php
                                                    $totalLaba = $T
                                                        ->groupBy('sampah.nama_sampah')
                                                        ->map(function ($items) {
                                                            $totalHargaJual = $items->sum(function ($item) {
                                                                return ($item->pembelian->harga_pembelian ?? 0) *
                                                                    $item->berat;
                                                            });
                                                            $totalHargaSampah = $items->sum(function ($item) {
                                                                return $item->sampah->harga_jual * $item->berat;
                                                            });
                                                            return $totalHargaJual - $totalHargaSampah;
                                                        });
                                                @endphp
                                                @foreach ($totalLaba as $nama_sampah => $laba)
                                                    <div>{{ $nama_sampah }}: Rp.
                                                        {{ number_format($laba, 0, ',', '.') }}</div>
                                                @endforeach
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#jualSemuaModal{{ preg_replace('/\s+/', '-', $key) }}">
                                Jual Semua
                            </button>

                            <!-- Modal Jual Semua -->
                            <div class="modal fade" id="jualSemuaModal{{ preg_replace('/\s+/', '-', $key) }}"
                                tabindex="-1" role="dialog"
                                aria-labelledby="jualSemuaModalLabel{{ preg_replace('/\s+/', '-', $key) }}"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"
                                                id="jualSemuaModalLabel{{ preg_replace('/\s+/', '-', $key) }}">Jual
                                                Semua Sampah Bulan: {{ $key }}</h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Jenis Sampah</th>
                                                        <th>Jumlah Penyetoran</th>
                                                        <th>Harga Sampah</th>
                                                        <th>Total Harga</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($T->groupBy('sampah.nama_sampah') as $jenis_sampah => $items)
                                                        <tr>
                                                            <td>{{ $jenis_sampah }}</td>
                                                            <td>{{ $items->sum('berat') }} kg</td>
                                                            <td>Rp.
                                                                {{ number_format($items->first()->sampah->harga_jual, 0, ',', '.') }}
                                                            </td>
                                                            <td>Rp.
                                                                {{ number_format($items->sum('berat') * $items->first()->sampah->harga_jual, 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <form action="{{ route('penjualan.jualSemua') }}" method="post">
                                            @method('post')
                                            @csrf
                                            <div class="modal-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama Sampah</th>
                                                            <th>Harga Jual Per/Kg</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($T->groupBy('sampah.nama_sampah') as $nama_sampah => $items)
                                                            <tr>
                                                                <td>{{ $nama_sampah }}</td>
                                                                <td>
                                                                    <input type="hidden" name="bulan"
                                                                        value="{{ \Carbon\Carbon::parse($T->first()->created_at)->month }}">
                                                                    <input type="hidden" name="tahun"
                                                                        value="{{ \Carbon\Carbon::parse($T->first()->created_at)->year }}">
                                                                    <input type="number" class="form-control"
                                                                        name="harga_jual[{{ $nama_sampah }}]" required>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td colspan="2">
                                                                <select class="form-control" name="pengepul" required>
                                                                    @foreach ($pengepul as $p)
                                                                        <option value="{{ $p->id }}">
                                                                            {{ $p->nama_pengepul }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Jual Semua</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
