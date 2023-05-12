<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B24User extends Model
{
    use HasFactory;
    protected $table = 'b24_users';
    protected $fillable = [
        'ID', 'ACTIVE', 'LAST_NAME', 'NAME', 'VALUE',
    ];
    protected $primaryKey = 'ID';
}
