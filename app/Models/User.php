<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // Déclaration des rôles
    const USER_ROLE = 'user';
    const ADMIN_ROLE = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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

    /**
     * Vérifier si l'utilisateur est un administrateur
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ADMIN_ROLE;
    }

    /**
     * Vérifier si l'utilisateur est un utilisateur standard
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->role === self::USER_ROLE;
    }
}
