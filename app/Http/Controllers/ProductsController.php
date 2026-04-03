<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : View
    {
        $categories = Categories::with('products')->orderBy('sort','asc')->get();
        $products = Products::orderBy('created_at','asc')->get();
        return view('products.index', compact('categories','products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $categories = Categories::OrderBy('sort','asc')->get();
        return view('products.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'categories' => 'required',
            'price' => 'required',
            'cost_price' => 'required',
            'stock' => 'required',
        ]);

        $file = $request->file('picture');
        if($file != null ) {
            $filename = $file->hashName();
            $file->storeAs('products', $filename);
        } else {
            $filename = "";
        }
        Products::create([
            'name' => $request->name,
            'category_id' => $request->categories,
            'price' => $request->price,
            'cost_price' => $request->cost_price,
            'stock' => $request->stock,
            'description' => $request->description,
            'picture' => $filename,
            'is_active' => 0,
        ]);

        return redirect()->route('products.index')->with('success','Sucessfully Add Product');
    }

    /**
     * Display the specified resource.
     */
    public function show(String $uuid)
    {
        $products = Products::with('category')->findOrFail($uuid);

        return response()->json([
            'success' => true,
            'product' => $products
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(String $uuid) : View
    {
        $product = Products::findOrFail($uuid);
        $categories = Categories::OrderBy('sort','asc')->get();

        return view('products.edit',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, String $uuid)
    {
        $product = Products::findOrFail($uuid);

        $request->validate([
            'name' => 'required',
            'categories' => 'required',
            'price' => 'required',
            'cost_price' => 'required',
            'stock' => 'required',
        ]);
        
        $file = $request->file('picture');

        if($file == null && $request->is_deleted == 0) {
            $filename = $product->picture;
        } else if($file == null && $request->is_deleted == 1) {
            $oldPath = storage_path('app/public/products/') . $product->picture;
            unlink($oldPath);
            $filename = "";
        } else if($file != null && $request->is_deleted == 1) {
            $oldPath = storage_path('app/public/products/') . $product->picture;
            unlink($oldPath);
            $filename = $file->hashName();
            $file->storeAs('products', $filename);
        } else {
            $filename = $file->hashName();
            $file->storeAs('products', $filename);
        }
        $product->update([
            'name' => $request->name,
            'category_id' => $request->categories,
            'price' => $request->price,
            'cost_price' => $request->cost_price,
            'stock' => $request->stock,
            'description' => $request->description,
            'picture' => $filename
        ]);

        return redirect()->route('products.index')->with('success','Successfully Edit Product');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $uuid)
    {
        $product = Products::findOrFail($uuid);

        if($product->picture != "") {
            $oldPath = storage_path('app/public/products/') . $product->picture;
            unlink($oldPath);
        }
        $product->delete();

        return response()->json(['success' => true, 'message' => 'Successfully Delete Product']);
    }
    /**
     * Toggle products is active or not
     */
    public function activeToggle(String $uuid,Request $request) {
        $product = Products::findOrFail($uuid);

        $active = $request->active;
        if($active == "true") {
            $active = 1;
        } else {
            $active = 0;
        }

        $product->update([
            'is_active' => $active,
        ]);

        return response()->json(['success'=> true]);
    }
}
