<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B24User extends Model
{
    use HasFactory;
    protected $table = 'b24_users';
    protected $fillable = [
        'ID', 'ACTIVE', 'LAST_NAME', 'NAME', 'VALUE', 'user_id',
    ];
    protected $primaryKey = 'ID';

   // public function business()
   // {
    //    return $this->belongsTo(User::class, 'business_id', 'ID');
   // }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function user()
    {
        return $this->hasOne(User::class, 'crmuser_id');
    }


}
