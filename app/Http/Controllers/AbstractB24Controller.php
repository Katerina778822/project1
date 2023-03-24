<?php

namespace App\Http\Controllers;

use App\Helpers\Bitrix24\b24Companies;
use Illuminate\Http\Request;

    abstract class AbstractB24Controller extends Controller
    {
        abstract public function fetchAll();
        
        protected b24Companies $helper;

        public function __construct()
        {
            $this->helper = new b24Companies();
        }
        //
    }
