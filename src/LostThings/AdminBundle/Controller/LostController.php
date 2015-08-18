<?php

namespace LostThings\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use LostThings\AdminBundle\Entity\Lost;
use LostThings\AdminBundle\Form\LostType;

/**
 * Lost controller.
 *
 */
class LostController extends Controller
{

    /**
     * Lists all Lost entities.
     *
     */
    public function indexAction(Request $request)
    {

        $request = Request::createFromGlobals();
        if($request->query->get('search')){
            $search = htmlspecialchars($request->query->get('search'));
            $em = $this->getDoctrine()->getManager();

            $entities = $em->getRepository('LostThingsAdminBundle:Lost')->search($search);

            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $entities,
                $request->query->getInt('page', 1), 20/*limit per page*/
            );
            return $this->render('LostThingsAdminBundle:Lost:index.html.twig', array(
                'entities' => $pagination,
            ));
        }

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LostThingsAdminBundle:Lost')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $request->query->getInt('page', 1), 20/*limit per page*/
        );
        return $this->render('LostThingsAdminBundle:Lost:index.html.twig', array(
            'entities' => $pagination,
        ));
    }
    /**
     * Creates a new Lost entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Lost();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_lost__show', array('id' => $entity->getId())));
        }

        return $this->render('LostThingsAdminBundle:Lost:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Lost entity.
     *
     * @param Lost $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Lost $entity)
    {
        $form = $this->createForm(new LostType(), $entity, array(
            'action' => $this->generateUrl('admin_lost__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Lost entity.
     *
     */
    public function newAction()
    {
        $entity = new Lost();
        $form   = $this->createCreateForm($entity);

        return $this->render('LostThingsAdminBundle:Lost:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Lost entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LostThingsAdminBundle:Lost')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lost entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('LostThingsAdminBundle:Lost:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Lost entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LostThingsAdminBundle:Lost')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lost entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('LostThingsAdminBundle:Lost:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Lost entity.
    *
    * @param Lost $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Lost $entity)
    {
        $form = $this->createForm(new LostType(), $entity, array(
            'action' => $this->generateUrl('admin_lost__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Обновить', 'attr' => array('class' => 'button primary_button')));

        return $form;
    }
    /**
     * Edits an existing Lost entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LostThingsAdminBundle:Lost')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lost entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_lost__edit', array('id' => $id)));
        }

        return $this->render('LostThingsAdminBundle:Lost:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Lost entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LostThingsAdminBundle:Lost')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Lost entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_lost_'));
    }

    /**
     * Creates a form to delete a Lost entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_lost__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete', 'attr' => array('class' => 'button delete_button')))
            ->getForm()
        ;
    }
}
