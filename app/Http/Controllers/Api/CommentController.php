<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Topic;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Comment::with('user', 'topic')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $topicId)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $topic = Topic::findOrFail($topicId);

        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $comment = new Comment();
        $comment->user_id = $request->user()->id;
        $comment->topic_id = $topic->id;
        $comment->body = $request->body;
        $comment->save();

        return response()->json($comment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Comment::with('user', 'topic')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'body' => 'required|string',
        ]);

        $comment = Comment::findOrFail($id);

        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $comment->update([
            'body' => $request->body,
        ]);

        return response()->json(['message' => 'Comment updated successfully', 'comment' => $comment]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);

        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
