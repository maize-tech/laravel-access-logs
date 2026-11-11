<?php

namespace Maize\AccessLogs\Tests\Support\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Guest extends Authenticatable
{
    protected $table = 'users';
}
