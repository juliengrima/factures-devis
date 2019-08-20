<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Link;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Link controller.
 *
 */
class LinkController extends Controller
{
    /**
     * Lists all link entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $links = $em->getRepository('AppBundle:Link')->findAll();

        return $this->render('link/index.html.twig', array(
            'links' => $links,
        ));
    }

    /**
     * Finds and displays a link entity.
     *
     */
    public function showAction(Link $link)
    {
        $deleteForm = $this->createDeleteForm($link);

        return $this->render('link/show.html.twig', array(
            'link' => $link,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing link entity.
     *
     */
    public function editAction(Request $request, Link $link)
    {
        $deleteForm = $this->createDeleteForm($link);
        $editForm = $this->createForm('AppBundle\Form\LinkType', $link);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('link_edit', array('id' => $link->getId()));
        }

        return $this->render('link/edit.html.twig', array(
            'link' => $link,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a link entity.
     *
     */
    public function deleteAction(Request $request, Link $link)
    {
        $form = $this->createDeleteForm($link);
        $form->handleRequest($request);

        $file = $link->getFile();
        if ($link->getLink() != null) {	// Si le média contenait déjà un fichier uploadé
            $filename = $link->getLinkname();
//            $tmp = explode('/', $link->getLink());
//            $filename = end($tmp);    // On récupère le nom du fichier ({{media.picname}}.extension

            // On supprime ce fichier du HDD
            if (file_exists ($filename)){
                unlink($this->container->getParameter('link_directory') . '/' . $filename);
                $link->setLink(null);
            }

        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($link);
            $em->flush();
        }

        return $this->redirectToRoute('link_index');
    }

    /**
     * Creates a form to delete a link entity.
     *
     * @param Link $link The link entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Link $link)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('link_delete', array('id' => $link->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}