<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // 🛠️ Penting untuk manajemen file di folder public

class PackageController extends Controller
{
    public function index()
    {
        $packages = Package::latest()->get();
        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:WEDDING,GRADUATION,ENGAGEMENT,MATERNITY',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'duration_hours' => 'required|integer|min:1',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 🛠️ Dibuat required saat buat paket
            'features' => 'nullable|string',
            'is_active' => 'nullable'
        ]);
        
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        // Olah Fitur (textarea ke array)
        if ($request->has('features') && !empty($request->features)) {
            $validated['features'] = array_filter(explode("\n", $request->features), function($line) {
                return trim($line) !== '';
            });
        }
        
        // 🛠️ LOGIKA UPLOAD: Langsung ke public/storage/packages
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Pindahkan file ke folder public/storage/packages
            $file->move(public_path('storage/packages'), $filename);
            
            // Simpan path relatif ke database agar pemanggilan asset() konsisten
            $validated['cover_image'] = 'packages/' . $filename;
        }
        
        Package::create($validated);
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket fotografi Fokuskesini berhasil ditambahkan!');
    }

    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:WEDDING,GRADUATION,ENGAGEMENT,MATERNITY',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string', 
            'duration_hours' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'nullable|string',
            'is_active' => 'nullable'
        ]);
        
        $validated['is_active'] = $request->has('is_active') ? true : false;
        
        if ($request->has('features') && !empty($request->features)) {
            $validated['features'] = array_filter(explode("\n", $request->features), function($line) {
                return trim($line) !== '';
            });
        } else {
            $validated['features'] = null;
        }
        
        // 🛠️ LOGIKA UPDATE: Hapus yang lama, simpan yang baru
        if ($request->hasFile('cover_image')) {
            // Hapus file lama di folder public kalau ada
            if ($package->cover_image) {
                $oldPath = public_path('storage/' . $package->cover_image);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('cover_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/packages'), $filename);
            $validated['cover_image'] = 'packages/' . $filename;
        } else {
            // Tetap pakai gambar lama kalau tidak upload baru
            $validated['cover_image'] = $package->cover_image;
        }
        
        $package->update($validated);
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket berhasil diperbarui.');
    }

    public function destroy(Package $package)
    {
        // Hapus file di folder public saat paket dihapus
        if ($package->cover_image) {
            $path = public_path('storage/' . $package->cover_image);
            if (File::exists($path)) {
                File::delete($path);
            }
        }
        
        $package->delete();
        return redirect()->route('admin.packages.index')
            ->with('success', 'Paket berhasil dihapus secara permanen.');
    }
}