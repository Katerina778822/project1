<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $primaryKey = 'ID'; // Указываем имя первичного ключа

    protected $fillable = [
        'name_business',
    ];




}
