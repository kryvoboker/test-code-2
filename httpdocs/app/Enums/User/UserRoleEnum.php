<?php

declare(strict_types = 1);

namespace App\Enums\User;

enum UserRoleEnum : string
{
    case Admin      = 'admin';
    case User       = 'user';
    case Blocked    = 'blocked';
}
