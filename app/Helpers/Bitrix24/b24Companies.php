<?php

namespace App\Helpers\Bitrix24;


use GuzzleHttp\Client;
//use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use stdClass;

class b24Companies
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = new Client([
            'base_uri' => 'https://geleon.bitrix24.ua/rest/1/jvj8rqmvyz6emv0k/',

        ]);
    }

    public function getCompanies()
    {


      
    //    dd($result);
    //    $response2 = $this->client->get('crm.company.userfield.list', ['filter' => ['FIELD_NAME' => '435',] ]); fetch user fields
      //  $result2 = json_decode($response2->getBody());

      
          
       
        $companies = new stdClass;

       
        $response = $this->client->post('crm.company.list', [
            'form_params' => [
                'select' => [
                    'ID',
                    'TITLE',
                    'UF_CRM_1540465145514', // замените на идентификатор своего пользовательского поля
                    'UF_CRM_1540121191354', // замените на идентификатор своего пользовательского поля
                    'UF_CRM_5DBAA9FFCC357', // замените на идентификатор своего пользовательского поля
                    'UF_CRM_1597826997473', // замените на идентификатор своего пользовательского поля
                    'UF_CRM_1540465145514', // замените на идентификатор своего пользовательского поля
                ],
            ],
        ]);
        $result = json_decode($response->getBody());

        $companies->items = $result->result;

        while (property_exists($result, 'next') && !empty($result->next)) {
            //if ($result->next > 300) {             break;            }
            $response = $this->client->get('https://geleon.bitrix24.ua/rest/1/jvj8rqmvyz6emv0k/crm.company.list?start=' . $result->next . '&limit=50');
            $result = json_decode($response->getBody());

            $companies->items = array_merge($companies->items, $result->result);
        }
        //dd( $companies->items[3343]);
        return $companies;
    }



    public function getCompaniesOnly()
    {

        $companies = new stdClass;

        $response = $this->client->get('https://geleon.bitrix24.ua/rest/1/jvj8rqmvyz6emv0k/crm.company.list?limit=50');
        $result = json_decode($response->getBody());

        $companies->items = $result->result;

        while (property_exists($result, 'next') && !empty($result->next)) {
            //if ($result->next > 300) {             break;            }
            $response = $this->client->get('https://geleon.bitrix24.ua/rest/1/jvj8rqmvyz6emv0k/crm.company.list?start=' . $result->next . '&limit=50');
            $result = json_decode($response->getBody());

            $companies->items = array_merge($companies->items, $result->result);
        }
        //dd( $companies->items[3343]);
        return $companies;
    }
}
