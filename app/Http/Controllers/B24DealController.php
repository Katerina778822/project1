<?php

namespace App\Http\Controllers;

use App\Jobs\b24DealFetch;
use App\Models\B24Analitics;
use App\Models\B24Deal;
use App\Models\Company;
use App\View\Components\Alert;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class B24DealController extends AbstractB24Controller
{

    private $validateArray = [
        'ID' => 'required|integer|unique:App\Models\B24User,ID',
        'NAME' => 'required|string|max:25',
        'LAST_NAME' => 'required|string|max:25',
        'ACTIVE' => 'required|integer|min:0|max:1',
    ];
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
    public function store(Request $request)
    {
        if (!empty($request)) {
   
            $validator = $request->validate($this->validateArray);


            $user = B24Deal::create($request->all());

            return redirect()->back()->with('status', 'User added!');
        }
    }

    public function updateItem(array $item)
    {
        $b24Item = B24Deal::find($item['ID']);
        try {
            if (!empty($b24Item)) {
                $b24Item->update($item);
            } else
                B24Deal::create($item);
        } catch (Exception $e) {
            Log::error('Couldnt create/update deal: ID' .$item['ID'].'\ '.$e->getMessage());
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
        //
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

        $job = new b24DealFetch();
        $this->dispatch($job);
    }

    public function fetchData()
    {

        //  $count = 0;
        $checkDate = null; //'2023-03-01T00:00:00+03:00';
        $b24countItems = $this->helperOriginAPI->getQuantity('deal', $checkDate);
        //$b24count = B24Analitics::where('AIM', 2)->first();
        $b24count = B24Deal::count();



        //$requestArray['filter'][ '>CREATED_DATE']=$checkDate;
        $requestArray['DATE'] = $checkDate;
        $requestArray['select'] = [
            'ID', 'ASSIGNED_BY_ID', 'COMPANY_ID', 'TITLE', 'STAGE_ID', 'CURRENCY_ID', 'CATEGORY_ID', 'CLOSED',
            'OPPORTUNITY', 'COMMENTS', 'IS_RETURN_CUSTOMER', 'UF_CRM_1545747379148', 'UF_CRM_5C20F23556A62',
            'UF_CRM_5BB6246DC30D8', 'UF_CRM_1545811346080', 'UF_CRM_1564411704463', 'UF_CRM_5CAB07390C964', 'UF_CRM_1540120643248',
            'UF_CRM_1545811274193', 'UF_CRM_1547732437301', 'DATE_CREATE', 'CLOSEDATE', 'UF_CRM_5C224D08961A9',
        ];
        $requestArray['start'] = $b24count;

        //      $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
        $items = $this->helperOriginAPI->getItem('deal', $requestArray);
        //dd($items);
        while (count($items) && $b24countItems > $b24count) {
            foreach ($items as $item) {
                //      dd($item);
                //               $item = get_object_vars($item);
                $item['DATE_CREATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_CREATE'])->format('Y-m-d H:i:s');
                if (!empty($item['UF_CRM_5CAB07390C964']))
                    $item['UF_CRM_5CAB07390C964'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['UF_CRM_5CAB07390C964'])->format('Y-m-d H:i:s');
                else $item['UF_CRM_5CAB07390C964'] = NULL;
                if (!empty($item['UF_CRM_1540120643248']))
                    $item['UF_CRM_1540120643248'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['UF_CRM_1540120643248'])->format('Y-m-d H:i:s');
                else $item['UF_CRM_1540120643248'] = NULL;
                if (!empty($item['UF_CRM_1545811274193']))
                    $item['UF_CRM_1545811274193'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['UF_CRM_1545811274193'])->format('Y-m-d H:i:s');
                else $item['UF_CRM_1545811274193'] = NULL;
                if (!empty($item['UF_CRM_1547732437301']))
                    $item['UF_CRM_1547732437301'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['UF_CRM_1547732437301'])->format('Y-m-d H:i:s');
                else $item['UF_CRM_1547732437301'] = NULL;
                if (!empty($item['CLOSEDATE']))
                    $item['CLOSEDATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['CLOSEDATE'])->format('Y-m-d H:i:s');
                else $item['CLOSEDATE'] = NULL;
                if (!empty($item['DATE_MODIFY']))
                    $item['DATE_MODIFY'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_MODIFY'])->format('Y-m-d H:i:s');
                else $item['DATE_MODIFY'] = NULL;


                if (empty($item['COMPANY_ID'])) {
                    $item['COMPANY_ID'] = 7549;
                    //                        $error = B24Analitics::create([
                    //                        'AIM' => 4555,
                    //                        'id_item' => $item['id_item'],
                    //                        'string1' => $item['TITLE'],
                    //                        'string' => "Deal without company",
                    //                    ]);
                }

                $this->updateItem($item);
            }
            $b24count = B24Deal::count(); //save result count
            //$b24count->save();
            // $count = 0;
            $requestArray['start'] = $b24count;
            $items = $this->helperOriginAPI->getItem('deal', $requestArray);
            // $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
            $b24countItems = $this->helperOriginAPI->getQuantity('deal', $checkDate);
        }
    }
    public function updateData($checkDate)
    {

        //  $count = 0;
        //$checkDate = null; //'2023-03-01T00:00:00+03:00';
        $b24countItems = $this->helperOriginAPI->getQuantityUpdate('deal', $checkDate);
        //$b24count = B24Analitics::where('AIM', 2)->first();
        $count = 0;



        //$requestArray['filter'][ '>CREATED_DATE']=$checkDate;
        $requestArray['DATE'] = $checkDate;
        $requestArray['select'] = [
            'ID', 'ASSIGNED_BY_ID', 'COMPANY_ID', 'TITLE', 'STAGE_ID', 'CURRENCY_ID', 'CATEGORY_ID', 'CLOSED',
            'OPPORTUNITY', 'COMMENTS', 'IS_RETURN_CUSTOMER', 'UF_CRM_1545747379148', 'UF_CRM_5C20F23556A62',
            'UF_CRM_5BB6246DC30D8', 'UF_CRM_1545811346080', 'UF_CRM_1564411704463', 'UF_CRM_5CAB07390C964', 'UF_CRM_1540120643248',
            'UF_CRM_1545811274193', 'UF_CRM_1547732437301', 'DATE_CREATE', 'CLOSEDATE', 'UF_CRM_5C224D08961A9', 'DATE_MODIFY'
        ];
        $requestArray['start'] = $count;

        //      $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
        $items = $this->helperOriginAPI->getItemUpdate('deal', $requestArray);
        //dd($items);
        while (count($items) && $b24countItems > $count) {
            foreach ($items as $item) {
                //      dd($item);
                //               $item = get_object_vars($item);
                $item['DATE_CREATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_CREATE'])->format('Y-m-d H:i:s');
                if (!empty($item['UF_CRM_5CAB07390C964']))
                    $item['UF_CRM_5CAB07390C964'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['UF_CRM_5CAB07390C964'])->format('Y-m-d H:i:s');
                else $item['UF_CRM_5CAB07390C964'] = NULL;
                if (!empty($item['UF_CRM_1540120643248']))
                    $item['UF_CRM_1540120643248'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['UF_CRM_1540120643248'])->format('Y-m-d H:i:s');
                else $item['UF_CRM_1540120643248'] = NULL;
                if (!empty($item['UF_CRM_1545811274193']))
                    $item['UF_CRM_1545811274193'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['UF_CRM_1545811274193'])->format('Y-m-d H:i:s');
                else $item['UF_CRM_1545811274193'] = NULL;
                if (!empty($item['UF_CRM_1547732437301']))
                    $item['UF_CRM_1547732437301'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['UF_CRM_1547732437301'])->format('Y-m-d H:i:s');
                else $item['UF_CRM_1547732437301'] = NULL;
                if (!empty($item['CLOSEDATE']))
                    $item['CLOSEDATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['CLOSEDATE'])->format('Y-m-d H:i:s');
                else $item['CLOSEDATE'] = NULL;
                if (!empty($item['DATE_MODIFY']))
                    $item['DATE_MODIFY'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $item['DATE_MODIFY'])->format('Y-m-d H:i:s');
                else $item['DATE_MODIFY'] = NULL;

                if (empty($item['COMPANY_ID'])) {
                    $item['COMPANY_ID'] = 7549;
                    $error = B24Analitics::create([
                        'AIM' => 4555,
                        'id_item' => $item['ID'],
                        'string1' => $item['TITLE'],
                        'string2' => "Deal without company",
                    ]);
                }

                $this->updateItem($item);
                $count++;
            }
            // $b24count = B24Deal::count(); //save result count
            //$b24count->save();

            $requestArray['start'] = $count;
            $items = $this->helperOriginAPI->getItemUpdate('deal', $requestArray);
            // $items = $this->helperOriginAPI->getTasks($b24count->big_int1);
            $b24countItems = $this->helperOriginAPI->getQuantityUpdate('deal', $checkDate);
        }
    }
}
