<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Years;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Year controller.
 *
 */
class YearsController extends Controller
{
    /**
     * Lists all year entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $years = $em->getRepository('AppBundle:Years')->findAll();

        return $this->render('years/index.html.twig', array(
            'years' => $years,
        ));
    }

    /**
     * Displays a form to edit an existing year entity.
     *
     */
    public function editAction(Request $request, Years $year)
    {
        $editForm = $this->createForm('AppBundle\Form\YearsType', $year);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('years_edit', array('id' => $year->getId()));
        }

        return $this->render('years/edit.html.twig', array(
            'year' => $year,
            'edit_form' => $editForm->createView(),
        ));
    }

}
