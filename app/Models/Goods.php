<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    use HasFactory;
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    protected $table = 'goods';
    protected $fillable = [
        'art', 'url', 'fid_id_catalog','name',
        'descripttxt', 'descripthtml', 'fotos','videos','charact','complect','price','store',
        'f1','f2','f3','f4','f5'
    ];
}
