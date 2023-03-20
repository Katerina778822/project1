<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Nodes;
use App\Models\Goods;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Google\Service\Sheets;
use Google\Service\Sheets\ValueRange;
use Google\Client;
use Google\AssertionCredentials;
use App\Http\Controllers\Hybridauth\Provider\Google;
use App\Models\Catalogs;
use Illuminate\Support\Arr;

//define('STDIN', fopen("php://stdin", "r"));
//require __DIR__ . '../vendor/autoload.php';
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $google_client;

    private function initClient()
    {
        $this->google_client = new Client();
        $this->google_client->setClientId('847966487851-idmaecqrgpm2ojphqd19kbcidplu67re.apps.googleusercontent.com');
        $this->google_client->setClientSecret('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');
        $this->google_client->setApplicationName('Google Sheets API PHP Quickstart');
        $this->google_client->setScopes(Sheets::SPREADSHEETS);
        $this->google_client->setRedirectUri('https://' . $_SERVER['HTTP_HOST'] . '/fetchToken');
        $this->google_client->setAccessType('offline');
        $this->google_client->setPrompt('select_account consent');
        if (!empty($_SESSION['token']))
            $this->google_client->setAccessToken($_SESSION['token']);
        return $this->google_client;
    }

    public function fetchToken()
    {
        session_start(); // Токен будем хранить в сессии
        if (!empty($_GET['code']))
            if (isset($_GET['code'])) {
                $this->initClient();
                $response = $this->google_client->fetchAccessTokenWithAuthCode($_GET['code']);

                // Если при получении токена произошла ошибка
                if (isset($response['error'])) {
                    throw new Exception('При получении токена произошла ошибка. Error: ' . $response['error'] . '. Error description: ' . $response['error_description']);
                }
                //
                $accessToken = $response['access_token']; // access токен
                $expiresIn = $response['expires_in']; // истекает через 3600 (сек.) (1 час)
                $refreshToken = $response['refresh_token']; // refresh токен - используется для обновления access токена
                $scope = $response['scope']; // области, к которым был получен доступ
                $tokenType = $response['token_type']; // тип токена
                //$idToken = $response['id_token']; // id токена
                $created = $response['created']; // время создания токена 1537170421

                // Сохраняем токен в сессии
                $_SESSION['token'] = json_encode($response);
            }
        return redirect('/node');
    }

    public function exportDataSheet($id_node)
    {
        session_start();

        // $client = $this->getToken();dd('Here');
        //$client = $this->getClient();   
        $this->initClient();
        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = 'token.json';
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $this->google_client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($this->google_client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($this->google_client->getRefreshToken()) {
                $this->google_client->fetchAccessTokenWithRefreshToken($this->google_client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $this->google_client->createAuthUrl();//dd($authUrl);
                //return redirect()->away($client->createAuthUrl());
                echo '<a href="' .  $this->google_client->createAuthUrl() . '">Авторизация через Google</a>';
                return view('partial.token', ['authUrl' => $authUrl]);
            }
        }
        ///////
        $service = new Sheets($this->google_client);

        // Prints the names and majors of students in a sample spreadsheet:
        // https://docs.google.com/spreadsheets/d/1BxiMVs0XRA5nFMdKvBdBZjgmUUqptlbs74OgvE2upms/edit
        $spreadsheetId = '1oDFwBmXAnh4opgzMi6OpmGlrXqvT17JOL0QujJ27aJY';
        // $range = '123!A2:E';
        $node = Nodes::find($id_node);
        $catalogs = $node->Catalogs;
        $i = 1;
        $values = array();
        foreach ($catalogs as $catalog) {
            $goods = $catalog->Goods;
            foreach ($goods as $key1 => $good) {
                $value = array();
                $good = $good->attributesToArray();
                foreach ($good as $key2 => $val) {
                    if (!empty($val))
                        $value[] = $val;
                        else
                        $value[] = '';
                }
                if (!empty($value))
                $values[] = $value;
            }
            
        }//dd($values);   
        try {
            $range = 'R'.$i.'C1:R10000C100';
            $body = new ValueRange([
                'values' => $values
            ]);
            $params = [
                'valueInputOption' => 'USER_ENTERED'
            ];
            $i=sizeof($values);// dd( $values );
            $result = $service->spreadsheets_values->update($spreadsheetId, $range, $body, $params);
            printf("%d cells updated.", $result->getUpdatedCells());
        } catch (Exception $e) {
            /*  if (401 == $e->getCode()) {
                $refresh_token = $db->get_refersh_token();

                $client = new GuzzleHttp\Client(['base_uri' => 'https://accounts.google.com']);

                $response = $client->request('POST', '/o/oauth2/token', [
                    'form_params' => [
                        "grant_type" => "refresh_token",
                        "refresh_token" => $refresh_token,
                        "client_id" => GOOGLE_CLIENT_ID,
                        "client_secret" => GOOGLE_CLIENT_SECRET,
                    ],
                ]);

                $data = (array) json_decode($response->getBody());
                $data['refresh_token'] = $refresh_token;

                $db->update_access_token(json_encode($data));

                write_to_sheet($spreadsheetId);
            } else {*/
            echo $e->getMessage(); //print the error just in case your data is not added.
            // }
        }
    }
}
