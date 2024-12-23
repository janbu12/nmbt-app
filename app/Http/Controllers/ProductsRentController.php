<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel as Category;
use App\Models\ProductImageModel as ProductImage;
use App\Models\ProductRentModel as Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProductsRentController extends Controller
{
    public function index(){
        // $products = Product::with('images')->paginate(10);

        return view('products.index');
    }

    public function create() {
        Gate::authorize('isAdmin');
        $categories = Category::all();
        return view('products.create',[
            'categories'=> $categories,
            'page_meta' => [
                'title' => 'Create Product',
                'method' => 'POST',
                'url' => Route('products.store')
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
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::create($request->only(['name', 'category_id', 'description', 'teaser', 'price', 'stock']));

        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product created successfully!');
    }

    public function show($id)
    {
        $product = Product::with('images')->findOrFail($id);

        return view('products.show', compact('product'));
    }
}
