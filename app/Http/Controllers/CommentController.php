<?php

namespace App\Http\Controllers;

use App\Models\FeedbackComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request, $feedbackId)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $comment = FeedbackComment::create([
            'user_id' => Auth::id(),
            'feedback_id' => $feedbackId,
            'comment' => $request->input('comment'),
        ]);

        return response()->json(['comment' => $comment], 201);
    }

    public function index($feedbackId)
    {
        $comments = FeedbackComment::where('feedback_id', $feedbackId)->with('user')->orderBy('created_at', 'desc')->get();

        return response()->json(['comments' => $comments->toArray()], 200);
    }
}
