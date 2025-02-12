<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use LaravelAndVueJS\Traits\LaravelPermissionToVueJS;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\ExposePermissions;
class User extends Authenticatable
{
    use LaravelPermissionToVueJS;
    use HasFactory, Notifiable, HasRoles, ExposePermissions ;
  // En el modelo User (app/Models/User.php)
// app/Models/User.php

// app/Models/User.php
public function permissions()
{
    return $this->belongsToMany(Permission::class, 'user_permissions', 'user_id', 'permission_id');
}

public function roles()
{
    return $this->belongsToMany(Role::class, 'role_user');  // Asegúrate de que la tabla intermedia sea la correcta
}



   // public function hasRole($role)
    //{
     //   return $this->roles->contains('name', $role);
   // }



    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
    public function producto()
{
    return $this->belongsTo(Producto::class);
}

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'cedula',
        'celular',
        'direccion',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $appends = ['all_permissions', 'can'];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


}
