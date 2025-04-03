<?php

namespace Maize\AccessLogs\Tests\Support\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Maize\AccessLogs\HasAccessLogs;
use Maize\AccessLogs\InteractWithAccessLogs;
use Maize\AccessLogs\Tests\Support\Factories\UserFactory;

class User extends Authenticatable implements HasAccessLogs
{
    use HasFactory;
    use InteractWithAccessLogs;

    protected $fillable = [];

    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }
}
