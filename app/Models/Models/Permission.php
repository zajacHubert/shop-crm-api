<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission as SpatePermission;

class Permission extends SpatePermission
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
}
