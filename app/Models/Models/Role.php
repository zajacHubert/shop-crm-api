<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }
}
