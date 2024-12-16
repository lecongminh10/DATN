<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Requests\BrandRequest;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
{
    $request->validated();

    $brands = new Brand();

    if ($request->hasFile('image')) {
        $brands->image = $request->file('image')->store('brands', 'public');
    }

    $brands->name = $request->input('name');
    $brands->active = $request->has('active') ? 1 : 0;
    $brands->save();

    return redirect()->route('admin.brand.index')->with('success', 'Thêm thương hiệu thành công.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, $id)
    {
        $request->validated();

        $brand = Brand::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($brand->image) {
                Storage::disk('public')->delete($brand->image);
            }
            $brand->image = $request->file('image')->store('brands', 'public');
        }

        $brand->name = $request->input('name');
        $brand->active = $request->has('active') ? 1 : 0;
        $brand->save();

        return redirect()->route('admin.brand.index')->with('success', 'Cập nhật thương hiệu thành công.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
