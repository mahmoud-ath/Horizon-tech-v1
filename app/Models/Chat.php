<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'article_id',
        'content',
        'parent_id', // Added parent_id field
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
    public function replies()
    {
        return $this->hasMany(Chat::class, 'parent_id')->with('user'); // Load user with replies
    }

    public function parent()
    {
        return $this->belongsTo(Chat::class, 'parent_id')->with('user'); // Load user with parent
    }
}
