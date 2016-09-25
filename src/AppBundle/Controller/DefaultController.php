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
		return new Response($drive->getGoogleDriveConnection());
	}
	
	
}
