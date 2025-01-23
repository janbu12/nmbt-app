<?php

namespace App\Http\Controllers;

use App\Exports\DetailHistoryExport;
use App\Exports\HistoryAdminExport;
use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Mail\RentStatusUpdateMail;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

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
                return redirect()->back()->with('error', 'Status invalid.');
        }

        $rent->save();

        // Kirim email setelah status diubah
        Mail::to($rent->user->email)->send(new RentStatusUpdateMail($rent, $rent->status_rent));

        return redirect()->back()->with('success', 'Success update status and email is sent.');
    }

    public function historyExcel()
    {
        return Excel::download(new HistoryAdminExport, 'rentHistory.xlsx');
    }

    public function detailHistoryExcel()
    {
        return Excel::download(new DetailHistoryExport, 'detailHistory.xlsx');
    }
}
