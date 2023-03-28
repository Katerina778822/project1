<?php

namespace App\Helpers\Bitrix24;

use Bitrix24\Bitrix24;
use Bitrix24\Exceptions\Bitrix24Exception;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Env;
//use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use stdClass;
use Bitrix24\SDK\Core;
use Bitrix24\SDK\Core\ApiClient;
use Bitrix24\SDK\Core\Credentials\Credentials;
use Bitrix24\SDK\Core\Credentials\WebhookUrl;
use Bitrix24\SDK\Core\Credentials\AccessToken;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Core\Credentials\Scope;
use Psr\Log\NullLogger;
use Symfony\Component\HttpClient\HttpClient;

class b24OriginAPI
{
    protected $apiClient;

    public function __construct($base_uri = null)
    {
        $client = HttpClient::create();
        $url = 'https://geleon.bitrix24.ua/rest/1/' . env('B24_TOKEN'); // ваш URL
        $accessToken = env('B24_TOKEN'); // ваш access token
        $app_id = env('BITRIX24_APP_ID');
        $app_secret = env('BITRIX24_APP_SECRET');
        $webhookUrl = new WebhookUrl($url);
        $accessTokenObj = new AccessToken($accessToken, "", 0);
        $scope = new Scope(array('tasks'));
        $applicationProfile = new ApplicationProfile($app_id, $app_secret, $scope);
        $credentials = new Credentials($webhookUrl, $accessTokenObj, $applicationProfile, 'https://geleon.bitrix24.ua');
        $this->apiClient = new ApiClient($credentials, $client, new NullLogger());
    }


    public function getLeads()
    {
        $items = [];
        $result = [];
        $result['next'] = -1;

        while (!empty($result['next'])) {
            if ($result['next'] == -1) {
                $result['next'] = 0;
            }

            $response = $this->apiClient->getResponse('crm.lead.list', [
                'filter' => [
                    //      'RESPONSIBLE_ID' => 14,
                    //      'STATUS' => ['1', '2']
                    '>DATE_CREATE' => '2023-02-01T00:00:00+03:00',
                ],
                // 'select' => ['ID', 'DESCRIPTION', 'RESPONSIBLE_ID', 'TIME_ESTIMATE', 'TITLE', 'DEADLINE', 'DATE_START', 'STATUS', 'CREATED_DATE', 'guid', 'CREATEDDATE','CHANGED_DATE', 'CLOSED_DATE', 'UF_CRM_TASK'],
                'select' =>  ["*", "UF_*", 'PHONE',],

                'start' => $result['next'],
            ]);
            $responseContent = $response->getContent();
            $result = json_decode($responseContent, true);
            $items = array_merge($items, $result['result']);
        }
        //  dd($items);
        return  $items;
        // 
    }

    public function getTasks()
    {
        $items = [];
        $result = [];
        $result['next'] = -1;

        while (!empty($result['next'])) {
            if ($result['next'] == -1) {
                $result['next'] = 0;
            }
            $response = $this->apiClient->getResponse('tasks.task.list', [
                'filter' => [
                    //      'RESPONSIBLE_ID' => 14,
                    //      'STATUS' => ['1', '2']
                    '>CREATED_DATE' => '2023-03-26T00:00:00+03:00',
                ],
                'select' => ['ID', 'DESCRIPTION', 'RESPONSIBLE_ID', 'TIME_ESTIMATE', 'TITLE', 'DEADLINE', 'DATE_START', 'STATUS', 'CREATED_DATE', 'guid', 'CREATEDDATE', 'CHANGED_DATE', 'CLOSED_DATE', 'UF_CRM_TASK'],
                'start' => $result['next']
            ]);
            $responseContent = $response->getContent();
            $result = json_decode($responseContent, true);
            $items = array_merge($items, $result['result']['tasks']);
        }
        //   dd($items,"total ".$responseData['total']);
        return  $items;
        // 
    }

    public function getContacts()
    {
        $items = [];
        $result = [];
        $result['next'] = -1;

        while (!empty($result['next'])) {
            if ($result['next'] == -1) {
                $result['next'] = 0;
            }
            $response = $this->apiClient->getResponse('crm.contact.list', [
                'filter' => [
                    //      'RESPONSIBLE_ID' => 14,
                    //      'STATUS' => ['1', '2']
                    '>DATE_CREATE' => '2023-03-26T00:00:00+03:00',
                ],
                'select' =>  ["*", "UF_*", 'PHONE',],

                'next' => $result['next']
            ]);
            $responseContent = $response->getContent();
            $result = json_decode($responseContent, true);
            $items = array_merge($items, $result['result']);
        }
        //     dd($result['result']);
        return  $items;
        // 
    }
}
