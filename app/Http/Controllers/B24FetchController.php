<?php



namespace App\Http\Controllers;

use App\Helpers\Bitrix24\b24Companies;
use App\Jobs\B24UpdateFetch;
use App\Models\B24Activity;
use App\Models\B24Contact;
use App\Models\B24Deal;
use App\Models\B24Lead;
use App\Models\B24Ring;
use App\Models\B24Task;
use App\Models\B24User;
use App\Models\Company;
use Bitrix24\SDK\Core\Credentials\ApplicationProfile;
use Bitrix24\SDK\Services\Main\Service\Main;
use DateTime;
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
        $countArray['usersDB'] = B24User::count();
        $countArray['usersB24'] = $this->helperOriginAPI->getQuantity('user');

        $countArray['companiesDB'] = Company::count();
        $countArray['companiesB24'] = $this->helperOriginAPI->getQuantity('company');

        $countArray['tasksDB'] = B24Task::count();
        $countArray['tasksB24'] = $this->helperOriginAPI->getQuantity('task');

        $countArray['activityDB'] = B24Activity::count();
        $requestArray['filter'] = [
            'PROVIDER_ID' => ['IMOPENLINES_SESSION', 'CRM_TODO']
        ];
        $countArray['activityB24'] = $this->helperOriginAPI->getQuantity('activity', null, null, $requestArray);

        $countArray['dealsDB'] = B24Deal::count();
        $countArray['dealsB24'] = $this->helperOriginAPI->getQuantity('deal');

        $countArray['leadsDB'] = B24Lead::count();
        $countArray['leadsB24'] = $this->helperOriginAPI->getQuantity('lead');

        $countArray['ringsDB'] = B24Ring::count();
        $countArray['ringsB24'] = $this->helperOriginAPI->getQuantity('ring');

        $countArray['contactsDB'] = B24Contact::count();
        $countArray['contactsB24'] = $this->helperOriginAPI->getQuantity('contact');

        return view('bitrix24.b24dashboardFirst', [

            'countArray' => $countArray

        ]);
    }

    public function fetchAll($date = null)
    {
        $job = new B24UpdateFetch();
        $this->dispatch($job);
    }

    public function updateData($checkDate = null)
    {
        $date = new DateTime('-3 days');
        $date = $date->format('Y-m-d');
        if (!empty($checkDate)) {
            $date = $checkDate;
        }

        if (!empty($_POST['date']))
            if ($_POST['date'] > $date)
                $date = $_POST['date'];

        $controller = new B24LeadController;
        $controller->updateData($date);

        $controller = new CompanyController;
        $controller->updateData($date);

        $controller = new B24RingController;
        $controller->updateData($date);

        $controller = new B24TaskController;
        $controller->updateData($date);

        $controller = new B24DealController;
        $controller->updateData($date);

        $controller = new B24ActivityController;
        $controller->updateData($date);

        $controller = new B24ContactController;
        $controller->fetchData($date);
    }

    public function updateDataCompany()
    {
        $date = new DateTime('-10 days');
        $date = $date->format('Y-m-d');

        if ($_POST['date'] > $date)
            $date = $_POST['date'];
        //  dd('Here');
        $controller = new CompanyController;
        $controller->updateData($date);
    }

    public function updateDataRing()
    {
        $date = new DateTime('-10 days');
        $date = $date->format('Y-m-d');

        if ($_POST['date'] > $date)
            $date = $_POST['date'];

        $controller = new B24RingController;
        $controller->updateData($date);
    }

    public function updateDataTask()
    {
        $date = new DateTime('-10 days');
        $date = $date->format('Y-m-d');

        if ($_POST['date'] > $date)
            $date = $_POST['date'];

        $controller = new B24TaskController;
        $controller->updateData($date);
    }

    public function updateDataActivity()
    {
        $date = new DateTime('-10 days');
        $date = $date->format('Y-m-d');

        if ($_POST['date'] > $date)
            $date = $_POST['date'];

        $controller = new B24ActivityController;
        $controller->updateData($date);
    }
    public function updateDataDeal()
    {
        $date = new DateTime('-10 days');
        $date = $date->format('Y-m-d');

        if ($_POST['date'] > $date)
            $date = $_POST['date'];

        $controller = new B24DealController;
        $controller->updateData($date);
    }

    public function updateDataLead()
    {
        $date = new DateTime('-10 days');
        $date = $date->format('Y-m-d');

        if ($_POST['date'] > $date)
            $date = $_POST['date'];

        $controller = new B24LeadController;
        $controller->updateData($date);
    }
}
