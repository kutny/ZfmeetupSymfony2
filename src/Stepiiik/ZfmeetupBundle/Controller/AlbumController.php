<?php

namespace Stepiiik\ZfmeetupBundle\Controller;

use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Stepiiik\ZfmeetupBundle\Entity\Album;
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
    private $entityManager;
    private $formFactory;
    private $session;
    private $router;

    public function __construct(EntityManager $entityManager, FormFactory $formFactory, Session $session, Router $router) {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->session = $session;
        $this->router = $router;
    }

	/**
     * @Route("/album/", name="route.album")
     * @Template()
     */
    public function albumListAction()
    {
        $entities = $this->entityManager->getRepository('StepiiikZfmeetupBundle:Album')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * @Route("/album/new", name="route.album_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Album();
        $form   = $this->formFactory->create(new AlbumType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * @Route("/album/create", name="route.album_create")
     * @Method("POST")
     * @Template("StepiiikZfmeetupBundle:Album:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Album();
        $form = $this->formFactory->create(new AlbumType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();

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
     * @Template()
     */
    public function editAction($id)
    {
        $entity = $this->entityManager->getRepository('StepiiikZfmeetupBundle:Album')->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('Unable to find Album entity.');
        }

        $editForm = $this->formFactory->create(new AlbumType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @Route("/album/{id}/update", name="route.album_update")
     * @Method("POST")
     * @Template()
     */
    public function updateAction(Request $request, $id)
    {
        $entity = $this->entityManager->getRepository('StepiiikZfmeetupBundle:Album')->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('Unable to find Album entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->formFactory->create(new AlbumType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();

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
            $entity = $this->entityManager->getRepository('StepiiikZfmeetupBundle:Album')->find($id);

            if (!$entity) {
                throw new NotFoundHttpException('Unable to find Album entity.');
            }

            $this->entityManager->remove($entity);
            $this->entityManager->flush();

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
