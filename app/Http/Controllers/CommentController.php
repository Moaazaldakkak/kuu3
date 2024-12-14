<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Profile;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Profile $profile)
    {

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $profile->comments()->create([
            'user_id' => auth()->id(),       // Authenticated user
            'content' => $validated['content'], // Comment content
        ]);

        return redirect()->route('profiles.show', $profile->id)
                         ->with('success', 'Comment added successfully!');
    }

    public function destroy(Profile $profile, Comment $comment)
    {
        // Ensure the authenticated user is the owner of the comment
        if (auth()->id() !== $comment->user_id) {
            abort(403, 'Unauthorized action.');
        }
    
        // Soft delete the comment
        $comment->delete();
    
        return response()->json([
            'message' => 'Comment soft-deleted successfully!',
            'deleted_comment' => [
                'created_at' => $comment->created_at->format('M d, Y'),
                'deleted_at' => now()->format('M d, Y'),
                'user_name' => $comment->user->name,
            ],
        ]);
    }
    
}
