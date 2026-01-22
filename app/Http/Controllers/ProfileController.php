<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Post;
use App\Models\User;
use App\Models\Follower;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
 

class ProfileController extends Controller
{
    public function showMyProfile()
    {
        $user = Auth::user();

        
        $posts = Post::where('author_id', $user->id)->latest()->get();

        return view('users.showmyprofile', compact('user', 'posts'));
    }

    // Method to show a user's profile
    public function show($id)
    {

        $user = User::findOrFail($id);  // Find the user by ID, or fail if not found
        $posts = Post::where('author_id', $id)->latest()->get();
        //dd($posts);
        //return view('users.profile', compact('user', 'posts'));
        $isFollowing = Follower::where('follower_id', Auth::user()->id)->where('following_id', $id)->first();
        //dd(Auth::user()->id, $id, $isFollowing);
        return view('users.profile', compact('user', 'posts', 'isFollowing'));
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
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240', // Validate image file (10MB max)
        ]);

        $user = Auth::user();

        // If user already has a profile photo on Cloudinary, delete the old one
        if ($user->profile_photo && str_contains($user->profile_photo, 'cloudinary')) {
            // Extract public_id from URL and delete from Cloudinary
            try {
                $publicId = $this->extractCloudinaryPublicId($user->profile_photo);
                if ($publicId) {
                    Cloudinary::destroy($publicId);
                }
            } catch (\Exception $e) {
                // Log error but continue with upload
            }
        }

        // Upload to Cloudinary
        $uploadedFile = Cloudinary::upload($request->file('photo')->getRealPath(), [
            'folder' => 'socialapp/profiles/' . $user->id,
            'transformation' => [
                'width' => 400,
                'height' => 400,
                'crop' => 'fill',
                'gravity' => 'face',
            ]
        ]);
        
        $url = $uploadedFile->getSecurePath();

        // Save the Cloudinary URL in the user's profile_photo field
        $user->profile_photo = $url;
        $user->save();

        return back()->with('success', 'Profile photo updated successfully!');
    }

    /**
     * Extract public_id from Cloudinary URL
     */
    private function extractCloudinaryPublicId($url)
    {
        if (preg_match('/\/v\d+\/(.+)\.[a-z]+$/i', $url, $matches)) {
            return $matches[1];
        }
        return null;
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

    public function toggleFollow($id)
    {
        $user = auth()->user();  // Logged-in user

        // Prevent self-follow
        if ($user->id == $id) {
            return back()->with('error', 'You cannot follow yourself.');
        }

        $follow = Follower::where('follower_id', $user->id)->where('following_id', $id)->first();
        if($follow){
            $follow->delete();
        }
        else{
            Follower::create([
                'follower_id' => $user->id,
                'following_id' => $id,
            ]);
        }
        return back();  // Redirect back to the profile page
    }

    public function feed()
    {
        $user = Auth::user(); // Get the logged-in user

        // Get the IDs of the users that the logged-in user is following
        $followingIds = Follower::where('follower_id', $user->id)->pluck('following_id');

        // Fetch the posts of the users the logged-in user is following
        // Eager load user, likes, and comments for better performance
        $posts = Post::whereIn('author_id', $followingIds)
            ->with(['user', 'likes', 'comments'])
            ->orderBy('id', 'desc') 
            ->paginate(10);
        //dd($user, $followingIds, $posts); 
        // Return the feed view with the posts
        return view('posts.feed', compact('posts'));
    }

    

}
