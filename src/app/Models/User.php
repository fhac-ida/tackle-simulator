<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * This class represents a User model that interacts with the 'users' table in the database.
 */
class User extends Authenticatable
{
    use HasApiTokens; // Include the HasApiTokens traits
    use HasFactory; // Include the HasFactory traits
    use Notifiable; // Include the Notifiable traits

    /**
     * The attributes that are mass assignable.
     *
     * @var string[] $fillable
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'location',
        'about_me',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Define a relationship method
     * This method establishes that each User can have many Profiles.
     * The foreign key 'user_id' in the 'profiles' table maps to the primary key in the 'users' table.
     * User hasMany profiles
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profiles(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Profil::class);
    }

    /**
     * Define a relationship method
     * This method establishes that each User can have many Maps.
     * The foreign key 'user_id' in the 'maps' table maps to the primary key in the 'users' table.
     * User hasMany Maps
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function maps(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Map::class);
    }
}
