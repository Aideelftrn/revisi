<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\Nasabah;
use App\Models\Penarikan;
use App\Models\User;
use App\Models\Akun;

class NasabahController extends Controller
{
    public function index()
    {
        $cari = request('q');
        if ($cari) {
            $data['nasabah'] = Nasabah::where('nama_nasabah', 'like', '%' . $cari . '%')
                ->orWhere('kode_nasabah', 'like', '%' . $cari . '%')
                ->paginate(10);
        } else {
            $data['nasabah'] = Nasabah::latest()->paginate(10);
        }
        $data['judul'] = 'Data-data Nasabah';
        return view('nasabah.nasabah_index', $data);
    }

    public function create()
    {
        $data['judul'] = 'Tambah Data Nasabah';
        $data['list_jk'] = [
            'Pria' => 'Pria',
            'Wanita' => 'Wanita'
        ];

        if (auth()->check()) {
            $user = auth()->user();
            $nasabah = Nasabah::where('user_id', $user->id)->first();

            if ($nasabah) {
                $data['user_name'] = $nasabah->nama_nasabah;
                $data['email'] = $nasabah->email;
                $data['nomor_telp'] = $nasabah->nomor_telp;
                $data['jenis_kelamin'] = $nasabah->jenis_kelamin;
                $data['alamat'] = $nasabah->alamat;
            } else {
                $data['user_name'] = null;
                $data['email'] = null;
                $data['nomor_telp'] = null;
                $data['jenis_kelamin'] = null;
                $data['alamat'] = null;
            }
        } else {
            $data['user_name'] = null;
            $data['email'] = null;
            $data['nomor_telp'] = null;
            $data['jenis_kelamin'] = null;
            $data['alamat'] = null;
        }

        return view('nasabah.nasabah_create', $data);
    }

    public function store(Request $request)
    {
        $validasiData = $request->validate([
            'nama_nasabah' => 'required',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'saldo' => 'nullable|numeric|min:0',
            'email' => 'required|email',
            'password' => 'required',
            'nomor_telp' => 'required',
            // 'umur' => 'required|integer',
            // 'nik' => 'required|unique:nasabahs,nik',
        ]);

        DB::beginTransaction();
        try {
            $nasabahExist = Nasabah::where('nama_nasabah', $request->nama_nasabah)->first();
            $kode = 'N0001';
            if (!$nasabahExist) {
                $kodeQuery = Nasabah::orderBy('id', 'desc')->first();
                if ($kodeQuery) {
                    $kode = 'N' . sprintf('%04d', $kodeQuery->id + 1);
                }

                $user = new User();
                $user->name = $validasiData['nama_nasabah'];
                $user->email = $validasiData['email'];
                $user->nomor_telp = $validasiData['nomor_telp'];
                $user->password = bcrypt($request->password);
                $user->role = 'nasabah';
                $user->save();

                $nasabah = new Nasabah();
                $nasabah->kode_nasabah = $kode;
                $nasabah->nama_nasabah = $request->nama_nasabah;
                $nasabah->jenis_kelamin = $request->jenis_kelamin;
                $nasabah->alamat = $request->alamat;
                $nasabah->nomor_telp = $request->nomor_telp;
                // $nasabah->nik = $request->nik;
                // $nasabah->umur = $request->umur;
                $nasabah->email = $request->email;
                $nasabah->saldo = $request->saldo;
                $nasabah->user_id = $user->id;
                $nasabah->password = bcrypt($request->password);
                $nasabah->save();
            }

            DB::commit();
            flash('Berhasil tambah data Nasabah');

            return redirect('nasabah');
        } catch (\Throwable $e) {
            DB::rollback();
            flash('Ops... Terjadi kesalahan: ' . $e->getMessage())->error();
            return back();
        }
    }

    public function registerAkunNasabah()
    {
        $data['judul'] = 'Registrasi Nasabah Baru';
        return view('auth.register', $data);
    }

