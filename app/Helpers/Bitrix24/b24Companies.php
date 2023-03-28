<?php

namespace App\Helpers\Bitrix24;


use GuzzleHttp\Client;
use Illuminate\Support\Env;
//use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use stdClass;

class b24Companies
{
    protected $client;

    public function __construct($base_uri = null)
    {
        $base_uri = $base_uri ?? env('B24_APIold');
        $this->client = new Client([
            'base_uri' => $base_uri,

        ]);
    }




    public function getCompanies()
    {
        $companies = [];
        $result = new stdClass;
        $result->next = -1;

        //   $companies = $result->result;

        while (property_exists($result, 'next') && !empty($result->next)) {
            if ($result->next == -1) {
                $result->next = 0;
            }
            //     if ($result->next > 200) {             break;            }
            $response = $this->client->post(
                'crm.company.list' . '?start=' . $result->next . '&limit=50',
                [
                    'form_params' => [
                        'select' => [
                            'ID',
                            'TITLE',
                            'UF_CRM_1540465145514', // замените на идентификатор своего пользовательского поля
                            'UF_CRM_1540121191354', // замените на идентификатор своего пользовательского поля
                            'UF_CRM_5DBAA9FFCC357', // замените на идентификатор своего пользовательского поля
                            'UF_CRM_1597826997473', // замените на идентификатор своего пользовательского поля
                            'ASSIGNED_BY_ID',
                            'LAST_ACTIVITY_BY',
                            'COMPANY_TYPE',
                            'DATE_CREATE',
                            'DATE_MODIFY',
                            'LAST_ACTIVITY_TIME',
                        ],
                    ],
                ]
            );
            $result = json_decode($response->getBody());

            $companies = array_merge($companies, $result->result);
        }
        //dd( $companies->items[3343]);
        return $companies;
    }


    public function getFields()
    {
        $items = [];
        $result = new stdClass;
        $result->next = -1;

        //   $companies = $result->result;

        while (property_exists($result, 'next') && !empty($result->next)) {
            if ($result->next == -1) {
                $result->next = 0;
            }
            //     if ($result->next > 200) {             break;            }
            $response = $this->client->post(
                'crm.company.userfield.list' . '?start=' . $result->next,
                /*       [
                    'form_params' => [
                        'select' => [
                            'ID',
                            'TITLE',
                            'UF_CRM_1540465145514', // замените на идентификатор своего пользовательского поля
                            'UF_CRM_1540121191354', // замените на идентификатор своего пользовательского поля
                            'UF_CRM_5DBAA9FFCC357', // замените на идентификатор своего пользовательского поля
                            'UF_CRM_1597826997473', // замените на идентификатор своего пользовательского поля
                            'ASSIGNED_BY_ID',
                            'LAST_ACTIVITY_BY',
                            'COMPANY_TYPE',
                            'DATE_CREATE',
                            'DATE_MODIFY',
                            'LAST_ACTIVITY_TIME',
                        ],
                    ],
                ]*/
            );
            $result = json_decode($response->getBody());

            $items = array_merge($items, $result->result);
        }
        //dd( $companies->items[3343]);
        return $items;
    }

    public function getUser()
    {
        $items = [];
        $result = new stdClass;
        $result->next = -1;

        //   $companies = $result->result;

        while (property_exists($result, 'next') && !empty($result->next)) {
            if ($result->next == -1) {
                $result->next = 0;
            }
            $response = $this->client->post(
                'user.get' . '?start=' . $result->next,
                [
                    'form_params' => [
                        'select' => [
                            'ID',
                            'TITLE',
                            'UF_CRM_1540465145514', // замените на идентификатор своего пользовательского поля
                            'UF_CRM_1540121191354', // замените на идентификатор своего пользовательского поля
                            'UF_CRM_5DBAA9FFCC357', // замените на идентификатор своего пользовательского поля
                            'UF_CRM_1597826997473', // замените на идентификатор своего пользовательского поля

                            'ASSIGNED_BY_ID',
                            'LAST_ACTIVITY_BY',
                            'COMPANY_TYPE',
                            'DATE_CREATE',
                            'DATE_MODIFY',
                            'LAST_ACTIVITY_TIME',
                        ],
                    ],
                ]
            );
            $result = json_decode($response->getBody());
            if (!empty($result->result))
                $items = array_merge($items, $result->result);
        }
        //dd( $companies->items[3343]);
        return $items;
    }

