<?php

namespace AppBundle\Controller;

use AppBundle\Service\GDrive\GoogleApiWrapper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        // replace this example code with whatever you need
        return $this->render('home/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
        ));
    }

    /**
	 * @Route("store", name="store")
	 */
    public function storeDocument() {
    	$drive = $this->get('documents.storer');
    	try {
    		$pagename = 'my_page1';

    		if (!file_exists($this->getParameter('uploads_directory'))) {
    			mkdir($this->getParameter('uploads_directory'), 0777, true);
			}
			$newFileName = $this->getParameter('uploads_directory').'/a.txt';
			$newFileContent = '<?php echo "something..."; ?>';

			$createdFile = @file_put_contents($newFileName, $newFileContent);
			if ( $createdFile !== false) {
    			$this->get('logger')->info("File created (" . basename($newFileName) . ")");
			} else {
    			$this->get('logger')->info("Cannot create file (" . basename($newFileName) . ")");
			}

    		return new Response('File stored. Here is its download link -> '.
				$drive->storeDocument($this->getParameter('uploads_directory').'/a.txt', 'documentName')
			);
    	} catch (GoogleApiWrapperException $e) {
			return new Response("There was an error trying to store file on GDrive.");
		}
    }
	
}
