<?php

namespace App\Models\Trait;

use App\Models\Comment;
use App\Models\User;

trait HasComment
{
    /**
     * List of responses in a comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

     /**
     * A helper in responding to a comment.
     *
     * @param string $body
     * @return Comment
     */
    public function comment(string $body) : Comment
    {
        return $this->commentAsUser(auth()->user(), $body);
    }

    /**
     * A helper in responding to a comment as a user.
     *
     * @param User $user
     * @param string $body
     * @return Comment
     */
    public function commentAsUser(User $user, string $body) : Comment
    {
        $comment = new Comment();
        $comment->author_id = $user->getKey();
        $comment->body      = $body;

        return $this->comments()->save($comment);
    }

}
