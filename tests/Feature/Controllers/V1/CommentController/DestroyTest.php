<?php

namespace Tests\Feature\Controllers\V1\CommentController;

use App\Enums\CommentType;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    use WithFaker;
    /**
     * @test
     */
    public function authenticated_user_should_be_able_their_own_comment()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $comment = Comment::factory()->create([
            'body' => 'This is a test comment.',
            'commentable_type' => get_class($post),
            'commentable_id' => $post->id,
            'author_id' => $user->id
        ]);
    

        $response = $this->actingAs($user)->deleteJson(route('comments.destroy', ['comment' => $comment->id]));

        $response->assertSuccessful();

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id
        ]);
    }

    /**
     * @test
     */
    public function authenticated_user_should_not_be_allowed_to_delete_other_users_comment()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $post = Post::factory()->create();

        $comment = Comment::factory()->create([
            'body' => 'This is a test comment.',
            'commentable_type' => get_class($post),
            'commentable_id' => $post->id,
            'author_id' => $user2->id
        ]);
    
        $response = $this->actingAs($user)->deleteJson(route('comments.destroy', ['comment' => $comment->id]));

        $response->assertForbidden();
    }
}
