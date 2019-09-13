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
     * Deletes a link entity.
     *
     */
    public function deleteAction(Request $request, Link $link)
    {
        $form = $this->createDeleteForm($link);
        $form->handleRequest($request);

        $filename = $link->getLinkname();
        $sheet = $link->getId();

        if ($form->isSubmitted() && $form->isValid()) {

            $publicDevDirectory = $this->get('kernel')->getProjectDir() . '/web/media/documents/devis';
            $publicFacDirectory = $this->get('kernel')->getProjectDir() . '/web/media/documents/factures';
            // e.g /var/www/project/public/my_first_excel_symfony4.xls
            $excelDevFilepath = $publicDevDirectory . '/' . $filename;
            $excelFacFilepath = $publicFacDirectory . '/' . $filename;

            $rest = substr($filename, 0, 2);

//       Deleting files
            if($rest != 'dev'){
                unlink($excelFacFilepath);
                $link->setLink(null);
            }
            else{
                unlink($excelDevFilepath);
                $link->setLink(null);
            }

            $em = $this->getDoctrine()->getManager();
            $em->remove($link);
            $em->flush();
        }

        if($rest == 'dev'){
            return $this->redirectToRoute('sheetdev_delete', array('id' => $sheet));
        }
        else{
            return $this->redirectToRoute('sheet_delete', array('id' => $sheet));
        }

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
