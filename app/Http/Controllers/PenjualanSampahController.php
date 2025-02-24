<?php

namespace App\Http\Controllers;

use App\Models\{PembelianSampah, PenyetoranSampah, Transaksi, Pengepul, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Log, DB};

class PenjualanSampahController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $penyetoranSampahs = PenyetoranSampah::with('sampah')->get();

        $penyetoranSampahs = $penyetoranSampahs->groupBy(function ($date) {
            return \Carbon\Carbon::parse($date->created_at)->format('F Y');
        });

        return view('pembelian.pembelian_index', [
            'penyetoranSampahs' => $penyetoranSampahs,
            'pengepul' => $user->role == 'admin' ? Pengepul::all() : null
        ]);
    }

    public function jualSemua(Request $request)
    {
        $user = Auth::user();
        $penyetoranSampahs = $user->role == 'admin'
            ? PenyetoranSampah::whereIn('status', ['baru', 'pending'])
            ->whereMonth('created_at', $request->bulan)
            ->whereYear('created_at', $request->tahun)
            ->get()
            : PenyetoranSampah::whereIn('status', ['baru', 'pending'])
            ->where('nasabah_id', $user->id)
            ->whereMonth('created_at', $request->bulan)
            ->whereYear('created_at', $request->tahun)
            ->get();


        DB::transaction(function () use ($penyetoranSampahs, $request) {
            foreach ($penyetoranSampahs as $penyetoranSampah) {
                $hargaJual = $request->harga_jual[$penyetoranSampah->sampah->nama_sampah];
                $hargaNasabah = $penyetoranSampah->sampah->harga_jual;
                $selisihAdmin = $hargaJual - $hargaNasabah;

                PembelianSampah::create([
                    'pengepul_id' => $request->pengepul,
                    'penyetoran_sampah_id' => $penyetoranSampah->id,
                    'harga_pembelian' => $hargaJual,
                    'jumlah' => $penyetoranSampah->berat,
                ]);

                Transaksi::create([
                    'kode_transaksi' => 'TRX-' . uniqid(),
                    'nasabah_id' => $penyetoranSampah->nasabah_id,
                    'penyetoran_sampah_id' => $penyetoranSampah->id,
                    'pengepul_id' => $request->pengepul,
                    'jumlah' => $hargaJual,
                    'tanggal_transaksi' => now(),
                ]);

                $penyetoranSampah->nasabah->increment('saldo', $hargaNasabah);
                $penyetoranSampah->update(['status' => 'terjual']);

                if ($admin = User::find($penyetoranSampah->created_by)) {
                    $admin->increment('saldo', $selisihAdmin);
                }
            }
        });

        return redirect()->route('penjualan.index')->with('success', 'Semua penjualan berhasil dilakukan.');
    }

    public function jual(Request $request)
    {
        $penyetoranSampah = PenyetoranSampah::findOrFail($request->penyetoran_sampah_id);

        DB::transaction(function () use ($penyetoranSampah, $request) {
            $hargaJual = $request->harga_jual;
            $hargaNasabah = $penyetoranSampah->sampah->harga_jual;
            $selisihAdmin = $hargaJual - $hargaNasabah;

            PembelianSampah::create([
                'pengepul_id' => $request->pengepul,
                'penyetoran_sampah_id' => $penyetoranSampah->id,
                'harga_pembelian' => $hargaJual,
                'jumlah' => $penyetoranSampah->berat,
            ]);

            Transaksi::create([
                'kode_transaksi' => 'TRX-' . uniqid(),
                'penyetoran_sampah_id' => $penyetoranSampah->id,
                'nasabah_id' => $penyetoranSampah->nasabah_id,
                'pengepul_id' => $request->pengepul,
                'jumlah' => $hargaJual,
                'tanggal_transaksi' => now(),
            ]);

            $penyetoranSampah->nasabah->increment('saldo', $hargaNasabah);
            $penyetoranSampah->update(['status' => 'terjual']);

            if ($admin = User::find($penyetoranSampah->created_by)) {
                $admin->increment('saldo', $selisihAdmin);
            }
        });

        return redirect()->route('penjualan.index')->with('success', 'Penjualan  berhasil dilakukan.');
    }



    //fungi untuk batalkan penjualan dengan menghapus data penjualan di tabel pembelian dan ubah status di penyetoran sampah menjadi pending
    public function cancel($id)
    {
        try {
            $penjualanSampah = PembelianSampah::where('penyetoran_sampah_id', $id)->first();
            $penyetoranSampah = PenyetoranSampah::findOrFail($id);
            $transaksi = Transaksi::where('penyetoran_sampah_id', $id)->first();

            if (!$penjualanSampah) {
                return redirect()->route('penjualan.index')->with('error', 'Penjualan sampah tidak ditemukan.');
            }

            DB::transaction(function () use ($penjualanSampah, $penyetoranSampah, $transaksi) {
                $penjualanSampah->delete();
                $penyetoranSampah->update(['status' => 'pending']);
                if ($transaksi) {
                    $transaksi->delete();
                }
            });

            return redirect()->route('penjualan.index')->with('success', 'Penjualan sampah berhasil dibatalkan.');
        } catch (\Exception $e) {
            Log::error('Error pada PenjualanSampahController@cancel: ' . $e->getMessage());
            return redirect()->route('penjualan.index')->with('error', 'Terjadi kesalahan saat membatalkan penjualan.');
        }
    }
}
