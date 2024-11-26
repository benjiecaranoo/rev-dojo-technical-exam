<?php

namespace Tests\Feature\Controllers\V1\CommentController;

use App\Enums\CommentType;
use App\Models\Comment;
use App\Models\Picture;
use App\Models\Post;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use WithFaker;
    /**
     * @test
     */
    public function authenticated_users_can_view_all_post_comments()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $comment = Comment::factory(5)->create([
            'body' => 'This is a test comment.',
            'commentable_type' => get_class($post),
            'commentable_id' => $post->id
        ]);
    

        $response = $this->actingAs($user)->getJson(route('comments.index', [ CommentType::POST, $post->id]));

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->expectedDataType()
                ],
                'links',
                'meta'
            ]);
    }

    /**
     * @test
     */
    public function authenticated_users_can_view_all_video_comments()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();

        $comment = Comment::factory(5)->create([
            'body' => 'This is a test comment.',
            'commentable_type' => get_class($video),
            'commentable_id' => $video->id
        ]);
    

        $response = $this->actingAs($user)->getJson(route('comments.index', [ CommentType::VIDEO, $video->id]));

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->expectedDataType()
                ],
                'links',
                'meta'
            ]);
    }

     /**
     * @test
     */
    public function authenticated_users_can_view_all_picture_comments()
    {
        $user = User::factory()->create();
        $picture = Picture::factory()->create();

        $comment = Comment::factory(5)->create([
            'body' => 'This is a test comment.',
            'commentable_type' => get_class($picture),
            'commentable_id' => $picture->id
        ]);
    

        $response = $this->actingAs($user)->getJson(route('comments.index', [ CommentType::PICTURE, $picture->id]));

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->expectedDataType()
                ],
                'links',
                'meta'
            ]);
    }

    protected function expectedDataType() 
    {
        return [
            'id',
            'body',
            'created_at',
            'updated_at',
            'commentable_id',
            'commentable_type',
            'author' => [
                'id',
                'name',
                'email',
                'created_at'
            ],
        ];
    }

}
