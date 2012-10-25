<?php

namespace Stepiiik\ZfmeetupBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('StepiiikZfmeetupBundle:Default:index.html.twig', array('name' => $name));
    }
}
