<?php    
namespace AppBundle\Service\DocumentStorer;

use Google_Service_Drive;
use Google_Client;
use Google_Service_Drive_DriveFile;
use Google_Service_Drive_Permission;
use Symfony\Bridge\Monolog\Logger;
use AppBundle\Exception\FileNotFoundException;

class GoogleApiDocumentStorer {

	private $logger;
	private $sharedFolderId;
	private $driveService;

    public function __construct( GoogleApiCredentialsConfiguration $configuration, String $sharedFolderId, Logger $logger ) {
        $this->logger = $logger;
        $this->sharedFolderId = $sharedFolderId;
        $this->driveService = $this->buildGoogleDriveService( $configuration );
    }

    private function buildGoogleDriveService( GoogleApiCredentialsConfiguration $configuration ) {
    	$apiClient = new Google_Client( array('application_name' => 'EEST3') );
		$apiClient->setScopes(Google_Service_Drive::DRIVE);
    	$configuration->authorizeClient($apiClient);
    	return new Google_Service_Drive($apiClient);
    }

	public function storeDocument( $file, $documentName ) {
		$fileContent = @file_get_contents($file);
		if ($fileContent !== false) {
			$fileMetadata = new Google_Service_Drive_DriveFile(array('parents' => array($this->sharedFolderId), 'name' => $documentName));
			$storedFile = $this->driveService->files->create($fileMetadata, array(
				'data' => $fileContent,
				'uploadType' => 'multipart',
				'fields' => 'id, webContentLink'));
			$this->logger->debug('StoredFileId: '.$storedFile->getId().' WebContentLink: '.$storedFile->getWebContentLink());
			return $storedFile->getWebContentLink();
		} else throw new FileNotFoundException("Error reading file to store - file name: ".$file, 1);
	}

}