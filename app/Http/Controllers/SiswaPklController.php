<?php

namespace App\Http\Controllers;

use App\Models\SiswaPkl;
use Illuminate\Http\Request;

class SiswaPklController extends Controller
{
    public function index()
    {
        $siswa = SiswaPkl::withCount('absensi')->paginate(15);
        return view('siswa.index', compact('siswa'));
    }

    public function create()
    {
        return view('siswa.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim_nis' => 'required|string|unique:siswa_pkl',
            'jurusan' => 'required|string|max:255',
            'sekolah' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        SiswaPkl::create($validated);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function edit(SiswaPkl $siswa)
    {
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, SiswaPkl $siswa)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim_nis' => 'required|string|unique:siswa_pkl,nim_nis,' . $siswa->id,
            'jurusan' => 'required|string|max:255',
            'sekolah' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $validated['foto'] = $request->file('foto')->store('siswa', 'public');
        }

        $siswa->update($validated);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diupdate!');
    }

    public function destroy(SiswaPkl $siswa)
    {
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus!');
    }
}
