<?php

namespace AppBundle\Controller;

use AppBundle\Entity\society;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Society controller.
 *
 */
class societyController extends Controller
{
    /**
     * Lists all society entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $societies = $em->getRepository('AppBundle:society')->findAll();

        return $this->render('society/index.html.twig', array(
            'societies' => $societies,
        ));
    }

    /**
     * Creates a new society entity.
     *
     */
    public function newAction(Request $request)
    {
        $society = new Society();
        $form = $this->createForm('AppBundle\Form\societyType', $society);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($society);
            $em->flush();

            return $this->redirectToRoute('society_show', array('id' => $society->getId()));
        }

        return $this->render('society/new.html.twig', array(
            'society' => $society,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a society entity.
     *
     */
    public function showAction(society $society)
    {
        $deleteForm = $this->createDeleteForm($society);

        return $this->render('society/show.html.twig', array(
            'society' => $society,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing society entity.
     *
     */
    public function editAction(Request $request, society $society)
    {
        $deleteForm = $this->createDeleteForm($society);
        $editForm = $this->createForm('AppBundle\Form\societyType', $society);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('society_show', array('id' => $society->getId()));
        }

        return $this->render('society/edit.html.twig', array(
            'society' => $society,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a society entity.
     *
     */
    public function deleteAction(Request $request, society $society)
    {
        $form = $this->createDeleteForm($society);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($society);
            $em->flush();
        }

        return $this->redirectToRoute('society_index');
    }

    /**
     * Creates a form to delete a society entity.
     *
     * @param society $society The society entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(society $society)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('society_delete', array('id' => $society->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
