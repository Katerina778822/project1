<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
protected $table='users';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
<<<<<<< HEAD
        'password', 'business_id'
=======
        'password',
        'business_id',
>>>>>>> d1fdc4397ffee0fff5e35d23acafed5b5b22ba51
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function roles(){
        return $this->belongsToMany(Role::class,'role_user','userId','roleId');
    }
    public function hasAccess(array $permissions):bool{
        foreach($this->roles as $role)
            if ($role->hasAccess($permissions))
                return true;
        return false;
    }

    public function hasRole($roleSlug):bool{
        return $this->roles()->where('slug',$roleSlug)->count()==1;

    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'business_id', 'id');
    }

    public function b24user()
    {
        return $this->hasOne(B24User::class);
    }


}
