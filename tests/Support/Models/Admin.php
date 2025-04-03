<?php

namespace Maize\AccessLogs\Tests\Support\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Maize\AccessLogs\Concerns\HasAccessLogs;
use Maize\AccessLogs\Tests\Support\Factories\AdminFactory;

class Admin extends Authenticatable
{
    use HasAccessLogs;
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory(): Factory
    {
        return AdminFactory::new();
    }
}
