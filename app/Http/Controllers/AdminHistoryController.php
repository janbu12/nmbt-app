<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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

    public function show($id)
    {
        $rent = Rent::with(['user', 'rent_details.product'])->find($id);

        $user = $rent->user;
        $userName = $user ? $user->firstname . ' ' . $user->lastname : 'Guest';

        return view('invoice', [
            'rent' => $rent,
            'user' => $userName,
        ]);
    }

    public function status(Request $request, $id)
    {
        Gate::authorize('isAdmin');
        $rent = Rent::findOrFail($id);

        // Logika untuk mengubah status berdasarkan status saat ini
        switch ($rent->status_rent) {
            case 'unpaid':
                $rent->status_rent = 'process';
                break;
            case 'process':
                $rent->status_rent = 'ready_pickup';
                break;
            case 'ready_pickup':
                $rent->status_rent = 'renting';
                break;
            case 'renting':
                $rent->status_rent = 'done';
                break;
            default:
                return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $rent->save();

        return redirect()->route('admin.history')->with('success', 'Status berhasil diubah.');
    }

}
