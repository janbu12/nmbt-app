<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel as Category;
use App\Models\ProductImageModel as ProductImage;
use App\Models\ProductRentModel as Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductsRentController extends Controller
{
    public function index(Request $request){
        $query = Product::query();

        // Filter berdasarkan kategori
        if ($request->has('category')) {
            $categories = $request->input('category');
            $query->whereIn('category_id', $categories);  // Menyaring produk berdasarkan beberapa kategori
        }

        // Filter berdasarkan urutan
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            // Menambahkan logika pengurutan berdasarkan 'sort'
            if ($sort == 'Lowest Price') {
                $query->orderBy('price', 'asc');
            } elseif ($sort == 'Highest Price') {
                $query->orderBy('price', 'desc');
            } elseif ($sort == 'Rating') {
                // Melakukan join dengan tabel reviews dan menghitung rata-rata rating
                $query->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
                ->select('products.*', DB::raw('AVG(reviews.rating) as average_rating'))
                ->groupBy('products.id') // Mengelompokkan berdasarkan ID produk
                ->orderBy('average_rating', 'desc'); // Mengurutkan berdasarkan rata-rata rating
            }
            // Filter lain sesuai kebutuhan
        }

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->where('products.name', 'like', "%$search%")
            ->orWhere('categories.category_name', 'like', "%$search%");
        }

        $products = $query->paginate(6);

        $categories = Category::all();
        $filters = ['Rating', 'Lowest Price', 'Highest Price'];
        $totalProducts = Product::count();

        return view('products.index', compact('products', 'categories', 'filters', 'totalProducts'));
    }

    public function create()
    {
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
        Gate::authorize('isAdmin');
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
        Gate::authorize('isAdmin');
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
        Gate::authorize('isAdmin');
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

    public function destroy($id)
    {
        Gate::authorize('isAdmin');
        $product = Product::findOrFail($id);

        // Hapus gambar lama dari penyimpanan dan database
        if($product->images)
        {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_path);
                    $image->delete();
            }
        }

        // Hapus produk dan ulasan
        $product->delete();
        $product->reviews()->delete();

        return redirect()->back()->with('delete', 'Product deleted successfully!');
    }


    public function show($id)
    {
        $product = Product::with('images')->findOrFail($id);
        // $reviews = $product->reviews()->paginate(5);
        $rating = request()->get('rating');

        // Filter ulasan berdasarkan rating
        if ($rating) {
            $reviews = $product->reviews()
                                ->where('rating', $rating)
                                ->with('user')  // Mengambil informasi pengguna
                                ->orderBy('id', 'desc')
                                ->get();
        } else {
            // Jika tidak ada filter rating, ambil semua ulasan
            $reviews = $product->reviews()
            ->with('user')
            ->orderBy('id', 'desc')
            ->get();
        }

        return view('products.show',compact('product', 'reviews'));
    }
}
