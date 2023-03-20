<?php

namespace App\Helpers;

use App\Models\Nodes;

class CorrectUrl
{

    static public function Handle(string $url, int $id_node): string
    {
        $node = Nodes::find($id_node);
        if (str_contains($url, ' ') )
        {
            $url = str_replace(' ', '%20', $url);
        }
            
        
        if (str_contains($url, 'http') || str_contains($url, 'www') || str_contains($url, $node->url))
            return $url;
        else {
            if(substr($node->url, -1)=="/"&&substr($url,0=="/")){
                $url=ltrim($url,"/");
            }
            $url = $node->url . $url;
            
            return $url;
        }
    }

    static public function FitStr(string $str, int $len): string
    {
        
        return $str;
    }
}


