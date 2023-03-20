<?php
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_StorageService.php';

class Model_Storage_Auth
{
    const CLIENT_ID = "someuniquenumber.apps.googleusercontent.com";
    const SERVICE_ACCOUNT_NAME = "myserviceaccountname@developer.gserviceaccount.com";
    const KEY_FILE = "/supersecretpath/key.p12";
    const ACCESS_TOKEN = 'access_token';
    const APP_NAME = 'My App Name';

    private $google_client;

    function __construct()
    {
        $this->google_client = new Google_Client();
        $this->google_client->setApplicationName(self::APP_NAME);
    }

    public function getToken()
    {
        if(!is_null($this->google_client->getAccessToken())){}
        elseif(!is_null(Session::get(self::ACCESS_TOKEN, null)))
        {
            $this->google_client->setAccessToken(Session::get(self::ACCESS_TOKEN, null));
        }
        else
        {
            $scope = array();
            $scope[] = 'https://www.googleapis.com/auth/devstorage.full_control';
            $key = file_get_contents(self::KEY_FILE);
            $this->google_client->setAssertionCredentials(new Google_AssertionCredentials(
                self::SERVICE_ACCOUNT_NAME,
                $scope,
                $key)
            );
            $this->google_client->setClientId(self::CLIENT_ID);
            Google_Client::$auth->refreshTokenWithAssertion();
            $token = $this->google_client->getAccessToken();
            Session::set(self::ACCESS_TOKEN, $token);
        }
        return $this->google_client->getAccessToken();
    }

}