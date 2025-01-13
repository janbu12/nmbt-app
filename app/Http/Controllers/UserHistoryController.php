<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserHistoryController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->has('status')) {
            return redirect()->route('history.index', ['status' => 'done']);
        }

        $userId = Auth::user()->id;
        $search = $request->input('search');
        $status = $request->input('status');

        $rents = Rent::with('user')
            ->where('user_id', $userId)
            ->when($status, function($query, $status) {
                $query->where('status_rent', $status);
            })
            ->when($search, function($query, $search) {
                $query->where('id', '=', "$search")
                ->orWhere('pickup_date', 'like', "%$search%");
            })
            ->orderBy('id', 'desc') // Urutkan berdasarkan kolom ID secara descending
            ->paginate(10); // Pagination dengan 10 item per halaman


        return view('users.history', [
            'rents' => $rents,
        ]);
    }

    public function show ($id) {
        $rent = Rent::with(['user', 'rent_details.product'])->find($id);

        $user = $rent->user;
        $userName = $user ? $user->firstname . ' ' . $user->lastname : 'Guest';

        return view('invoice', [
            'rent' => $rent,
            'user' => $userName,
        ]);
    }
}
