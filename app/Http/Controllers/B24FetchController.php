<?php



namespace App\Http\Controllers;

use App\Helpers\Bitrix24\b24Companies;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Services\Main\Service\Main;
use Illuminate\Pagination\LengthAwarePaginator;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\HttpClient\HttpClient;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;


class B24FetchController extends AbstractB24Controller
{





    function fetchState()
    {
        $b24countItems = $this->helperOriginAPI->getQuantity('user', $checkDate);
        //$b24count = B24Analitics::where('AIM', 2)->first();
        $b24count = B24User::count();


        return view('bitrix24.b24dashboardFirst', [
            'goods' => 1,
            'id_node' => 2,
        ]);
       
    }

    public function fetchAll(){
        
    }
    
}
