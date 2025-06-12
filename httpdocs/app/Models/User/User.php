<?php

declare(strict_types = 1);

namespace App\Models\User;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\User\UserRoleEnum;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'role',
        'name',
        'lastname',
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

    protected $casts = [
        'role' => UserRoleEnum::class,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts() : array
    {
        return [
            'role'              => UserRoleEnum::class,
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * @return HasOne
     */
    public function userToTelegram() : HasOne
    {
        return $this->hasOne(UserToTelegram::class);
    }

    /**
     * @param int $telegram_id
     *
     * @return self|null
     */
    public function getUserByTelegramChatId(int $telegram_id) : ?self
    {
        return $this
            ->withWhereHas('userToTelegram', function ($query) use ($telegram_id) {
                $query->where('chat_id', $telegram_id);
            })
            ?->first();
    }
}
