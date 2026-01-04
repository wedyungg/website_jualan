<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::latest()->get();
        return view('admin.packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'duration_hours' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'features' => 'nullable|string',
            'is_active' => 'boolean'
        ]);
        
        // Handle features (convert from textarea to array)
        if ($request->has('features') && !empty($request->features)) {
            $features = array_filter(
                explode("\n", $request->features),
                function($line) {
                    return trim($line) !== '';
                }
            );
            $validated['features'] = $features;
        }
        
        // Handle image upload
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('packages', 'public');
            $validated['cover_image'] = $path;
        }
        
        // Default is_active to true if not set
        $validated['is_active'] = $request->has('is_active');
        
        // Create package
        Package::create($validated);
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'Package created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        return view('admin.packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        return view('admin.packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
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
        
        // Handle features
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
        
        // Handle image upload
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($package->cover_image) {
                Storage::disk('public')->delete($package->cover_image);
            }
            
            $path = $request->file('cover_image')->store('packages', 'public');
            $validated['cover_image'] = $path;
        } else {
            // Keep existing image
            $validated['cover_image'] = $package->cover_image;
        }
        
        $validated['is_active'] = $request->has('is_active');
        
        $package->update($validated);
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'Package updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        // Delete image if exists
        if ($package->cover_image) {
            Storage::disk('public')->delete($package->cover_image);
        }
        
        $package->delete();
        
        return redirect()->route('admin.packages.index')
            ->with('success', 'Package deleted successfully!');
    }
}