<?php

namespace Stepiiik\ZfmeetupBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Stepiiik\ZfmeetupBundle\Entity\Album;
use Stepiiik\ZfmeetupBundle\Repository\AlbumRepository;
use Stepiiik\ZfmeetupBundle\Type\AlbumType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Router;

/**
 * @Route(service = "controller.album_controller")
 */
class AlbumController
{
    private $albumRepository;
    private $formFactory;
    private $session;
    private $router;
    private $albumType;

    public function __construct(AlbumRepository $albumRepository, FormFactory $formFactory, Session $session, Router $router, AlbumType $albumType) {
        $this->albumRepository = $albumRepository;
        $this->formFactory = $formFactory;
        $this->session = $session;
        $this->router = $router;
        $this->albumType = $albumType;
    }

	/**
     * @Route("/album/", name="route.album")
     * @Template()
     */
    public function albumListAction()
    {
        $entities = $this->albumRepository->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * @Route("/album/new", name="route.album_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Album();
        $form   = $this->formFactory->create($this->albumType, $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * @Route("/album/new")
     * @Method("POST")
     * @Template("StepiiikZfmeetupBundle:Album:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Album();
        $form = $this->formFactory->create($this->albumType, $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $this->albumRepository->save($entity);

            $this->session->getFlashBag()->add('success', 'Záznam by úspěně upraven!');

            return new RedirectResponse($this->router->generate('route.album'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * @Route("/album/{id}/edit", name="route.album_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $entity = $this->albumRepository->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('Unable to find Album entity.');
        }

        $editForm = $this->formFactory->create($this->albumType, $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @Route("/album/{id}/edit")
     * @Method("POST")
     * @Template("StepiiikZfmeetupBundle:Album:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $entity = $this->albumRepository->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('Unable to find Album entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->formFactory->create($this->albumType, $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->albumRepository->save($entity);

            $this->session->getFlashBag()->add('success', 'Záznam by úspěně upraven!');

            return new RedirectResponse($this->router->generate('route.album_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @Route("/album/{id}/delete", name="route.album_delete")
     * @Method("POST")
     * @Template()
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $entity = $this->albumRepository->find($id);

            if (!$entity) {
                throw new NotFoundHttpException('Unable to find Album entity.');
            }

            $this->albumRepository->remove($entity);

            $this->session->getFlashBag()->add('success', 'Záznam by úspěně smazán!');
        }

        return new RedirectResponse($this->router->generate('route.album'));
    }

    private function createDeleteForm($id)
    {
        return $this->formFactory->createBuilder()
            ->add('id', 'hidden', array('data' => $id))
            ->getForm();
    }
}
