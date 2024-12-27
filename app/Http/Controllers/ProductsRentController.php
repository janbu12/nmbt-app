<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel as Category;
use App\Models\ProductImageModel as ProductImage;
use App\Models\ProductRentModel as Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ProductsRentController extends Controller
{
    public function index(){
        $products = Product::with('images')->paginate(9);
        $categories = Category::all();
        $filters = ['Rating', 'Harga Terkecil', 'Harga Terbesar'];
        $totalProducts = Product::count();

        return view('products.index', compact('products', 'categories', 'filters', 'totalProducts'));
    }

    public function create() {
        Gate::authorize('isAdmin');
        $categories = Category::all();
        return view('products.create',[
            'categories'=> $categories,
            'page_meta' => [
                'title' => 'Create Product',
                'method' => 'POST',
                'url' => route('products.store')
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'teaser' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::create($request->only(['name', 'category_id', 'description', 'teaser', 'price', 'stock']));

        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('products.edit', [
            'page_meta' => [
                'title' => 'Edit Product',
                'url' => route('products.update', $product->id),
            ],
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'teaser' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::findOrFail($id);

        // Update product information
        $product->update($request->only(['name', 'category_id', 'description', 'teaser', 'price', 'stock']));

        if ($request->hasFile('images')) {
            // Hapus gambar lama dari penyimpanan dan database
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }

            // Simpan gambar baru
            foreach ($request->file('images') as $file) {
                $path = $file->store('product_images', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product edit successfully!');
    }


    public function show($id)
    {
        $product = Product::with('images')->findOrFail($id);

        return view('products.show', compact('product'));
    }
}
