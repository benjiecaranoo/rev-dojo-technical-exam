<?php

namespace App\Models;

use App\Models\Trait\HasComment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Picture extends Model
{
    /** @use HasFactory<\Database\Factories\PictureFactory> */
    use HasFactory;
    use HasComment;

    /*
   |--------------------------------------------------------------------------
   | Relationships
   |--------------------------------------------------------------------------
   */

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}