<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B24test extends Model
{
    use HasFactory;
    protected $table = 'b24tests';
    protected $fillable = [
        'STR',
    ];
}
