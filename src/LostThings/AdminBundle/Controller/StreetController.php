<?php

namespace LostThings\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use LostThings\AdminBundle\Entity\Street;
use LostThings\AdminBundle\Form\StreetType;

/**
 * Street controller.
 *
 */
class StreetController extends Controller
{

    /**
     * Lists all Street entities.
     *
     */
    public function indexAction(Request $request)
    {

        $request = Request::createFromGlobals();
        if($request->query->get('search')){
            $search = htmlspecialchars($request->query->get('search'));
            $em = $this->getDoctrine()->getManager();

            $entities = $em->getRepository('LostThingsAdminBundle:Street')->search($search);

            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $entities,
                $request->query->getInt('page', 1), 20/*limit per page*/
            );
            return $this->render('LostThingsAdminBundle:Street:index.html.twig', array(
                'entities' => $pagination,
            ));
        }

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('LostThingsAdminBundle:Street')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $request->query->getInt('page', 1), 20/*limit per page*/
        );
        return $this->render('LostThingsAdminBundle:Street:index.html.twig', array(
            'entities' => $pagination,
        ));
    }
    /**
     * Creates a new Street entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Street();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_street__show', array('id' => $entity->getId())));
        }

        return $this->render('LostThingsAdminBundle:Street:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Street entity.
     *
     * @param Street $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Street $entity)
    {
        $form = $this->createForm(new StreetType(), $entity, array(
            'action' => $this->generateUrl('admin_street__create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Street entity.
     *
     */
    public function newAction()
    {
        $entity = new Street();
        $form   = $this->createCreateForm($entity);

        return $this->render('LostThingsAdminBundle:Street:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Street entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LostThingsAdminBundle:Street')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Street entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('LostThingsAdminBundle:Street:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Street entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LostThingsAdminBundle:Street')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Street entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('LostThingsAdminBundle:Street:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Street entity.
    *
    * @param Street $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Street $entity)
    {
        $form = $this->createForm(new StreetType(), $entity, array(
            'action' => $this->generateUrl('admin_street__update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Изменить', 'attr' => array('class' => 'button primary_button')));

        return $form;
    }
    /**
     * Edits an existing Street entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('LostThingsAdminBundle:Street')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Street entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_street__edit', array('id' => $id)));
        }

        return $this->render('LostThingsAdminBundle:Street:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Street entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('LostThingsAdminBundle:Street')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Street entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_street_'));
    }

    /**
     * Creates a form to delete a Street entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_street__delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Удалить', 'attr' => array('class' => 'button delete_button')))
            ->getForm()
        ;
    }
}
