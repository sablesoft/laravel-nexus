<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

/**
 * @property int|null $id
 * @property string|null $name
 * @property string|null $email
 * @property Carbon|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property-read Collection<int, Application>|Application[] $application
 * @property-read Collection<int, Screen>|Screen[] $screens
 * @property-read Collection<int, Scenario>|Scenario[] $scenarios
 * @property-read Collection<int, Chat>|Chat[] $chats
 * @property-read Collection<int, Mask>|Mask[] $masks
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function screens(): HasMany
    {
        return $this->hasMany(Screen::class);
    }

    public function scenarios(): HasMany
    {
        return $this->hasMany(Scenario::class);
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class);
    }

    public function masks(): HasMany
    {
        return $this->hasMany(Mask::class);
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }
}
