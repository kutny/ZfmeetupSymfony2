<?php

namespace Stepiiik\ZfmeetupBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\TwigBundle\TwigEngine;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * @Route(service = "controller.security_controller")
 */
class SecurityController
{
    private $twig;

    public function __construct(TwigEngine $twig) {
        $this->twig = $twig;
    }

    /**
     * @Route("/login", name="route.login")
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR); $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->twig->renderResponse('StepiiikZfmeetupBundle:Security:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        )); 
    }
}