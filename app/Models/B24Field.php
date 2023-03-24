<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B24Field extends Model
{
    use HasFactory;
    protected $table = 'b24_fields';
    protected $fillable = [
        'ID', 'VALUE', 'ENTITY_ID', 'FIELD_NAME', 'FIELD_ID',
    ];
}
