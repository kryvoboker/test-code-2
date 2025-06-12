<?php

declare(strict_types = 1);

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserToTelegram extends Model
{
    protected $fillable = [
        'user_id',
        'chat_id',
        'username',
        'nickname',
    ];
}
