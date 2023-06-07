<?php

namespace App\Helpers\Bitrix24;
use Illuminate\Support\Collection;

class B24RaportCollection extends Collection
{
    public function __get($key)
    {
        return $this->items[$key] ?? null;
    }

    public function __set($key, $value)
    {
        $this->items[$key] = $value;
    }
}