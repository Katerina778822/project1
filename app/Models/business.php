<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
   
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'type',
    ];

/*    public function users()
    {
        return $this->hasOne(B24User::class);
    }*/
}
