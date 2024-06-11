<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Topic;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topics = Topic::with('user', 'comments')->get();
        return response()->json($topics);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TopicRequest $request)
    {
        $topic = new Topic();
        $topic->user_id = $request->user()->id;
        $topic->title = $request->title;
        $topic->body = $request->body;
        $topic->save();

        return response()->json(
            [
                'message' => 'Topic created successfully',
                'topic' => $topic
            ], 201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $topic = Topic::with('user', 'comments')->findOrFail($id);
        return response()->json($topic);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TopicRequest $request, Topic $topic)
    {
        $topic->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return response()->json(
            [
                'message' => 'Topic updated successfully',
                'topic' => $topic
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Topic $topic)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $topic->delete();

        return response()->json(
            [
                'message' => 'Topic deleted successfully'
            ]
        );
    }
}
