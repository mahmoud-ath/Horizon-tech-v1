<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscriptions';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'theme_id',
        'subscribed_at',
    ];

    /**
     * Get the user that owns the subscription.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the theme that the subscription belongs to.
     */
    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }
}
