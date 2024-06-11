<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Topic;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::with('user', 'topic')->get();
        return response()->json($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request, Topic $topic)
    {
        $comment = new Comment();
        $comment->user_id = $request->user()->id;
        $comment->topic_id = $topic->id;
        $comment->body = $request->body;
        $comment->save();

        return response()->json(
            [
                'message' => 'Comment created successfully',
                'comment' => $comment
            ], 201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::with('user', 'topic')->findOrFail($id);
        return response()->json($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request,Comment $comment)
    {
        $comment->update([
            'body' => $request->body,
        ]);

        return response()->json(
            [
                'message' => 'Comment updated successfully',
                'comment' => $comment
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $comment->delete();

        return response()->json(
            [
                'message' => 'Comment deleted successfully'
            ]
        );
    }
}
