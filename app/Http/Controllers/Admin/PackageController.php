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
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'duration_hours' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'nullable|string',
            'is_active' => 'boolean'
        ]);
        
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
        
        // Mengatur status aktif secara otomatis
        $validated['is_active'] = $request->has('is_active');
        
        // Simpan data paket
        Package::create($validated);
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket fotografi baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail paket (Opsional).
     */
    public function show(Package $package)
    {
        return view('admin.packages.show', compact('package'));
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'duration_hours' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'nullable|string',
            'is_active' => 'boolean'
        ]);
        
        // Mengolah kembali fitur
        if ($request->has('features') && !empty($request->features)) {
            $features = array_filter(
                explode("\n", $request->features),
                function($line) {
                    return trim($line) !== '';
                }
            );
            $validated['features'] = $features;
        } else {
            $validated['features'] = null;
        }
        
        // Mengelola perubahan gambar cover
        if ($request->hasFile('cover_image')) {
            // Hapus gambar lama jika ada untuk menghemat memori
            if ($package->cover_image) {
                Storage::disk('public')->delete($package->cover_image);
            }
            
            $path = $request->file('cover_image')->store('packages', 'public');
            $validated['cover_image'] = $path;
        } else {
            // Tetap gunakan gambar yang sudah ada
            $validated['cover_image'] = $package->cover_image;
        }
        
        $validated['is_active'] = $request->has('is_active');
        
        $package->update($validated);
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'Perubahan data paket berhasil disimpan.');
    }

    /**
     * Menghapus paket secara permanen.
     */
    public function destroy(Package $package)
    {
        // Hapus file gambar dari storage sebelum menghapus record database
        if ($package->cover_image) {
            Storage::disk('public')->delete($package->cover_image);
        }
        
        $package->delete();
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket fotografi berhasil dihapus secara permanen.');
    }
}