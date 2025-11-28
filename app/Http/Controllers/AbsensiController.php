<?php

namespace App\Http\Controllers;

use App\Models\SiswaPkl;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin') {
            // Admin melihat semua siswa dan absensi
            $siswa = SiswaPkl::with('absensiHariIni')->get();
            $totalSiswa = SiswaPkl::count();
            $hadirHariIni = Absensi::whereDate('tanggal', now('Asia/Jakarta')->toDateString())
                ->whereNotNull('jam_masuk')
                ->count();
            $belumAbsen = $totalSiswa - $hadirHariIni;
        } else {
            // User (Siswa) hanya melihat data diri sendiri
            $siswaPkl = $user->siswaPkl;
            
            if (!$siswaPkl) {
                return view('siswa.dashboard-empty');
            }

            $siswa = collect([$siswaPkl]);
            $totalSiswa = 1;
            $hadirHariIni = $siswaPkl->absensiHariIni ? 1 : 0;
            $belumAbsen = $siswaPkl->absensiHariIni ? 0 : 1;
        }
        
        return view('absensi.index', compact('siswa', 'totalSiswa', 'hadirHariIni', 'belumAbsen', 'user'));
    }

    public function absenMasuk(Request $request)
    {
        $validated = $request->validate([
            'siswa_pkl_id' => 'required|exists:siswa_pkl,id',
            'foto_masuk' => 'nullable|image|max:2048'
        ]);

        // Jika user adalah siswa, pastikan hanya bisa absen diri sendiri
        if (auth()->user()->role === 'user') {
            $siswaPkl = auth()->user()->siswaPkl;
            if (!$siswaPkl || $siswaPkl->id != $validated['siswa_pkl_id']) {
                return redirect()->back()->with('error', 'Anda hanya bisa absen untuk diri sendiri!');
            }
        }

        $absensi = Absensi::firstOrCreate(
            [
                'siswa_pkl_id' => $validated['siswa_pkl_id'],
                'tanggal' => now('Asia/Jakarta')->toDateString()
            ],
            [
                'jam_masuk' => now('Asia/Jakarta')->format('H:i:s'),
                'status' => 'hadir'
            ]
        );

        if ($request->hasFile('foto_masuk')) {
            $path = $request->file('foto_masuk')->store('absensi', 'public');
            $absensi->foto_masuk = $path;
            $absensi->save();
        }

        return redirect()->back()->with('success', 'Absen masuk berhasil dicatat!');
    }

    public function absenPulang(Request $request)
    {
        $validated = $request->validate([
            'siswa_pkl_id' => 'required|exists:siswa_pkl,id',
            'foto_pulang' => 'nullable|image|max:2048'
        ]);

        // Jika user adalah siswa, pastikan hanya bisa absen diri sendiri
        if (auth()->user()->role === 'user') {
            $siswaPkl = auth()->user()->siswaPkl;
            if (!$siswaPkl || $siswaPkl->id != $validated['siswa_pkl_id']) {
                return redirect()->back()->with('error', 'Anda hanya bisa absen untuk diri sendiri!');
            }
        }

        $absensi = Absensi::where('siswa_pkl_id', $validated['siswa_pkl_id'])
            ->whereDate('tanggal', now('Asia/Jakarta')->toDateString())
            ->first();

        if (!$absensi) {
            return redirect()->back()->with('error', 'Belum melakukan absen masuk!');
        }

        $absensi->jam_pulang = now('Asia/Jakarta')->format('H:i:s');

        if ($request->hasFile('foto_pulang')) {
            $path = $request->file('foto_pulang')->store('absensi', 'public');
            $absensi->foto_pulang = $path;
        }

        $absensi->save();

        return redirect()->back()->with('success', 'Absen pulang berhasil dicatat!');
    }

    public function riwayat()
    {
        $user = auth()->user();
        $query = Absensi::with('siswaPkl');

        // Jika user adalah siswa, hanya tampilkan absensi mereka sendiri
        if ($user->role === 'user') {
            if (!$user->siswaPkl) {
                return redirect()->route('dashboard')->with('error', 'Profile siswa tidak ditemukan!');
            }
            $query->where('siswa_pkl_id', $user->siswaPkl->id);
        }

        $absensi = $query->orderBy('tanggal', 'desc')
            ->orderBy('jam_masuk', 'desc')
            ->paginate(20);

        return view('absensi.riwayat', compact('absensi'));
    }

    public function laporan(Request $request)
    {
        $user = auth()->user();
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $query = Absensi::with('siswaPkl')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);

        // Jika user adalah siswa, hanya tampilkan laporan mereka sendiri
        if ($user->role === 'user') {
            if (!$user->siswaPkl) {
                return redirect()->route('dashboard')->with('error', 'Profile siswa tidak ditemukan!');
            }
            $query->where('siswa_pkl_id', $user->siswaPkl->id);
            $siswa = collect([$user->siswaPkl]);
        } else {
            // Admin bisa lihat semua siswa
            $siswa = SiswaPkl::all();
        }

        $absensi = $query->get();

        return view('absensi.laporan', compact('absensi', 'siswa', 'bulan', 'tahun'));
    }

    public function absenIzin(Request $request)
    {
        $validated = $request->validate([
            'siswa_pkl_id' => 'required|exists:siswa_pkl,id',
            'keterangan' => 'nullable|string|max:255'
        ]);

        // Jika user adalah siswa, pastikan hanya bisa izin diri sendiri
        if (auth()->user()->role === 'user') {
            $siswaPkl = auth()->user()->siswaPkl;
            if (!$siswaPkl || $siswaPkl->id != $validated['siswa_pkl_id']) {
                return redirect()->back()->with('error', 'Anda hanya bisa melaporkan izin untuk diri sendiri!');
            }
        }

        $absensi = Absensi::firstOrCreate(
            [
                'siswa_pkl_id' => $validated['siswa_pkl_id'],
                'tanggal' => now('Asia/Jakarta')->toDateString()
            ],
            [
                'status' => 'izin',
                'keterangan' => $validated['keterangan'] ?? null
            ]
        );

        // Jika sudah ada record, update status menjadi izin jika belum ada jam masuk
        if (!$absensi->wasRecentlyCreated && !$absensi->jam_masuk) {
            $absensi->update([
                'status' => 'izin',
                'keterangan' => $validated['keterangan'] ?? $absensi->keterangan
            ]);
        }

        return redirect()->back()->with('success', 'Status izin berhasil dicatat!');
    }

    public function absenSakit(Request $request)
    {
        $validated = $request->validate([
            'siswa_pkl_id' => 'required|exists:siswa_pkl,id',
            'keterangan' => 'nullable|string|max:255'
        ]);

        // Jika user adalah siswa, pastikan hanya bisa sakit diri sendiri
        if (auth()->user()->role === 'user') {
            $siswaPkl = auth()->user()->siswaPkl;
            if (!$siswaPkl || $siswaPkl->id != $validated['siswa_pkl_id']) {
                return redirect()->back()->with('error', 'Anda hanya bisa melaporkan sakit untuk diri sendiri!');
            }
        }

        $absensi = Absensi::firstOrCreate(
            [
                'siswa_pkl_id' => $validated['siswa_pkl_id'],
                'tanggal' => now('Asia/Jakarta')->toDateString()
            ],
            [
                'status' => 'sakit',
                'keterangan' => $validated['keterangan'] ?? null
            ]
        );

        // Jika sudah ada record, update status menjadi sakit jika belum ada jam masuk
        if (!$absensi->wasRecentlyCreated && !$absensi->jam_masuk) {
            $absensi->update([
                'status' => 'sakit',
                'keterangan' => $validated['keterangan'] ?? $absensi->keterangan
            ]);
        }

        return redirect()->back()->with('success', 'Status sakit berhasil dicatat!');
    }

    public function absenAlpa(Request $request)
    {
        $validated = $request->validate([
            'siswa_pkl_id' => 'required|exists:siswa_pkl,id',
            'keterangan' => 'nullable|string|max:255'
        ]);

        // Jika user adalah siswa, pastikan hanya bisa alpa diri sendiri
        if (auth()->user()->role === 'user') {
            $siswaPkl = auth()->user()->siswaPkl;
            if (!$siswaPkl || $siswaPkl->id != $validated['siswa_pkl_id']) {
                return redirect()->back()->with('error', 'Anda hanya bisa melaporkan alpa untuk diri sendiri!');
            }
        }

        $absensi = Absensi::firstOrCreate(
            [
                'siswa_pkl_id' => $validated['siswa_pkl_id'],
                'tanggal' => now('Asia/Jakarta')->toDateString()
            ],
            [
                'status' => 'alpha',
                'keterangan' => $validated['keterangan'] ?? null
            ]
        );

        // Jika sudah ada record, update status menjadi alpa jika belum ada jam masuk
        if (!$absensi->wasRecentlyCreated && !$absensi->jam_masuk) {
            $absensi->update([
                'status' => 'alpha',
                'keterangan' => $validated['keterangan'] ?? $absensi->keterangan
            ]);
        }

        return redirect()->back()->with('success', 'Status alpa berhasil dicatat!');
    }
}
