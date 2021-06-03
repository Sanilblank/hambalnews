<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = "roles";

    protected $fillable = [
        'name',
        'slug',
    ];

    public function permissions()
    {

        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_id', 'id');
    }

    public function roles_permissions()
    {
        return $this->hasMany(RolesPermission::class, 'role_id');
    }
}
