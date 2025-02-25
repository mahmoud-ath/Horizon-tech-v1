<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    // Specify the table name if it differs from the default 'histories'
    protected $table = 'history';

    // Specify the attributes that are mass assignable.
    protected $fillable = [
        'user_id',
        'article_id',
        'accessed_at',
    ];

    // The attributes that should be cast to native types.
    protected $casts = [
        'accessed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
