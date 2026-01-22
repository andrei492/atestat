<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $token = csrf_token();
        return view('posts.new');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'upload_file' => [
                'required',
                File::image()
                     ->max(12 * 1024),
            ],
        ]);
 
        if ($validator->fails()) {
            return redirect(route('posts.create'))
                        ->withErrors($validator)
                        ->withInput();
        }

        // Upload to Cloudinary using the uploadApi
        $uploadedFile = Cloudinary::uploadApi()->upload($request->file('upload_file')->getRealPath(), [
            'folder' => 'socialapp/posts/' . auth()->id(),
            'transformation' => [
                'width' => 1080,
                'height' => 1080,
                'crop' => 'limit',
                'quality' => 'auto',
            ]
        ]);
        
        $url = $uploadedFile['secure_url'];

        $post = new Post();
        $post->image_path = $url;
        $post->author_id = auth()->id();
        $post->save();
 
        return redirect(route('posts.show', $post));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //dd(storage_path(), public_path());
        $post = Post::with(['user', 'likes', 'comments.user'])->findOrFail($id);
        return view('posts.show', ['post'=>$post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
}
