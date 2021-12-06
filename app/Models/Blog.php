<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    use HasFactory;

    protected $casts = [
        'is_open' => 'boolean',
    ];

    protected $guarded = [];

    protected static function booted()
    {
        static::deleting(function ($blog) {
            $blog->deletePictFile();
            // $blog->comments()->delete();
            $blog->comments->each(function ($comment) {
                $comment->delete();
            });
        });
    }
    /**
     * belongTo
     */
    //blogはユーザーIDに紐づいていることを宣言
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => '(退会者)'
        ]);
    }

    /**
     * hasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->oldest();
    }

    public function scopeOnlyOpen($query)
    {
        return $query->where('is_open', true);
    }

    public function deletePictFile()
    {
        if ($this->pict) {
            Storage::disk('public')->delete($this->pict);
        }
    }
}
