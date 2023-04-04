<?php



namespace App\Http\Controllers;

use App\Helpers\Bitrix24\b24Companies;
use App\Models\B24Contact;
use App\Models\B24Deal;
use App\Models\B24Lead;
use App\Models\B24Ring;
use App\Models\B24Task;
use App\Models\B24User;
use App\Models\Company;
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
        $countArray['usersDB']=B24User::count();
        $countArray['usersB24']=$this->helperOriginAPI->getQuantity('user');
      
        $countArray['companiesDB']=Company::count();
        $countArray['companiesB24']=$this->helperOriginAPI->getQuantity('company');
      
        $countArray['tasksDB']=B24Task::count();
        $countArray['tasksB24']=$this->helperOriginAPI->getQuantity('task');
      
        $countArray['dealsDB']=B24Deal::count();
        $countArray['dealsB24']=$this->helperOriginAPI->getQuantity('deal');
      
        $countArray['leadsDB']=B24Lead::count();
        $countArray['leadsB24']=$this->helperOriginAPI->getQuantity('lead');
      
        $countArray['ringsDB']=B24Ring::count();
        $countArray['ringsB24']=$this->helperOriginAPI->getQuantity('ring');
      
        $countArray['contactsDB']=B24Contact::count();
        $countArray['contactsB24']=$this->helperOriginAPI->getQuantity('contact');
      

        return view('bitrix24.b24dashboardFirst', [

            'countArray' => $countArray
            
        ]);
       
    }

    public function fetchAll(){

    }

    public function updateData(){
//  dd('Here');
        $controller = new B24LeadController;
        $controller->updateData($_POST['date']);
        }
    
}
