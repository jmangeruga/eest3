<?php

namespace AppBundle\Controller;

use AppBundle\Service\GoogleApiWrapper;
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
	 * @Route("pruebadrive", name="drive")
	 */
	public function callToDriveAction() {
		$drive = new GoogleApiWrapper($this->get('logger'));
		try {
			$files = $drive->getFiles();
			$filesList = "<ul>";
			if (count($files->getFiles()) == 0) {
				$fileList = "<strong> EMPTY </strong>";
			} else {
				foreach ($files->getFiles() as $file)
					$filesList = $filesList."<li>".$file->getName()."</li>";
				$fileList = $filesList."</ul>";
			}
			return new Response($filesList);
		} catch (GoogleApiWrapperException $e) {
			return new Response("There was an error trying to retrieve files from GDrive.");
		}
	}
	
	
}
