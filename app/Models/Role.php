<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name', 'slug', 'permissions'];
    protected $casts = ['permissions' => 'array'];
    use HasFactory;
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'roleId', 'userId');
    }
    public function hasAccess(array $permissions):bool{
        foreach($permissions as $permission){
            if($this->hasPermission($permission)){
                return true;    
            }
        }
        return false;
    }
    public function hasPermission($permission):bool
    {
        return $this->permissions[$permission]??false;
    }

}
