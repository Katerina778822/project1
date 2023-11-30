<?php

namespace App\Http\Controllers;

use App\Helpers\Bitrix24\b24Companies;
use App\Jobs\b24CompanyFetch;
use App\Jobs\b24UpdateStatusCompanies;
use App\Models\B24Contact;
use App\Models\Company;
use DateTime;
use DateTimeZone;
use Exception;
use Hamcrest\Core\IsNull;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use stdClass;
use Symfony\Component\HttpFoundation\Session\Storage\Proxy\AbstractProxy;

class CompanyController extends AbstractB24Controller
{




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(array $companie)
    {

        $modelCompanie = null;
        $modelCompanie = Company::where('ID', $companie['ID'])->get();
        if (count($modelCompanie)) {
            return;
        }
        $modelCompanie = Company::create($companie);

        try {
        } catch (Exception $e) {
            $e->getMessage();
        } finally {
            return;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // код для обработки запроса

        $company = Company::find($id);
        $activeDeals = $company->getActiveDeals();
        foreach($activeDeals as $activeDeal){//поиск последней стадии
           $event = $activeDeal->events()->latest('updated_at')->first();
           if(!empty($event))
           $activeDeal->event = $event->typeEvent;

           $type = $activeDeal->getTypeDeal()->id;
           switch ($type){
               case (1): $type = 0;break;
               case (2): $type =  20;break;
               case (3): $type =  40;break;
               case (4): $type =  60;break;
           }
           $activeDeal->type = $type;

        }
      
        return view('bitrix24.company.show', [
            'company' => $company,
            'activeDeals' => $activeDeals,
        ]);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(array $item)
    {
        $b24Item = Company::find($item['ID']);

        if (Company::where('ID', $item['ID'])->exists()) {
            $b24Item->update($item);
        } else
            $this->store($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function fetchAll()
    {
        $job = new b24CompanyFetch();
        $this->dispatch($job);
    }

    public function fetchData()
    {

        //  $count = 0;
        $checkDate = null; //'2016-01-01T00:00:00+03:00';
        $b24countItems = $this->helperOriginAPI->getQuantity('company', $checkDate);
        //$b24count = B24Analitics::where('AIM', 2)->first();
        $b24count = Company::count();



        //$requestArray['filter'][ '>CREATED_DATE']=$checkDate;
        $requestArray['DATE'] = $checkDate;
        $requestArray['select'] = [
            'ID', 'TITLE', 'UF_CRM_1597826997473', 'ASSIGNED_BY_ID', 'COMPANY_TYPE', 'DATE_CREATE', 'DATE_MODIFY', 'LAST_ACTIVITY_TIME',
            'ASSIGNED_BY_ID', 'LAST_ACTIVITY_BY', 'UF_CRM_1540465145514', 'UF_CRM_1540121191354', 'UF_CRM_5DBAA9FFCC357'
        ];
        $requestArray['start'] = $b24count;

        //      $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
        $items = $this->helperOriginAPI->getItem('company', $requestArray);
        //dd($items);
        while (count($items) && $b24countItems > $b24count) {
            foreach ($items as $item) {

                $item['DATE_CREATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_CREATE'])->format('Y-m-d H:i:s');
                $item['DATE_MODIFY'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_MODIFY'])->format('Y-m-d H:i:s');
                $item['LAST_ACTIVITY_TIME'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['LAST_ACTIVITY_TIME'])->format('Y-m-d H:i:s');
                $this->update($item);
            }
            $b24count = Company::count(); //save result count
            //$b24count->save();
            // $count = 0;
            $requestArray['start'] = $b24count;
            $items = $this->helperOriginAPI->getItem('company', $requestArray);
            // $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
            $b24countItems = $this->helperOriginAPI->getQuantity('company', $checkDate);
        }

        return redirect()->back();
    }

    public function updateData($checkDate)
    {

        //  $count = 0;
        //$checkDate = null;//'2016-01-01T00:00:00+03:00';
        $b24countItems = $this->helperOriginAPI->getQuantityUpdate('company', $checkDate);
        //$b24count = B24Analitics::where('AIM', 2)->first();
        $count = 0;
        $requestArray['DATE'] = $checkDate;
        $requestArray['select'] = [
            'ID', 'TITLE', 'UF_CRM_1597826997473', 'ASSIGNED_BY_ID', 'COMPANY_TYPE', 'DATE_CREATE', 'DATE_MODIFY', 'LAST_ACTIVITY_TIME',
            'ASSIGNED_BY_ID', 'LAST_ACTIVITY_BY', 'UF_CRM_1540465145514', 'UF_CRM_1540121191354', 'UF_CRM_5DBAA9FFCC357'
        ];
        $requestArray['start'] = $count;

        //      $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
        $items = $this->helperOriginAPI->getItemUpdate('company', $requestArray);
        //dd($items);
        while (count($items) && $b24countItems > $count) {
            foreach ($items as $item) {

                $item['DATE_CREATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_CREATE'])->format('Y-m-d H:i:s');
                $item['DATE_MODIFY'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_MODIFY'])->format('Y-m-d H:i:s');
                $item['LAST_ACTIVITY_TIME'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['LAST_ACTIVITY_TIME'])->format('Y-m-d H:i:s');
                $existItem = Company::where('ID', $item['ID'])->exists();
                if ($existItem)
                    $this->update($item);
                else
                    $this->store($item);
                $count++;
            }
            //$b24count = Company::count(); //save result count
            //$b24count->save();
            // $count = 0;
            $requestArray['start'] = $count;
            $items = $this->helperOriginAPI->getItemUpdate('company', $requestArray);
            // $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
            $b24countItems = $this->helperOriginAPI->getQuantityUpdate('company', $checkDate);
        }
    }

    public function UpdateStatusCompaniesJob()
    {
        $job = new b24UpdateStatusCompanies();
        $this->dispatch($job);
    }

    public function UpdateStatusCompanies()
    {
        $timezone = new DateTimeZone('Europe/Kiev');
        $end = new DateTime('now', $timezone);
        $end->setTime(21, 0, 0);

        $companies = Company::getALLB24ValidCompanies();
        foreach ($companies as $company) {
            if ($company->UF_CRM_1540465145514 == 1587) //закрылся не работает пропустить
                continue;
            if ($company->ID==2833)
            $asd=2;

                $status = $company->getClientStatus($end);
            switch ($status) {
                case 1: {
                        $status = 1753;
                        break;
                    }
                case 2: {
                        $status = 1417;
                        break;
                    }
                case 3: {
                        $status = 1617;
                        break;
                    }
                case 4: {
                        $status = 349;
                        break;
                    }
            }
            if ($company->UF_CRM_1540465145514 == $status) //если не изменился статус
                continue;
            try {
                $res = $this->helperOriginAPI->companyUpdate($company->ID, $status);
            } catch (\Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface  $e) {
                $context = [
                    'error_message' => $e->getMessage(),
                    'stack_trace' => $e->getTraceAsString(),
                ];

                Log::error('An error occurred', $context,  "companyUpdate, id ", $company->ID);
                //  Log::error($e->getMessage() . " companyUpdate, id ", $company->id);
            }
        }
        Log::channel('single')->info('CompanyController-UpdateStatusCompanies() succeed.');
    }
}
