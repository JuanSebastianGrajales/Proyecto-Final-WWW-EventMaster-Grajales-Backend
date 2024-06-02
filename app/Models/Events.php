<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'id',
        'title',
        'description',
        'event_date',
        'event_time',
        'location',
        'is_public',
        'category_id',
        'user_id'
    ];
}
