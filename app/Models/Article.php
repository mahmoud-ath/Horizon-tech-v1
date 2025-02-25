<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'theme_id',
        'published_date',
        'status',
        'issue_id',
        'content',
        'imagepath',
        'recommended',
        'user_id',
    ];

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function issue()
    {
    return $this->belongsTo(Issues::class, 'issue_id');
    }
    public function chats()
    {
        return $this->hasMany(Chat::class);
    }


}

