<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // Method to show a user's profile
    public function show($id)
    {
        $user = User::findOrFail($id);  // Find the user by ID, or fail if not found
        return view('users.profile', compact('user'));
    }

    // Show the search form
    public function showSearchForm()
    {
        return view('users.search'); 
        // Return the search form view
    }

    // Handle the search results
    public function search(Request $request)
    {
        $query = $request->input('query');  // Get the search query from the form
        $users = User::where('name', 'like', '%' . $query . '%')
                     ->get();

        // Return the search results view with the users and query data
        return view('users.search-results', compact('users', 'query'));
    }

    /**
     * Upload the profile picture
     */
    public function uploadPhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048', // Validate image file
        ]);

        $user = Auth::user();

        // If user already has a profile photo, delete the old one
        if ($user->profile_photo) {
            Storage::delete($user->profile_photo);
        }

        // Store the new profile photo
        $path = $request->file('photo')->store('profile_photos', 'public');

        // Save the path to the user's profile
        $user->profile_photo = $path;
        $user->save();

        return back()->with('success', 'Profile photo updated successfully!');
    }


    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
