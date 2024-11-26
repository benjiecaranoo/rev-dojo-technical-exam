<?php

namespace App\Http\Controllers\V1\Comment;

use App\Actions\AttachComment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Models\Comment;
use App\Models\Picture;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $type, $id)
    {
        $comments = Comment::query()
        ->with('author')
        ->whereHas('commentable', function ($query) use ($type, $id) {
            $modelClass = match ($type) {
                'post' => Post::class,
                'video' => Video::class,
                'picture' => Picture::class,
                default => null,
            };
            $query->where('commentable_type', $modelClass)->where('id', $id);
        })
        ->simplePaginate($request->perPage());

        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, AttachComment $attachComment)
    {
        $comment = $attachComment->handle($request->validated());

        return CommentResource::make($comment->load('author'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment, #[CurrentUser()] $authUser)
    {
        abort_if($comment->author_id !== $authUser->id, 403, 'Unauthorized to delete this comment.');
        // if not using abort_if we can you policy but for test purposes i just use abort_if
        $comment->delete();

        return $this->respondWithEmptyData();
    }
}
