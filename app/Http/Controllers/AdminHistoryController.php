<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;

class AdminHistoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search'); // Input pencarian
        $status = $request->input('status'); // Input filter status

        // Query Rent dengan filter status dan pencarian
        $rents = Rent::with('user')
            ->when($status, function ($query, $status) {
                $query->where('status_rent', $status);
            })
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('firstname', 'like', "%$search%")
                      ->orWhere('lastname', 'like', "%$search%");
                })->orWhere('id', 'like', "%$search%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        // Tambahkan nama lengkap ke setiap rent
        $rents->getCollection()->transform(function ($rent) {
            $rent->full_name = $rent->user ? $rent->user->firstname . ' ' . $rent->user->lastname : 'Guest';
            return $rent;
        });

        return view('admin.history', compact('rents', 'search', 'status'));
    }
}
