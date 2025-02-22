<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Nasabah;
use App\Models\PenyetoranSampah;
use App\Models\PembelianSampah;
use App\Models\Sampah;
use App\Models\Transaksi;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $totalUsers = User::count();
        $totalNasabahs = Nasabah::count();
        $totalPenyetorans = PenyetoranSampah::count();
        $totalPembelians = PembelianSampah::count();
        $totalSampahs = Sampah::count();
        $totalTransaksis = Transaksi::count();

        return view('home', compact('totalUsers', 'totalNasabahs', 'totalPenyetorans', 'totalPembelians', 'totalSampahs', 'totalTransaksis'));
    }
}
