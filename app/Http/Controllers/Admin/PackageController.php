<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    /**
     * Menampilkan daftar semua paket fotografi.
     */
    public function index()
    {
        $packages = Package::latest()->get();
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Menampilkan formulir tambah paket baru.
     */
    public function create()
    {
        return view('admin.packages.create');
    }

    /**
     * Menyimpan paket baru ke dalam database.
     */
    public function store(Request $request)
    {
        // Validasi data masukan
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:WEDDING,GRADUATION,ENGAGEMENT,MATERNITY', // PERBAIKAN: tambah validasi 'in'
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'duration_hours' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'nullable|string',
            'is_active' => 'nullable|boolean' // PERBAIKAN: nullable agar tidak error
        ]);
        
        // PERBAIKAN: Konversi checkbox is_active
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        // Mengolah fitur (konversi dari baris baru di textarea menjadi array)
        if ($request->has('features') && !empty($request->features)) {
            $features = array_filter(
                explode("\n", $request->features),
                function($line) {
                    return trim($line) !== '';
                }
            );
            $validated['features'] = $features;
        }
        
        // Mengelola unggahan gambar cover
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('packages', 'public');
            $validated['cover_image'] = $path;
        }
        
        // Simpan data paket
        Package::create($validated);
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket fotografi baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir ubah paket.
     */
    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Memperbarui data paket di database.
     */
    public function update(Request $request, Package $package)
    {
        // ==================== PERBAIKAN UTAMA DI SINI ====================
        
        // 1. Validasi data - FIX VALIDASI CATEGORY DAN IS_ACTIVE
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:WEDDING,GRADUATION,ENGAGEMENT,MATERNITY', // PERBAIKAN 1: Validasi ketat dengan 'in'
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string', 
            'duration_hours' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'nullable|string',
            'is_active' => 'nullable' // PERBAIKAN 2: Ubah jadi nullable, nanti kita proses manual
        ]);
        
        // PERBAIKAN 3: Konversi checkbox is_active menjadi boolean
        // Checkbox HTML: jika dicentang = 'on', jika tidak dicentang = null/tidak ada
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        // PERBAIKAN 4: Pastikan category tidak null setelah validasi
        if (!isset($validated['category']) || empty($validated['category'])) {
            return back()->withErrors(['category' => 'Kategori harus dipilih'])->withInput();
        }
        
        // 2. Olah Fitur (dari textarea menjadi array)
        if ($request->has('features') && !empty($request->features)) {
            $features = array_filter(explode("\n", $request->features), function($line) {
                return trim($line) !== '';
            });
            $validated['features'] = $features;
        } else {
            $validated['features'] = null;
        }
        
        // 3. Olah Gambar (hapus yang lama jika ganti yang baru)
        if ($request->hasFile('cover_image')) {
            // Hapus gambar lama jika ada
            if ($package->cover_image && Storage::disk('public')->exists($package->cover_image)) {
                Storage::disk('public')->delete($package->cover_image);
            }
            // Simpan gambar baru
            $validated['cover_image'] = $request->file('cover_image')->store('packages', 'public');
        } else {
            // Pertahankan gambar lama
            $validated['cover_image'] = $package->cover_image;
        }
        
        // PERBAIKAN 5: Debugging - lihat data sebelum diupdate
        // dd($validated); // Uncomment jika ingin lihat data
        
        // 4. Update ke Database
        $package->update($validated);
        
        // 5. Redirect dengan pesan sukses
        return redirect()->route('admin.packages.index')
            ->with('success', 'Perubahan data paket berhasil disimpan.');
    }

    /**
     * Menghapus paket secara permanen.
     */
    public function destroy(Package $package)
    {
        if ($package->cover_image) {
            Storage::disk('public')->delete($package->cover_image);
        }
        
        $package->delete();
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket fotografi berhasil dihapus.');
    }
}