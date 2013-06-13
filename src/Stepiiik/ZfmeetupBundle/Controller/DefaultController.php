<?php

namespace Stepiiik\ZfmeetupBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
	/**
     * @Route("/hello/{name}", name="stepiiik_zfmeetup_homepage")
	 * @Template()
	 */
    public function indexAction($name)
    {
        return array('name' => $name);
    }
}
