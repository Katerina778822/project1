<?php
require __DIR__ . '/vendor/autoload.php';
putenv('GOOGLE_APPLICATION_CREDENTIALS=/credentials.json');
/*if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}*/

$client = new Google\Client();
$client->useApplicationDefaultCredentials();
$client->addScope(Google\Service\Sheets::SPREADSHEETS);
$service = new \Google\Service\Sheets($client);
$sheets = new Google\Service\Sheets();
$sheets->setService($service);

$values = $sheets->spreadsheet('spreadsheetID')->sheet('Sheet 1')->all();
/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient()
{
}
