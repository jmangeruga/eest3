<?php    
namespace AppBundle\Service\DocumentStorer;

use Google_Client;
use Symfony\Bridge\Monolog\Logger;
use AppBundle\Service\DocumentStorer\Exception\GoogleApiConfigurationException;

class GoogleApiCredentialsConfiguration {

	private const GOOGLE_APPLICATION_CREDENTIALS = 'GOOGLE_APPLICATION_CREDENTIALS';
	private const GOOGLE_ACCOUNT_TYPE = 'GOOGLE_ACCOUNT_TYPE';
	private const GOOGLE_PROJECT_ID = 'GOOGLE_PROJECT_ID';
	private const GOOGLE_API_PRIVATE_KEY_ID = 'GOOGLE_API_PRIVATE_KEY_ID';
	private const GOOGLE_API_JSON_KEY = 'GOOGLE_API_JSON_KEY';
	private const GOOGLE_API_CLIENT_EMAIL = 'GOOGLE_API_CLIENT_EMAIL';
	private const GOOGLE_API_CLIENT_ID = 'GOOGLE_API_CLIENT_ID';
	private const GOOGLE_API_CLIENT_CERT_URL = 'GOOGLE_API_CLIENT_CERT_URL';

	private $logger;

    public function __construct(Logger $logger) {
        $this->logger = $logger;
    }

    public function authorizeClient( Google_Client $client ) {
    	$this->logger->debug( 'Google client configured env vars', $this->buildArrayOfEnvVarValues() );
		if ( $this->credentialsFileVarIsSet() ) {
			$client->useApplicationDefaultCredentials();
		} else if ( $this->credentialsVarsAreSet() ) {
			$client->setAuthConfig( $this->buildAuthorizationConfiguration() );
		} else {
			throw new GoogleApiConfigurationException('There is no configuration set to create google api client.');
		}
			
	}

	private function credentialsFileVarIsSet() {
		return getenv(self::GOOGLE_APPLICATION_CREDENTIALS);
	}

	private function credentialsVarsAreSet() {
		return getenv(self::GOOGLE_ACCOUNT_TYPE) &&
				getenv(self::GOOGLE_PROJECT_ID) &&
				getenv(self::GOOGLE_API_PRIVATE_KEY_ID) &&
				getenv(self::GOOGLE_API_JSON_KEY) &&
				getenv(self::GOOGLE_API_CLIENT_EMAIL) &&
				getenv(self::GOOGLE_API_CLIENT_ID) &&
				getenv(self::GOOGLE_API_CLIENT_CERT_URL);
	}

	private function buildAuthorizationConfiguration() {
		return [
		   "type" => getenv(self::GOOGLE_ACCOUNT_TYPE),
		   "project_id" => getenv(self::GOOGLE_PROJECT_ID),
		   "private_key_id" => getenv(self::GOOGLE_API_PRIVATE_KEY_ID),
		   "private_key" => json_decode(getenv(self::GOOGLE_API_JSON_KEY), true)["key"],
		   "client_email" => getenv(self::GOOGLE_API_CLIENT_EMAIL),
		   "client_id" => getenv(self::GOOGLE_API_CLIENT_ID),
		   "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
		   "token_uri" => "https://accounts.google.com/o/oauth2/token",
		   "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
		   "client_x509_cert_url" => getenv(self::GOOGLE_API_CLIENT_CERT_URL)
		 ];
	}

	private function buildArrayOfEnvVarValues () {
		return array(
    		self::GOOGLE_APPLICATION_CREDENTIALS => getenv(self::GOOGLE_APPLICATION_CREDENTIALS),
    		self::GOOGLE_ACCOUNT_TYPE => getenv(self::GOOGLE_ACCOUNT_TYPE),
			self::GOOGLE_PROJECT_ID => getenv(self::GOOGLE_PROJECT_ID),
			self::GOOGLE_API_PRIVATE_KEY_ID => getenv(self::GOOGLE_API_PRIVATE_KEY_ID),
			self::GOOGLE_API_JSON_KEY => getenv(self::GOOGLE_API_JSON_KEY),
			self::GOOGLE_API_CLIENT_EMAIL => getenv(self::GOOGLE_API_CLIENT_EMAIL),
			self::GOOGLE_API_CLIENT_ID => getenv(self::GOOGLE_API_CLIENT_ID),
			self::GOOGLE_API_CLIENT_CERT_URL => getenv(self::GOOGLE_API_CLIENT_CERT_URL)
    	);
	}

}