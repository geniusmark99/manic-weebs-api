<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\YouTubeLink;


class YouTubeLinkController extends Controller
{

    public function index()
    {
        return YouTubeLink::all();
    }

    // Get a specific blog
    public function show($id)
    {

        $blog = YouTubeLink::find($id);
        if (!$blog) {
            return response()->json(['error' => 'Youtube link not found'], 404);
        } else {
            return YouTubeLink::findOrFail($id);
        }
    }

    public function showBySlug($slug)
    {
        $yt_link = YouTubeLink::where('slug', $slug)->first();
        if (!$yt_link) {
            return response()->json(['error' => 'Youtube link not found'], 404);
        }
        return response()->json([
            'data' => $yt_link
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'embedId' => 'required|string|max:25',
            'description' => 'required',
        ]);

        YouTubeLink::create([
            'title' =>  $request->title,
            'url' => $request->url,
            'embedId' => $request->embedId,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Youtube Link added successfully']);
    }



    // Update an existing Youtube Link (Admin only)
    public function update(Request $request, $id)
    {
        $youtubeLink = YouTubeLink::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'embedId' => 'required|string|max:25',
            'description' => 'required',
        ]);

        $youtubeLink->update($request->all());

        return response()->json(['message' => 'Blog updated successfully']);
    }



    // Delete a blog (Admin only)
    public function destroy($id)
    {
        $blog = YouTubeLink::find($id);
        if (!$blog) {
            return response()->json(['error' => 'Youtube Link not found'], 404);
        } else {
            $blog->delete();
            return response()->json(['success' => 'Youtube Link deleted successfully'], 200);
        }
    }
}
