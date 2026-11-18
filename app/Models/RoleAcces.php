<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoleAcces extends Model
{
    protected $table = 'role_acces';

    protected $fillable = [
        'role_id',
        'acces',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
