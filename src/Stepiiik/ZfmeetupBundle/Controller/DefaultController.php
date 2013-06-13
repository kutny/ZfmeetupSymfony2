<?php

namespace Stepiiik\ZfmeetupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
