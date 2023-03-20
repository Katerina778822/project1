<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isNull;

class Nodes extends Model
{
    use HasFactory;
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';
    protected $table = 'nodes';
    protected $fillable = [
        'name', 'url', 'node_paginat_pattern'
    ];
    public function Selectors()
    {
        return $this->hasMany(Selectors::class, 'fid_id_node');
    }
    public function Catalogs()
    {
        return $this->hasMany(Catalogs::class, 'fid_id_node');
    }

    public function GetPaginat($index)
    {
        for ($i = 1; $i <= $index; $i++) {
            if (str_contains($this->node_paginat_pattern, $i))
                return str_replace($i, $index, $this->node_paginat_pattern);
        }
        return false;
    }
    public function GetXPaginat($index)
    {
        if (!empty($this->node_paginat_pattern)) {
            if (str_contains($this->node_paginat_pattern, 'x'))
                return str_replace('x', $index, $this->node_paginat_pattern);
        } else {
            return '';
        }

        return false;
    }
}

