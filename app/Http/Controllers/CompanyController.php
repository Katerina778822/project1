<?php

namespace App\Http\Controllers;

use App\Helpers\Bitrix24\b24Companies;
use App\Models\Company;
use DateTime;
use Exception;
use Hamcrest\Core\IsNull;
use Illuminate\Http\Request;
use stdClass;

class CompanyController extends Controller
{

    private b24Companies $helper;

    public function __construct()
    {
        $this->helper = new b24Companies();
    }

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
        
        $modelCompanie=null;
        $modelCompanie=Company::where('ID',$companie['ID'])->get();
        if(count($modelCompanie)){
            return;
            
        }
        $modelCompanie = Company::create($companie);

        try {
        } catch (Exception $e) {
            $e->getMessage();
        }
        finally{
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
    public function update(Request $request, $id)
    {
        //
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
        $companies = $this->helper->getCompanies();

        foreach ($companies as $companie) {

            $companie=get_object_vars($companie);
            $companie['DATE_CREATE'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $companie['DATE_CREATE']);
            $companie['DATE_MODIFY'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $companie['DATE_MODIFY']);
            $companie['LAST_ACTIVITY_TIME'] = DateTime::createFromFormat("Y-m-d\TH:i:sP",  $companie['LAST_ACTIVITY_TIME']);
            $this->store($companie);
        }
        return redirect()->back();
    }
    public function f2($id)
    {
        //
    }
}
