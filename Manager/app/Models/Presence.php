<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    protected $fillable =   [
        'user_id',
        'heure_entr',
        'heure_srt',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class) ;
    }
}
