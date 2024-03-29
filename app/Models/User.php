<?php

namespace App\Models;

use App\Support\Avatar;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function attachments()
    {
        return $this->morphToMany(Attachment::class, 'attachmentable', 'attachmentable');
    }

    /**
     * Interact with the user's avatar.
     *
     * @return  \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => new Avatar(
                $attributes['email'],
                $this
            ),
        );
    }
}
