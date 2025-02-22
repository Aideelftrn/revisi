@extends('layouts.sbadmin2')

@section('content')

<div class="card">
    <div class="card-header">{{ __('Dashboard') }}</div>
    <!-- <div class="card-body">
        <div>
            @if (auth()->user()->role == 'admin')
            <a href="/transaksi/create" class="btn btn-primary m-1">Buat Transaksi</a>
            <a href="/nasabah/create" class="btn btn-primary m-1">Tambah Nasabah</a>
            <a href="/pengepul/create" class="btn btn-primary m-1">Tambah Pengepul</a>
            @elseif (auth()->user()->role == 'pengepul')
            <a href="/pembelian/create" class="btn btn-primary m-1">Buat Pembelian</a>
            <a href="/transaksi/create" class="btn btn-primary m-1">Buat Transaksi</a>
            @elseif (auth()->user()->role == 'nasabah')
            <a href="/penyetoran/create" class="btn btn-primary m-1">Tambah Penyetoran</a>
            @endif
        </div>
    </div> -->

    <div class="container-fluid">
        <div class="row">

            @if (auth()->user()->role == 'admin')
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <i class="fas fa-user-friends fa-2x"></i> Nasabah
                        <span class="badge bg-danger">{{ $totalNasabahs }}</span>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-black stretched-link" href="/nasabah">View Details</a>
                        <div class="small text-white">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <i class="fas fa-users fa-2x"></i> Users
                        <span class="badge bg-danger">{{ $totalUsers }}</span>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-black stretched-link" href="/user">View Details</a>
                        <div class="small text-white">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <i class="fas fa-exchange-alt fa-2x"></i> Transaksi
                        <span class="badge bg-danger">{{ $totalTransaksis }}</span>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-black stretched-link" href="/transaksi">View Details</a>
                        <div class="small text-white">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <i class="fas fa-donate fa-2x"></i> Penyetoran
                        <span class="badge bg-danger">{{ $totalPenyetorans }}</span>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-black stretched-link" href="/penyetoran">View Details</a>
                        <div class="small text-white">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <i class="fas fa-shopping-cart fa-2x"></i> Pembelian
                        <span class="badge bg-dark">{{ $totalPembelians }}</span>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-black stretched-link" href="/pembelian">View Details</a>
                        <div class="small text-white">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card bg-secondary text-white">
                    <div class="card-body">
                        <i class="fas fa-trash fa-2x"></i> Sampah
                        <span class="badge bg-danger">{{ $totalSampahs }}</span>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-black stretched-link" href="/sampah">View Details</a>
                        <div class="small text-white">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            @elseif (auth()->user()->role == 'pengepul')
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <i class="fas fa-shopping-cart fa-2x"></i> Pembelian
                        <span class="badge bg-dark">{{ $totalPembelians }}</span>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-black stretched-link" href="/pembelian">View Details</a>
                        <div class="small text-white">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <i class="fas fa-exchange-alt fa-2x"></i> Transaksi
                        <span class="badge bg-danger">{{ $totalTransaksis }}</span>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-black stretched-link" href="/transaksi">View Details</a>
                        <div class="small text-white">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            @elseif (auth()->user()->role == 'nasabah')
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <i class="fas fa-donate fa-2x"></i> Penyetoran
                        <span class="badge bg-danger">{{ $totalPenyetorans }}</span>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-black stretched-link" href="/penyetoran">View Details</a>
                        <div class="small text-white">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <i class="fas fa-exchange-alt fa-2x"></i> Transaksi
                        <span class="badge bg-danger">{{ $totalTransaksis }}</span>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-black stretched-link" href="/transaksi">View Details</a>
                        <div class="small text-white">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <i class="fas fa-wallet fa-2x"></i> Saldo
                        <span class="badge bg-dark">{{ number_format(auth()->user()->nasabah->saldo ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-black stretched-link" href="{{ auth()->user()->nasabah ? route('nasabah.saldo', ['id' => auth()->user()->nasabah->id]) : '#' }}">View Details</a>
                        <div class="small text-white">
                            <i class="fas fa-angle-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            @endif

        </div>
    </div>
</div>
@endsection