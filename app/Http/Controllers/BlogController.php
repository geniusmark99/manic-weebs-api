<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    // Get all blogs (for public view)
    public function index()
    {
        return Blog::all();
    }

    // Get a specific blog
    public function show($id)
    {

        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['error' => 'Blog not found'], 404);
        } else {
            return Blog::findOrFail($id);
        }
    }

    public function showBySlug($slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        if (!$blog) {
            return response()->json(['error' => 'Blog not found'], 404);
        }
        return response()->json([
            'data' => $blog
        ], 200);
    }

    // Create a new blog (Admin only)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'required',
        ]);

        Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'author' => $request->author,
        ]);

        return response()->json(['message' => 'Blog created successfully']);
    }

    // Update an existing blog (Admin only)
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);


        $request->validate([
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes',
            'author' => 'sometimes|string|max:255',
        ]);

        $blog->update($request->all());

        return response()->json(['message' => 'Blog updated successfully']);
    }

    // Delete a blog (Admin only)
    public function destroy($id)
    {
        $blog = Blog::find($id);
        if (!$blog) {
            return response()->json(['error' => 'Blog not found'], 404);
        } else {
            $blog->delete();
            return response()->json(['success' => 'Blog deleted successfully'], 200);
        }
    }
}
