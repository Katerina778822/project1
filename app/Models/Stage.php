<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $table = 'stage';

    protected $fillable = [

        'ID',
        'stage',

    ];

    public function event()
    {
        return $this->hasMany(Event::class);
    }


}
