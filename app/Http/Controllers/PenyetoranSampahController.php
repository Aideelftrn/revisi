<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Nasabah;
use App\Models\Sampah;
use App\Models\PenyetoranSampah;
use Illuminate\Support\Facades\Log;


class PenyetoranSampahController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = PenyetoranSampah::latest();

        if ($user->role == 'nasabah') {
            $query->where('nasabah_id', $user->nasabah->id);
        }

        if ($search = $request->input('q')) {
            $query->where(function ($query) use ($search) {
                $query->whereHas('nasabah', function ($query) use ($search) {
                    $query->where('nama_nasabah', 'like', "%{$search}%");
                })
                    ->orWhereHas('sampah', function ($query) use ($search) {
                        $query->where('nama_sampah', 'like', "%{$search}%");
                    });
            });
        }

        $data['judul'] = 'Data Penyetoran Sampah';
        $data['penyetoranSampahs'] = $query->paginate(10);
        $data['judul'] = 'Data Penyetoran Sampah';
        $data['sampahs'] = Sampah::latest()->paginate(10);

        return view('penyetoran.penyetoran_index', $data);
    }


    public function create()
    {
        $data['judul'] = 'Tambah Penyetoran Sampah';
        $data['nasabahs'] = Nasabah::all();
        $data['sampahs'] = Sampah::all();
        return view('penyetoran.penyetoran_create', $data);
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $nasabahId = $user->role == 'nasabah' ? $user->nasabah->id : $request->nasabah_id;

        $request->merge([
            'nasabah_id' => $nasabahId,
            'created_by' => $user->id,
        ]);

        $request->validate([
            'nasabah_id' => 'required|exists:nasabahs,id',
            'sampah_id' => 'required|exists:sampahs,id',
            'berat' => 'required|numeric',
        ]);

        $sampah = Sampah::find($request->sampah_id);
        $totalHarga = $sampah->harga_jual * $request->berat;

        DB::beginTransaction();
        try {
            PenyetoranSampah::create([
                'nasabah_id' => $request->nasabah_id,
                'sampah_id' => $request->sampah_id,
                'berat' => $request->berat,
                'total_harga' => $totalHarga,
                'created_by' => $request->created_by,
            ]);

            $nasabah = Nasabah::find($request->nasabah_id);
            $nasabah->saldo += $totalHarga; // Menambahkan saldo nasabah
            $nasabah->save();

            DB::commit();
            flash('Berhasil tambah data Penyetoran Sampah');

            return redirect()->route('penyetoran.index')->with('success', 'Penyetoran sampah berhasil');
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function edit(string $id)
    {
        $penyetoranSampah = PenyetoranSampah::findOrFail($id);
        $data['judul'] = 'Edit Penyetoran Sampah';
        $data['penyetoranSampah'] = $penyetoranSampah;
        return view('penyetoran.penyetoran_edit', $data);
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'berat' => 'required|numeric',
        ]);

        $penyetoran = PenyetoranSampah::findOrFail($id);
        $sampah = Sampah::findOrFail($penyetoran->sampah_id);
        $newTotalHarga = $sampah->harga_jual * $request->input('berat');

        DB::beginTransaction();
        try {
            $penyetoran->berat = $request->input('berat');
            $penyetoran->save();

            $nasabah = Nasabah::findOrFail($penyetoran->nasabah_id);
            $nasabah->saldo += $newTotalHarga;
            $nasabah->save();

            DB::commit();
            flash('Berhasil Edit Penyetoran Sampah');

            return redirect()->route('penyetoran.index')->with('success', 'Penyetoran sampah berhasil diperbarui');
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $penyetoranSampah = PenyetoranSampah::findOrFail($id);
        $data['judul'] = 'Detail Penyetoran Sampah';
        $data['penyetoranSampah'] = $penyetoranSampah;

        return view('penyetoran.penyetoran_detail', $data);
    }

    //fungsi untuk hapus data penyetoran sampah
    public function destroy(string $id)
    {
        $penyetoranSampah = PenyetoranSampah::findOrFail($id);
        $nasabah = Nasabah::findOrFail($penyetoranSampah->nasabah_id);
        $sampah = Sampah::findOrFail($penyetoranSampah->sampah_id);
        $totalHarga = $sampah->harga_jual * $penyetoranSampah->berat;
        $nasabah->saldo -= $totalHarga; // Mengurangi saldo nasabah
        $nasabah->save();

        $penyetoranSampah->delete();
        flash('Berhasil Hapus Penyetoran Sampah');

        return redirect()->route('penyetoran.index')->with('success', 'Penyetoran sampah berhasil dihapus');
    }
}
