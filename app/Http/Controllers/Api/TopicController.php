<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Topic::with('user', 'comments')->get();
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

        return response()->json($topic, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Topic::with('user', 'comments')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TopicRequest $request, string $id)
    {
        $topic = Topic::findOrFail($id);

        $topic->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return response()->json(['message' => 'Topic updated successfully', 'topic' => $topic]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $topic = Topic::findOrFail($id);

        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $topic->delete();

        return response()->json(['message' => 'Topic deleted successfully']);
    }
}
