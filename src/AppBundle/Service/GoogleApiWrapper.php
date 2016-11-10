<?php    
namespace AppBundle\Service;

use Google_Service_Drive;
use Google_Client;
use Symfony\Bridge\Monolog\Logger;
use AppBundle\Exception\GoogleApiWrapperException;

class GoogleApiWrapper {

	protected $logger;

    public function __construct(Logger $logger) {
        $this->logger = $logger;
    }
	
	private function googleCredentialsAreSet() {
		return getenv('GOOGLE_APPLICATION_CREDENTIALS') || 
				(getenv('GOOGLE_ACCOUNT_TYPE')&&
				getenv('GOOGLE_PROJECT_ID')&&
				getenv('GOOGLE_API_PRIVATE_KEY_ID')&&
				getenv('GOOGLE_API_PRIVATE_KEY')&&
				getenv('GOOGLE_API_CLIENT_EMAIL')&&
				getenv('GOOGLE_API_CLIENT_ID')&&
				getenv('GOOGLE_API_CLIENT_CERT_URL'));
	}
	
    public function getFiles() {
		if ($this->googleCredentialsAreSet()) {
			// Get the API client and construct the service object.
			$client = $this->getClient();
			$service = new Google_Service_Drive($client);

			$optParams = array(
			  'pageSize' => 20,
			  'fields' => 'nextPageToken, files(id, name, webContentLink, webViewLink)'
			); //Configuration params which for instance help to select which fields to retrieve or paginate the results.
			return $service->files->listFiles($optParams);
		} else 
			throw new GoogleApiWrapperException('There are no credentials set');
    }
	
	/**
	 * Returns an authorized API client.
	 * @return Google_Client the authorized client object
	 */
	function getClient() {
		$client = new Google_Client();
		//Try to fix it: Workaround to solve the problem with private key. Probably something wrong with encoding or some missing sep to decode the key.
		$config = json_decode(getenv('GOOGLE_API_JSON_KEY'), true);
		
		$auth = [
		  "type" => getenv('GOOGLE_ACCOUNT_TYPE'),
		  "project_id" => getenv('GOOGLE_PROJECT_ID'),
		  "private_key_id" => getenv('GOOGLE_API_PRIVATE_KEY_ID'),
		  "private_key" => $config["key"],
		  "client_email" => getenv('GOOGLE_API_CLIENT_EMAIL'),
		  "client_id" => getenv('GOOGLE_API_CLIENT_ID'),
		  "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
		  "token_uri" => "https://accounts.google.com/o/oauth2/token",
		  "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
		  "client_x509_cert_url" => getenv('GOOGLE_API_CLIENT_CERT_URL')
		];
		$client->setAuthConfig($auth);
		$client->setApplicationName("EEST3");
		$client->setScopes(Google_Service_Drive::DRIVE);
		return $client;
	}

}