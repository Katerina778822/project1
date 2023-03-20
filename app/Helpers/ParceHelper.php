<?php

namespace App\Helpers;

use DiDom\Document;


class ParceHelper
{

    static public function findCssOrXpath(Document $document, string $selector){
        if(substr($selector,0,1)=='/')
            {
                return $document->xpath($selector);
            }
            else{
                return $document->find($selector);
            }

    }

}
