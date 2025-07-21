<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class Entrepreneur extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom_entreprise',
        'email',
        'mot_de_passe',
        'role',
        'statut',
        'raison_rejet',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'mot_de_passe',
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
        ];
    }

    public function setMotDePasseAttribute($value)
    {
        $this->attributes['mot_de_passe'] = \Illuminate\Support\Facades\Hash::needsRehash($value) ? \Illuminate\Support\Facades\Hash::make($value) : $value;
    }

    /**
     * Check if entrepreneur is approved
     */
    public function isApproved(): bool
    {
        return $this->statut === 'Approuvé' && $this->role === 'entrepreneur_approuve';
    }

    /**
     * Check if entrepreneur is waiting for approval
     */
    public function isWaitingApproval(): bool
    {
        return $this->statut === 'En attente';
    }

    /**
     * Check if entrepreneur is rejected
     */
    public function isRejected(): bool
    {
        return $this->statut === 'Rejeté';
    }
}