    public function registerNasabahStore(Request $request)
    {
        $validasiData = $request->validate([
            'nama_nasabah' => 'required',
            'jenis_kelamin' => 'required',
            'email' => 'required|email',
            'nomor_telp' => 'required',
            'alamat' => 'required',
            'password' => 'required',
            'umur' => 'nullable',
            'nik' => 'nullable',
        ]);

        $kodeQuery = Nasabah::orderBy('id', 'desc')->first();
        $kode = 'N0001';
        if ($kodeQuery) {
            $kode = 'N' . sprintf('%04d', $kodeQuery->id + 1);
        }

        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $validasiData['nama_nasabah'];
            $user->email = $validasiData['email'];
            $user->nomor_telp = $validasiData['nomor_telp'];
            $user->password = bcrypt($request->password);
            $user->role = 'nasabah';
            $user->save();

            $nasabah = new Nasabah();
            $nasabah->kode_nasabah = $kode;
            $nasabah->fill($validasiData);
            $nasabah->user_id = $user->id;
            $nasabah->save();

            DB::commit();
            flash('Register Berhasil');
            return redirect('login');
        } catch (\Throwable $e) {
            DB::rollback();
            flash('Ops... Terjadi kesalahan: ' . $e->getMessage())->error();
            return back();
        }
    }

    public function show(string $id)
    {
        //
    }

    public function showSaldo($id)
    {
        $nasabah = Nasabah::findOrFail($id);

        $transaksi = Transaksi::where('nasabah_id', $id)
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $saldo = $transaksi->sum(function ($item) {
            return $item->jumlah_barang * $item->harga;
        }) + $nasabah->saldo;

        $user = $nasabah->user;

        $akunBanks = Akun::where('user_id', $user->id)->get();

        return view('nasabah.saldo', [
            'nasabah' => $nasabah,
            'transaksi' => $transaksi,
            'saldo' => $saldo,
            'akunBanks' => $akunBanks
        ]);
    }






    public function edit(string $id)
    {
        $data['nasabah'] = Nasabah::findOrFail($id);
        $data['judul'] = 'Edit Data';
        return view('nasabah.nasabah_edit', $data);
    }

    public function update(Request $request, string $id)
    {
        $validasiData = $request->validate([
            'nama_nasabah' => 'required',
            'alamat' => 'required',
            'email' => 'required|email',
            'nomor_telp' => 'required',
            // 'umur' => 'required|integer',
            // 'nik' => 'required',
        ]);

        $nasabah = Nasabah::findOrFail($id);
        $nasabah->fill($validasiData);
        $nasabah->save();

        flash('Data berhasil diubah');
        return redirect('nasabah');
    }

    public function destroy(string $id)
    {
        $nasabah = Nasabah::findOrFail($id);
        $nasabah->delete();
        flash('Data berhasil dihapus');
        return back();
    }



    public function tarikSaldo(Request $request)
    {
        $nasabah = Nasabah::where('user_id', auth()->id())->firstOrFail();

        $akunBanks = Akun::where('user_id', auth()->id())->get();
        if ($akunBanks->isEmpty()) {
            flash('Tidak ada akun bank yang tersedia untuk penarikan saldo')->error();
            return back();
        }

        $request->validate([
            'jumlah' => 'required|numeric|min:0',
            'tujuan' => 'required|exists:akuns,nomor_akun',
        ]);

        DB::beginTransaction();
        try {
            if ($nasabah->saldo < $request->jumlah) {
                flash('Saldo tidak cukup')->error();
                return back();
            }

            $akun = Akun::where('user_id', auth()->id())
                ->where('nomor_akun', $request->tujuan)
                ->first();

            if (!$akun) {
                flash('Akun tujuan tidak ditemukan')->error();
                return back();
            }

            $penarikan = new Penarikan();
            $penarikan->nasabah_id = $nasabah->id;
            $penarikan->jumlah = $request->jumlah;
            $penarikan->tujuan = $akun->jenis . ' - ' . $akun->nomor_akun;
            $penarikan->status = 'pending';
            $penarikan->save();

            DB::commit();
            flash('Permintaan tarik saldo berhasil diajukan')->success();
            return redirect()->route('nasabah.riwayatPenarikan', ['id' => $nasabah->id]);
        } catch (\Throwable $e) {
            DB::rollback();
            flash('Ops... Terjadi kesalahan: ' . $e->getMessage())->error();
            return back();
        }
    }





    public function riwayatPenarikan($id)
    {
        $nasabah = Nasabah::findOrFail($id);
        $penarikans = Penarikan::where('nasabah_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('nasabah.riwayat_penarikan', [
            'nasabah' => $nasabah,
            'penarikans' => $penarikans
        ]);
    }
}
