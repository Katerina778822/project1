<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class business extends Model
{
    use HasFactory;

    protected $fillable = [
    'name',
    'Type',
];
    public function users()
    {
        return $this->hasOne(B24User::class);
    }



}
