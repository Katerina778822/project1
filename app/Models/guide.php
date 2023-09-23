<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class guide extends Model
{
    use HasFactory;

    protected $fillable = [
        'text_message',
        'media_files',
    ];

    protected $casts = [
        'media_files' => 'array', // Для преобразования бинарных данных в массив
    ];

}
