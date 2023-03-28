<?php

namespace App\Http\Controllers;

use App\Helpers\Bitrix24\b24Companies;
use App\Helpers\Bitrix24\b24OriginAPI;
use Illuminate\Http\Request;

    abstract class AbstractB24Controller extends Controller
    {
        abstract public function fetchAll();
        
        
        protected b24Companies $helper;
        protected b24OriginAPI $helperOriginAPI;

        public function __construct()
        {
            $this->helper = new b24Companies();
            $this->helperOriginAPI = new b24OriginAPI();
        }


        //
    }
