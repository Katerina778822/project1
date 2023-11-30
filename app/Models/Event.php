<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'typeEvent',
        'deal_id',

    ];

    // Определение отношения с моделью Stage
    public function stage()
    {
        return $this->hasOne(Stage::class, 'stage');
    }

    // Определение отношения с моделью B24Deal
    public function b24Deal()
    {
        return $this->belongsTo(B24Deal::class, 'deal_id', 'ID');
    }





}
