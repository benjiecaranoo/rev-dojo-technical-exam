<?php

namespace Tests\Feature\Controllers\V1\CommentController;

use App\Enums\CommentType;
use App\Models\Picture;
use App\Models\Post;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    /**
     * @test
     */
    public function authenticated_user_can_add_comment_to_a_post()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();
    
        $commentData = [
            'body' => 'This is a test comment.',
            'commentable_type' => CommentType::POST,
            'commentable_id' => $post->id,
        ];

        $response = $this->actingAs($user)->postJson(route('comments.store'), $commentData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'data' => $this->expectedResponse(),
                ]);

        $this->assertDatabaseHas('comments', [
            'body' => $commentData['body'],
            'commentable_id' => $post->id,
            'author_id' => $user->id,
        ]);
    }

    /**
     * @test
     */
    public function authenticated_user_can_add_comment_to_a_video()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();
    
        $commentData = [
            'body' => 'This is a test comment.',
            'commentable_type' => CommentType::VIDEO,
            'commentable_id' => $video->id,
        ];

        $response = $this->actingAs($user)->postJson(route('comments.store'), $commentData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'data' => $this->expectedResponse(),
                ]);

        $this->assertDatabaseHas('comments', [
            'body' => $commentData['body'],
            'commentable_id' => $video->id,
            'author_id' => $user->id,
        ]);
    }

    /**
     * @test
     */
    public function authenticated_user_can_add_comment_to_a_picture()
    {
        $user = User::factory()->create();
        $picture = Picture::factory()->create();
    
        $commentData = [
            'body' => 'This is a test comment.',
            'commentable_type' => CommentType::PICTURE,
            'commentable_id' => $picture->id,
        ];

        $response = $this->actingAs($user)->postJson(route('comments.store'), $commentData);

        $response->assertStatus(201)
                ->assertJsonStructure([
                    'data' => $this->expectedResponse(),
                ]);

        $this->assertDatabaseHas('comments', [
            'body' => $commentData['body'],
            'commentable_id' => $picture->id,
            'author_id' => $user->id,
        ]);
    }

    /**
     * @test
     */
    public function unauthenticated_user_should_not_be_avail_to_add_comment_to_a_post()
    {
        $post = Post::factory()->create();
    
        $commentData = [
            'body' => 'This is a test comment.',
            'commentable_type' => 'post',
            'commentable_id' => $post->id,
        ];

        $response = $this->postJson(route('comments.store'), $commentData);

        $response->assertUnauthorized();
    }

    /**
     * @test
     */
    public function validate_body_field_is_required()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $commentData = [
            'body' => '',
            'commentable_type' => CommentType::POST,
            'commentable_id' => $post->id,
        ];

        $response = $this->actingAs($user)->postJson(route('comments.store'), $commentData);

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function validate_commentable_id_field_is_required()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $commentData = [
            'body' => 'test comment',
            'commentable_type' => '',
            'commentable_id' => $post->id,
        ];

        $response = $this->actingAs($user)->postJson(route('comments.store'), $commentData);

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function validate_commentable_type_should_be_valid()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $commentData = [
            'body' => 'test comment',
            'commentable_type' => 'invalid',
            'commentable_id' => $post->id,
        ];

        $response = $this->actingAs($user)->postJson(route('comments.store'), $commentData);

        $response->assertStatus(422);
    }

    /**
     * @test
     */
    public function validate_commentable_type_field_is_required()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $commentData = [
            'body' => 'test comment',
            'commentable_type' => CommentType::POST,
            'commentable_id' => null,
        ];

        $response = $this->actingAs($user)->postJson(route('comments.store'), $commentData);

        $response->assertStatus(422);
    }

    private function expectedResponse()
    {
        return  [
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
