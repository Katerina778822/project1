<?php

declare(strict_types=1);

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


class bitrix24Controller extends Controller
{

    protected $bitrix24;

    public function __construct(b24Companies $bitrix24)
    {
      
        $this->bitrix24 = $bitrix24;
    }



    function index()
    {
        $companies = $this->bitrix24->getCompanies();

        $perPage = 100;
        $currentPage = request()->query('page', 1);
        
        // Перетворення списку компаній на масив
        $companiesArray = (array) $companies->items;
        
        // Розрахунок індексу першого елементу на поточній сторінці
        $firstItemIndex = ($currentPage - 1) * $perPage;
        
        // Отримання елементів поточної сторінки
        $currentPageItems = array_slice($companiesArray, $firstItemIndex, $perPage);
        
        // Перетворення масиву елементів поточної сторінки назад в об'єкт stdClass
        $currentPageItems = (object) $currentPageItems;
        
        // Створення об'єкту LengthAwarePaginator з отриманими даними
        $paginatedData = new LengthAwarePaginator(
            $currentPageItems,
            count($companies->items),
            $perPage,
            $currentPage
        );
       // $currentPageItems = array_slice($allCompanies, ($currentPage - 1) * $perPage, $perPage);
       // $paginatedData = new LengthAwarePaginator($currentPageItems, count($allCompanies), $perPage);
    
      //  $companiesOnPage = collect($paginatedData->items());
      //  dd($companies);
       
        return view('bitrix24.index', ['companies'=>  $paginatedData]);

       
    }


    function getToken(Request $request)
    {
        print_r($_REQUEST);
        $this->writeToLog($_REQUEST, 'incoming');

        /**
         * Write data to log file.
         *
         * @param mixed $data
         * @param string $title
         *
         * @return bool
         */

        //https://helper.geleon.ua/bitrix2
        //wwyj28i9y3brhzis17g8gzoyyxkpjlbc


        /* dd('Here');
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler('b24-api-client-debug.log', Logger::DEBUG));

        $client = HttpClient::create(['http_version' => '2.0']);
        $traceableClient = new \Symfony\Component\HttpClient\TraceableHttpClient($client);
        $traceableClient->setLogger($log);

        $appProfile = new ApplicationProfile (
            'client id from application settings',
            'client secret from application settings',
            new \Bitrix24\SDK\Core\Credentials\Scope(
                [
                    'crm',
                ]
            )
        );
        $token = new \Bitrix24\SDK\Core\Credentials\AccessToken(
            '50cc9d5… access token',
            '404bc55… refresh token',
            1604179882
        );
        $domain = 'https:// client portal address  .bitrix24.ru';
        $credentials = \Bitrix24\SDK\Core\Credentials\Credentials::createForOAuth($token, $appProfile, $domain);

        $apiClient = new \Bitrix24\SDK\Core\ApiClient($credentials, $traceableClient, $log);
        $app = new Main ($apiClient, $log);

        $log->debug('================================');
        $res = $app->call('app.info');
        var_dump($res->getResponseData()->getResult()->getResultData());*/
    }
    function writeToLog($data, $title = '')
    {
        $log = "\n------------------------\n";
        $log .= date("Y.m.d G:i:s") . "\n";
        $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
        $log .= print_r($data, true);
        $log .= "\n------------------------\n";
        file_put_contents(getcwd() . '/hook.log', $log, FILE_APPEND);
        return true;
    }
}
