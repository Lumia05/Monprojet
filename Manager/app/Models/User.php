<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'adresse',
        'telephone',
        'poste',
        'sexe',
        'profil',
        'date_de_naissance',
        'employee_code'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->role === 'super_admin';
        }
        if ($panel->getId() === 'employee') {
            return $this->role === 'employee';
        }
        return false;
    }

    public function presences()
    {
        return $this->hasMany(Presence::class);
    }

    public function conges()
    {
        return $this->hasMany(Conge::class);
    }
    public function approvedConge()
    {
        return $this->hasMany(User::class , 'approved_by');
    }

    public function approvedHeureSup()
    {
        return $this->hasMany(User::class , 'approved_by');
    }
}
