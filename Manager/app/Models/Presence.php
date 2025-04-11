<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Presence extends Model
{

    use softDeletes;


    protected $fillable = [
        'user_id',
        'date',
        'heure_entr',
        'heure_srt',
        'status',
        'qr_token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class) ;
    }
}
