<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogs extends Model
{
    use HasFactory;
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    protected $table = 'catalogs';
    protected $fillable = [
        'url', 'value', 'branch_progress_good','fid_id_node'
    ];
 
public function Goods(){
   return $this->hasMany(Goods::class,'fid_id_catalog');
}

}
