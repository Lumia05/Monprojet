<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Conge extends Model
{
    use SoftDeletes ;

    protected $fillable = [
        'user_id',
        'date_debut',
        'date_fin',
        'type',
        'status',
        'motif',
        'approved_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class , 'approved_by');
    }
}
