<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeureSup extends Model
{
    /** @use HasFactory<\Database\Factories\HeureSupFactory> */
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'user_id',
        'approved_by',
        'heures',
        'reason',
        'approved_by',
        'date'
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
