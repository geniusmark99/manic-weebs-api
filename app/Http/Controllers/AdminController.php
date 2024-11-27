<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Blog;
use App\Models\Newslettersubscriber;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{


    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'error' => 'Invalid email or password',
            ], 401);
        }

        $token = Auth::user()->createToken('authToken')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => Auth::user(),
            'message' => 'Login successful',
        ], 200);
    }

    // public function login(LoginRequest $request): Response
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     // return response()->noContent();
    //     return response()->json([
    //         'message' => 'Login successful',
    //     ]);
    // }

    public function blogStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:255',
        ]);

        $blog = Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'author' => $request->author,
        ]);

        return response()->json([
            'message' => 'Blog created successfully',
            'blog' => $blog,
        ], 201);
    }


    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }



    public function getAllSubscribers()
    {
        return NewsletterSubscriber::all();
    }

    public function getSubscriber($id)
    {
        $subscriber = Newslettersubscriber::find($id);
        if (!$subscriber) {
            return response()->json(['error' => 'Blog not found'], 404);
        } else {
            return Newslettersubscriber::findOrFail($id);
        }
    }



    public function deleteSubscriber($id)
    {
        $subscriber = Newslettersubscriber::find($id);
        if (!$subscriber) {
            return response()->json(['error' => 'Blog not found'], 404);
        } else {
            $subscriber->delete();
            return response()->json(['success' => 'Blog deleted successfully'], 200);
        }
    }
}
