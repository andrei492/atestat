<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;


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
 
        // TODO: salveaza imaginea pe disc in zona publica
        // TODO: salveaza in baza de date calea catre poza si autorul
        // Store the blog post...
 
        // return redirect('/posts');
        dd("verificare facuta");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
