<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'ID',
        'typeEvent',
        'deal_id',
        'branch_id',
    ];

    // Определение отношения с моделью Stage
    public function stage()
    {
        return $this->belongsToMany(Stage::class, 'typeEvent', 'ID');
    }

    // Определение отношения с моделью B24Deal
    public function b24Deal()
    {
        return $this->belongsTo(B24Deal::class, 'deal_id', 'ID');
    }

    // Определение отношения с моделью Branch
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }



}
