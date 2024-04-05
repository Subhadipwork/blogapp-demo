<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::where('user_id', auth()->user()->id)->get();
        return view('blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        if (!auth()->check()) {
            toastr()->addError('Please login first');
            return redirect()->route('login');
        }
        $blog = new Blog();
        $blog->user_id = auth()->user()->id;
        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->save();
        if ($blog) {
            toastr()->addSuccess('Blog created successfully');
            return redirect()->route('blogs.create');
        };
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        if (!auth()->check()) {
            toastr()->addError('Please login first');
            return redirect()->route('login');
        }
        $update = $blog->update($validated);
        if ($update) {
            toastr()->addSuccess('Blog updated successfully');
            return redirect()->route('home');
        };
        toastr()->addError('An error occurred while updating');
        return back()->withErrors(['error' => 'An error occurred while updating.'])->withInput();
    }

    /**
     * Remove the specified resource from storage.
     */

    public function status(Request $request)
    {
        try {
            $blog = Blog::find($request->id);
            $blog->status = $blog->status == 0 ? 1 : 0;
            $blog->save();

            return response()->json(['status' => true, 'message' => 'Status updated successfully', 'data' => $blog], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e], 500);
        }
    }
    public function delete($id){
        try {
            $blog = Blog::findOrFail($id);
            $blog->delete();
            return response()->json(['status' => true, 'message' => 'Blog deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'An error occurred while deleting the blog'], 500);
        }
    }
    
}
