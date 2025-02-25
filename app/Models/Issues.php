<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issues extends Model
{
    use HasFactory;

    protected $table = 'issues';

    protected $fillable = [
        'name',
        'imagepath',
        'publication_date',
        'status',
    ];

    protected $casts = [
        'publication_date' => 'date',
        'status' => 'string',
    ];

    public $timestamps = false;

    protected $attributes = [
        'status' => 'private',
    ];

    const CREATED_AT = 'created_at';
}
