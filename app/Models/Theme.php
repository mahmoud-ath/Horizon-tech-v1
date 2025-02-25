<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'imagepath', 'user_id', 'status','updated_at','created_at'];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }

}
