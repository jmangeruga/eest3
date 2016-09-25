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
	
    public function getGoogleDriveConnection() {
		if (getenv('GOOGLE_APPLICATION_CREDENTIALS')) {
			// Get the API client and construct the service object.
			$client = $this->getClient();
			$service = new Google_Service_Drive($client);

			// Print the names and IDs for up to 10 files.
			$optParams = array(
			  'pageSize' => 10,
			  'fields' => 'nextPageToken, files(id, name)'
			);
			$results = $service->files->listFiles($optParams);
			if (count($results->getFiles()) == 0) {
				return  "<p> No files found. </p>";
			} else {
				foreach ($results->getFiles() as $file)
					$this->logger->info($file->getName().' '.$file->getId());
				return "<p>There are many files </p>";
			}
		
			return '<html><body>Lucky number: </body></html>';
		} else 
			throw new GoogleApiWrapperException('There are no credentials set');
    }
	
	/**
	 * Returns an authorized API client.
	 * @return Google_Client the authorized client object
	 */
	function getClient() {
		$client = new Google_Client();
		$client->useApplicationDefaultCredentials();
		$client->setApplicationName("EEST3");
		$client->setScopes(Google_Service_Drive::DRIVE);
		return $client;
	}

}