<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Permission;

class Role extends Model
{

    use HasFactory;
    /**
     * Relación muchos a muchos con usuarios.
     */
// Role.php
public function permissions()
{
    return $this->belongsToMany(Permission::class, 'role_has_permission', 'role_id', 'permission_id');
}

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }

    protected $fillable = [
        'name',
        'guard_name',

    ];
}
