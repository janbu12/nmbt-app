<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit() {
        $user = Auth::user();
        return view('users.edit', compact('user'));
    }

    public function update(Request $request) {
        $user = Auth::user();

        // dd($request);

        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'password' => 'nullable|confirmed|min:8',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'birthdate' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'imageUser' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update user details
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
        $user->birthdate = $request->input('birthdate');
        // $user->gender = $request->input('gender');

        $genderMap = [
            'male' => 'm',
            'female' => 'f',
        ];

        $user->gender = $genderMap[$request->input('gender')];

        // Check if a new password has been provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        // Handle profile image upload
        if ($request->hasFile('imageUser')) {
            // Delete the old image if it exists
            if ($user->imageUser) {
                Storage::disk('public')->delete($user->imageUser);
            }

            // Store the new image
            $imagePath = $request->file('imageUser')->store('profile_images', 'public');
            $user->imageUser = $imagePath;
        }

        // Save the updated user information
        $user->save();

        return redirect()->route('user.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
