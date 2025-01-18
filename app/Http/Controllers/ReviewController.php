<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function show($id)
    {
        $rent = Rent::with(['rent_details.product.images', 'rent_details.product.reviews' => function($query) {
            $query->where('user_id', Auth::id());
        }])->findOrFail($id);
        return view('reviews.form', compact('rent'));
    }

    public function submitReview(Request $request, $id)
    {
        $request->validate([
            'reviews.*.rating' => 'required|integer|between:1,5',
            'reviews.*.comment' => 'required|string|max:255',
            'reviews.*.product_id' => 'required|exists:products,id',
        ],[
            'reviews.*.rating.required' => 'Rating harus diisi.',
            'reviews.*.rating.integer' => 'Rating harus berupa angka.',
            'reviews.*.rating.between' => 'Rating harus antara 1-5.',
            'reviews.*.comment.required' => 'Komentar harus diisi.',
            'reviews.*.comment.max' => 'Komentar maksimal 255 karakter.',
            'reviews.*.product_id.required' => 'Produk harus dipilih.',
            'reviews.*.product_id.exists' => 'Produk yang dipilih tidak ditemukan.',
         ]);

        // dd($request);

        foreach ($request->reviews as $reviewData) {
            Review::create([
                'user_id' => Auth::user()->id,
                'product_id' => $reviewData['product_id'],
                'rating' => $reviewData['rating'],
                'comment' => $reviewData['comment'],
                'rent_id' => $id,
            ]);
        }

        $rent = Rent::findOrFail($id);
        $rent->status_rent = 'reviewed';

        return redirect()->route('history.index')->with('success', 'Review berhasil dikirim.');
    }
}
