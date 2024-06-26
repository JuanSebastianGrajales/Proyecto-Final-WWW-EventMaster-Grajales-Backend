<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrations extends Model
{
    use HasFactory;

    protected $table = 'registrations';

    protected $fillable = [
        'user_id',
        'event_id',
        'registered_at'
    ];

    public function event()
    {
        return $this->belongsTo(Events::class, 'event_id');
    }
}