    public function getDeals()
    {
        $items = [];
        $result = new stdClass;
        $result->next = -1;

        //   $companies = $result->result;

        while (property_exists($result, 'next') && !empty($result->next)) {
            if ($result->next == -1) {
                $result->next = 0;
            }
            //     if ($result->next > 200) {             break;            }
            $response = $this->client->post(
                'crm.deal.list' . '?start=' . $result->next,
                [
                    'form_params' => [
                        'filter' => [
                            '>DATE_CREATE' => '09.03.2023',
                        ],
                        'select' => [
                            'ID',
                            'TITLE',
                            'STAGE_ID',
                            'CURRENCY_ID',
                            'OPPORTUNITY',
                            'DATE_CREATE',
                            'CLOSEDATE',
                            'ASSIGNED_BY_ID',
                            'COMMENTS',
                            'COMPANY_ID',
                            'IS_RETURN_CUSTOMER',

                            'UF_CRM_1545747379148', // Результат работы со сделкой
                            'UF_CRM_5C20F23556A62', //  Канал продажи
                            'UF_CRM_5BB6246DC30D8', //  Boost. Угода Генерация Джерело Лида
                            'UF_CRM_1545811346080', //  Boost. Угода Генерация Бенефициар
                            'UF_CRM_1564411704463', //  Boost. Конвертация. Угода.  СОСТОЯНИЕ
                            'UF_CRM_5CAB07390C964', //  Взял ЗАКАЗ. Дата
                            'UF_CRM_1540120643248', //  Взял ПРОСЧЕТ.ДАТА
                            'UF_CRM_1545811274193', //  Взял ДЕНЬГИ. Дата
                            'UF_CRM_1547732437301', //  РЕЗУЛЬТАТ ДАТА 
                            'UF_CRM_5C224D08961A9', //  ЛПР

                            'CATEGORY_ID', //Напрямок
                            'STAGE_ID', //Стадія угоди

                        ],
                    ],
                ]
            );
            $result = json_decode($response->getBody());
            //       dd($result);
            $items = array_merge($items, $result->result);
        }
        //dd( $companies->items[3343]);
        return $items;
    }


    public function getDealsField()
    {
        $items = [];
        $result = new stdClass;
        $result->next = 1;

        //   $companies = $result->result;

        //     while (property_exists($result, 'next') && !empty($result->next)) {
        //     if ($result->next > 200) {             break;            }
        $response = $this->client->post(
            'crm.deal.fields' . '?start=' . $result->next,

        );
        $result = json_decode($response->getBody());
        dd($result);
        $items = array_merge($items, $result->result);
        //      }
        //dd( $companies->items[3343]);
        return $items;
    }
    public function getRings()
    {
        $items = [];
        $result = new stdClass;
        $result->next = -1;

        //   $companies = $result->result;

        while (property_exists($result, 'next') && !empty($result->next)) {
            if ($result->next == -1) {
                $result->next = 0;
            }
            //     if ($result->next > 200) {             break;            }
            $response = $this->client->post(
                'voximplant.statistic.get' . '?start=' . $result->next,
                [
                    'form_params' => [
                        'filter' => [
                            '>CALL_START_DATE' => '09.03.2023',

                            'ID',
                            'CALL_ID',
                            'PORTAL_USER_ID',
                            'PHONE_NUMBER',
                            'CALL_CATEGORY',
                            'CALL_DURATION',
                            'CALL_START_DATE',
                            'CRM_ENTITY_TYPE',
                            'CRM_ENTITY_ID',
                            'CRM_ACTIVITY_ID',
                            'CALL_TYPE',
                            'RECORD_FILE_ID',
                            'CALL_RECORD_URL',
                            'CALL_FAILED_REASON',

                        ],


                    ],

                ]
            );
            $result = json_decode($response->getBody());
            //          dd($result);
            $items = array_merge($items, $result->result);
        }
        //dd( $companies->items[3343]);
        return $items;
    }
}
