<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterSubscriber;

class NewslettersubscriberController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:newsletter_subscribers,email',
        ]);

        $newsletter  = NewsletterSubscriber::create($request->all());

        return response()->json([
            'message' => 'Successfully subscribed to the newsletter!',
            'success' => true,
            'message' => 'Subscribed successfully',
            'data' => $newsletter,
        ], 201);
    }



    // Fetch all newsletter subscribers (for admin)
    public function getSubscribers()
    {
        return NewsletterSubscriber::all();
    }
}
