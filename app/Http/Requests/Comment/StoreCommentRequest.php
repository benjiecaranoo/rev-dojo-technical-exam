<?php

namespace App\Http\Requests\Comment;

use App\Enums\CommentType;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(
        User $authenticatedUser,
        User $user
    ): bool {
        return $authenticatedUser->id === $user->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'body' => ['required', 'string'],
            'commentable_id' => ['required', 'integer'],
            'commentable_type' => ['required', 'string', Rule::in(CommentType::getValues())],
        ];
    }


}
