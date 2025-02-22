<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sampah;

class SampahController extends Controller
{
  public function index()
  {
    $data['judul'] = 'Data Sampah';
    $data['sampahs'] = Sampah::latest()->paginate(10);
    return view('sampah.sampah_index', $data);
  }

  public function create()
  {
    $data['judul'] = 'Tambah Data Sampah';
    return view('sampah.sampah_create', $data);
  }

  public function store(Request $request)
  {
    $request->validate([
      'jenis_sampah' => 'required|string|max:255',
      'nama_sampah' => 'required|string|max:255',
      'berat' => 'required|numeric',
      'harga_jual' => 'required|numeric',
    ]);

    Sampah::create([
      'jenis_sampah' => $request->jenis_sampah,
      'nama_sampah' => $request->nama_sampah,
      'berat' => $request->berat,
      'harga_jual' => $request->harga_jual,
    ]);
    flash('Berhasil tambah data Sampah');
    return redirect()->route('sampah.index')->with('success', 'Data sampah berhasil ditambahkan');
  }

  public function edit($id)
  {
    $data['sampah'] = Sampah::findOrFail($id);
    $data['judul'] = 'Edit Data Sampah';
    return view('sampah.sampah_edit', $data);
  }

  public function update(Request $request, $id)
  {
    $request->validate([
      'jenis_sampah' => 'required|string|max:255',
      'nama_sampah' => 'required|string|max:255',
      'berat' => 'required|numeric',
      'harga_jual' => 'required|numeric',
    ]);

    $sampah = Sampah::findOrFail($id);
    $sampah->update([
      'jenis_sampah' => $request->jenis_sampah,
      'nama_sampah' => $request->nama_sampah,
      'berat' => $request->berat,
      'harga_jual' => $request->harga_jual,
    ]);
    flash('Berhasil edit Sampah');

    return redirect()->route('sampah.index')->with('success', 'Data sampah berhasil diperbarui');
  }

  public function destroy($id)
  {
    $sampah = Sampah::findOrFail($id);
    $sampah->delete();
    flash('Berhasil menghapus Sampah');
    return redirect()->route('sampah.index')->with('success', 'Data sampah berhasil dihapus');
  }
}
