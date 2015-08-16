<?php

namespace LostThings\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use LostThings\AdminBundle\Entity\Find;
use LostThings\AdminBundle\Form\FindType;

/**
 * Find controller.
 *
 */
class FindController extends Controller
{

    /**
     * Lists all Find entities.
     *
     */
    public function indexAction(Request $request)
    {

        $request = Request::createFromGlobals();
        if($request->query->get('search')){
            $search = htmlspecialchars($request->query->get('search'));
            $em = $this->getDoctrine()->getManager();

            $entities = $em->getRepository('LostThingsAdminBundle:Find')->search($search);

            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $entities,
                $request->query->getInt('page', 1), 20/*limit per page*/
            );
            return $this->render('LostThingsAdminBundle:Find:index.html.twig', array(
                'entities' => $pagination,
            ));
        }

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LostThingsAdminBundle:Find')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $request->query->getInt('page', 1), 20/*limit per page*/
        );
        return $this->render('LostThingsAdminBundle:Find:index.html.twig', array(
            'entities' => $pagination,
        ));
    }
    /**
     * Creates a new Find entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Find();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_find__show', array('id' => $entity->getId())));
        }

        return $this->render('LostThingsAdminBundle:Find:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Find entity.
     *
     * @param Find $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Find $entity)
    {
        $form = $this->createForm(new FindType(), $entity, array(
            'action' => $this->generateUrl('admin_find__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Find entity.
     *
     */
    public function newAction()
    {
        $entity = new Find();
        $form   = $this->createCreateForm($entity);

        return $this->render('LostThingsAdminBundle:Find:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Find entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LostThingsAdminBundle:Find')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Find entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('LostThingsAdminBundle:Find:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Find entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LostThingsAdminBundle:Find')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Find entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('LostThingsAdminBundle:Find:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Find entity.
    *
    * @param Find $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Find $entity)
    {
        $form = $this->createForm(new FindType(), $entity, array(
            'action' => $this->generateUrl('admin_find__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Find entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LostThingsAdminBundle:Find')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Find entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_find__edit', array('id' => $id)));
        }

        return $this->render('LostThingsAdminBundle:Find:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Find entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LostThingsAdminBundle:Find')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Find entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_find_'));
    }

    /**
     * Creates a form to delete a Find entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_find__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
