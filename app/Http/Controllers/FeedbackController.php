<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $user = $request->user(); // Assuming you are using Passport for authentication

        // Create feedback
        $feedback = new Feedback();
        $feedback->user_id = $user ? $user->id : null;
        $feedback->title = $request->input('title');
        $feedback->category = $request->input('category');
        $feedback->description = $request->input('description');
        $feedback->save();

        return response()->json(['message' => 'Feedback submitted successfully'], 201);
    }
    
    public function index(Request $request)
    {
        $feedbacks = Feedback::with(['user','comments'])->orderBy('created_at', 'desc')->paginate(10);

        return response()->json(['feedbacks' => $feedbacks], 200);
    }
}
