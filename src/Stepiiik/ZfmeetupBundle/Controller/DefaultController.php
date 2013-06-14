<?php

namespace Stepiiik\ZfmeetupBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\SecurityContext;

/**
 * @Route(service = "controller.default_controller")
 */
class DefaultController
{
    private $router;
    private $securityContext;

    public function __construct(Router $router, SecurityContext $securityContext) {
        $this->router = $router;
        $this->securityContext = $securityContext;
    }

    /**
     * @Route("/", name="route.homepage")
     */
    public function homepageAction()
    {
        $userIsAuthenticated = $this->securityContext->getToken()->isAuthenticated();

        if ($userIsAuthenticated) {
            return new RedirectResponse($this->router->generate('route.album'));
        }
        else {
            return new RedirectResponse($this->router->generate('route.login'));
        }
    }

	/**
     * @Route("/hello/{name}", name="route.hello")
	 * @Template()
	 */
    public function helloAction($name)
    {
        return array('name' => $name);
    }
}
