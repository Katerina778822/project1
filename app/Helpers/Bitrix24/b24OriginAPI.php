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

use function PHPUnit\Framework\returnSelf;

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


    public function getLeads($count)
    {
        $items = [];


        $response = $this->apiClient->getResponse('crm.lead.list', [
            'filter' => [
                //      'RESPONSIBLE_ID' => 14,
                //      'STATUS' => ['1', '2']
                //  '>DATE_CREATE' => '2023-02-01T00:00:00+03:00',
            ],
            // 'select' => ['ID', 'DESCRIPTION', 'RESPONSIBLE_ID', 'TIME_ESTIMATE', 'TITLE', 'DEADLINE', 'DATE_START', 'STATUS', 'CREATED_DATE', 'guid', 'CREATEDDATE','CHANGED_DATE', 'CLOSED_DATE', 'UF_CRM_TASK'],
            // 'select' =>  ["*", "UF_*", 'PHONE',],
            'select' => [
                'ID', 'TITLE', 'NAME', 'LAST_NAME', 'SOURCE_ID', 'STATUS_ID', 'COMMENTS', 'ADDRESS', 'UTM_SOURCE',
                'UTM_MEDIUM', 'UTM_CAMPAIGN', 'UTM_CONTENT', 'UTM_TERM', 'CURRENCY_ID', 'PHONE', 'OPPORTUNITY', 'COMPANY_ID',
                'CONTACT_ID', 'ASSIGNED_BY_ID', 'CREATED_BY_ID', 'DATE_CREATE', 'DATE_CLOSED', 'DATE_MODIFY',
            ],
            'start' => $count,
        ]);
        $responseContent = $response->getContent();
        $result = json_decode($responseContent, true);
        $items = array_merge($items, $result['result']);

        //  dd($items);
        return  $items;
        // 
    }

    public function getTasks($count)
    {
        $items = [];
        $response = $this->apiClient->getResponse('tasks.task.list', [
            'filter' => [
                //      'RESPONSIBLE_ID' => 14,
                //      'STATUS' => ['1', '2']
                '>CREATED_DATE' => '2022-01-01T00:00:00+03:00',
            ],
            'select' => ['ID', 'DESCRIPTION', 'RESPONSIBLE_ID', 'TIME_ESTIMATE', 'TITLE', 'DEADLINE', 'DATE_START', 'STATUS', 'CREATED_DATE', 'guid', 'CREATEDDATE', 'CHANGED_DATE', 'CLOSED_DATE', 'UF_CRM_TASK'],
            'start' => $count,
        ]);
        $responseContent = $response->getContent();
        $result = json_decode($responseContent, true);
        $items = array_merge($items, $result['result']['tasks']);

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
                    '>DATE_CREATE' => '2016-01-01T00:00:00+03:00',
                    //  '<DATE_CREATE' => '2022-01-01T00:00:00+03:00',
                ],
                'select' =>  ["*", "UF_*", 'PHONE',],

                'start' => $result['next']
            ]);
            $responseContent = $response->getContent();
            $result = json_decode($responseContent, true);
            $items = array_merge($items, $result['result']);
        }
        //     dd($result['result']);
        return  $items;
        // 
    }

    public function getQuantity($itemType,  $date = null, $apiUrl = null,)
    {
        $items = [];
        $apiUrl = $this->getApiUrl($itemType);
        $dateCreate = $this->getDateString($itemType);

        if ($apiUrl) {
            $response = $this->apiClient->getResponse($apiUrl, [
                'filter' => [
                    '>'.$dateCreate => $date,
                ]
            ],);
            $responseContent = $response->getContent();
            $result = json_decode($responseContent, true);
            if (!empty($result['total']))
                return $result['total'];
        }


        return  0;
        // 
    }

    public function getItem($itemType, $requestArray, $apiUrl = null)
    {

        //$requestArray['filter']['start']=  intdiv( $requestArray['filter']['start'], 50)*50;//целочисленное деление на 50 и умножение для нарезки блоков items строго по 50 в запросе.
        $requestArray['filter'][ '>'.$this->getDateString($itemType)]=$requestArray["DATE"];
        $response = $this->apiClient->getResponse($this->getApiUrl($itemType), $requestArray);
        $responseContent = $response->getContent();
        $result = json_decode($responseContent, true);
        //     dd($result['result']);
        if (!empty($result['result']['tasks']))
            return $result['result']['tasks'];
        return  $result['result'];
        // 
    }

    private function getApiUrl($itemType)
    {
        switch ($itemType) {
            case 'task': {
                    return 'tasks.task.list';
                    break;
                }
            case 'ring': {
                    return 'voximplant.statistic.get';
                    break;
                }
            case 'contact': {
                    return 'crm.contact.list';
                    break;
                }
            case 'company': {
                    return '';
                    break;
                }
            case 'field': {
                    return '';
                    break;
                }
            case 'user': {
                    return '';
                    break;
                }
            case 'deal': {
                    return '';
                    break;
                }
            case 'lead': {
                    return '';
                    break;
                }
            default:
                return false;
        }
    }
    private function getDateString($itemType)
    {
        switch ($itemType) {
            case 'task': {
                    return 'CREATED_DATE';
                    break;
                }
            case 'ring': {
                    return '';
                    break;
                }
            case 'contact': {
                    return 'DATE_CREATE';
                    break;
                }
            case 'company': {
                    return '';
                    break;
                }
            case 'field': {
                    return '';
                    break;
                }
            case 'user': {
                    return '';
                    break;
                }
            case 'deal': {
                    return '';
                    break;
                }
            case 'lead': {
                    return '';
                    break;
                }
            default:
                return false;
        }
    }
}
