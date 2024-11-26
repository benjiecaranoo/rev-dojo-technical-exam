<?php

namespace App\Actions;

use App\Enums\CommentType;
use App\Models\Comment;
use App\Models\Picture;
use App\Models\Post;
use App\Models\Video;

class AttachComment
{
    public function handle($data = []): Comment
    {
        $commentableType = $data['commentable_type'];
        $commentableId = $data['commentable_id'];

        $commentable = $this->getCommentable($commentableType, $commentableId);

        $comment = $this->createComment($data, $commentableType, $commentable);

        return $comment;
    }

    /**
     * Retrieves the commentable model based on the given type and ID.
     * 
     * @param string $commentableType The type of the commentable model.
     * @param int $commentableId The ID of the commentable model.
     * @return \Illuminate\Database\Eloquent\Model|null The commentable model instance or null if not found.
     * @throws \Exception If the commentable type is not supported.
     */
    private function getCommentable($commentableType, $commentableId)
    {
        switch ($commentableType) {
            case CommentType::POST:
                return Post::find($commentableId);
            case CommentType::VIDEO:
               return Video::find($commentableId);
            case CommentType::PICTURE:
               return Picture::find($commentableId);
            default:
                throw new \Exception('Unsupported ' . $commentableType . ' type.');
        }
    }

    /**
     * Creates a new comment for the given commentable model.
     * 
     * @param array $data The data for the comment.
     * @param string $commentableType The type of the commentable model.
     * @param \Illuminate\Database\Eloquent\Model $commentable The commentable model instance.
     * @return \App\Models\Comment The newly created comment.
     * @throws \Exception If the commentable model is not found.
     */
    private function createComment($data, $commentableType, $commentable)
    {
        if (!$commentable) {
            throw new \Exception($commentableType . ' not found.');
        }

        return $commentable->comment($data['body']);
    }
}
