<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SheetDev;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Cache\Simple\FilesystemCache;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet;
use AppBundle\Entity\Link;
use AppBundle\Entity\Sheet;
use AppBundle\Entity\society;
use AppBundle\Entity\Contact;

/**
 * Sheetdev controller.
 *
 */
class SheetDevController extends Controller
{
    /**
     * Lists all sheetDev entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sheetDevs = $em->getRepository('AppBundle:SheetDev')->findAll();

        return $this->render('sheetdev/index.html.twig', array(
            'sheetDevs' => $sheetDevs,
        ));
    }

    /**
     * Creates a new sheetDev entity.
     *
     */
    public function newAction(Request $request)
    {
        $sheetDev = new Sheetdev();
        $form = $this->createForm('AppBundle\Form\SheetDevType', $sheetDev);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sheetDev);
            $em->flush();

            return $this->redirectToRoute('sheetdev_show', array('id' => $sheetDev->getId()));
        }

        return $this->render('sheetdev/new.html.twig', array(
            'sheetDev' => $sheetDev,
            'form' => $form->createView(),
        ));
    }

    public function spreadSheetDevAction(sheetDev $sheetDev)
    {
        $sheetId = $sheetDev->getId();
        $sheetDate = $sheetDev->getDate();
        $sheetDateStr = $sheetDate->format('dmY');
        $sheetDateStrDev = $sheetDate->format('d-m-Y');
//        $sheetDevis = $sheetDev->getDevis();
        $societyId = $sheetDev->getSociety()->getId();
        $societyName = $sheetDev->getSociety()->getSocietyName();
        $societyAddress = $sheetDev->getSociety()->getAddress();
        $societyZipCode = $sheetDev->getSociety()->getZipcode();
        $societyCity = $sheetDev->getSociety()->getCity();
        $image = $this->get('kernel')->getProjectDir() . '/web/media/images/locals/Acces.png';

        $sheetDevNumber = $sheetDateStr.$societyId.'-'.$sheetId;
//
        //            USE ON CACHE
        $cache = new FilesystemCache();
        \PhpOffice\PhpSpreadsheet\Settings::setCache($cache);

            $sheetFacture = 'Dev';
            $sheetTitle = $sheetFacture.'-'.$societyName.'-'.$sheetId;
            $sheetName = $sheetFacture.'-'.$societyName.$sheetDateStr.'-'.$sheetId;

            //            Loading template
            $templateDirectory = $this->get('kernel')->getProjectDir() . '/web/media/templates/dev-template.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templateDirectory);

            //            GENERATING XLSX FILE
//            PROPERTIES OF THE XLSX DOCUMENT
            $spreadsheet->getProperties()
                ->setCreator('A.C.C.E.S')
                ->setTitle($sheetTitle)
                ->setSubject($sheetName)
                ->setDescription('Génération de documents Excel Devis et Factures.')
                ->setKeywords($sheetName)
                ->setCategory('Excel 2013 XLSX');

//            TITLE OF PAGE AND BODY OF XLSX
            /* @var $sheet Worksheet */
            try {
                $worksheet = $spreadsheet->getActiveSheet();
                $worksheet->setCellValue('A1',$image);
                $worksheet->setCellValue('G2',$sheetDateStrDev);
                $worksheet->setCellValue('E7',$societyName);
                $worksheet->setCellValue('E8', $societyAddress);
                $worksheet->setCellValue('E9', $societyZipCode);
                $worksheet->setCellValue('F9', $societyCity);
//                $worksheet->setCellValue('B14', $sheetDev);
                $worksheet->setCellValue('B14', $sheetDevNumber);
            } catch (\PhpOffice\PhpSpreadsheet\Exception $e) {
            }
            // Redirect output to a client’s web browser (Xlsx)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$sheetName);
            header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
            header('Expires: '.$sheetDateStr); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0

//            Create your Office 2007 Excel (XLSX Format)
            $writer = new Xlsx($spreadsheet);

//            Create a Temporary file in the system USE THE $Society AND TESTING THE ID
            $fileName = $sheetName.'.xlsx';

            $publicDirectory = $this->get('kernel')->getProjectDir() . '/web/media/documents';
            // e.g /var/www/project/public/my_first_excel_symfony4.xls
            $excelFilepath = $publicDirectory . '/' . $fileName;

            try {
                $writer = IOFactory::createWriter($spreadsheet, 'Xls');
            } catch (Exception $e) {
            }
            try {
                $writer->save($excelFilepath);
            } catch (Exception $e) {
            }

            $link = new Link();
            $link->setLinkname($fileName);
            $link->setLink('media/documents/'.$fileName);
            $link->setSheet($sheetId);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($link);
            $entityManager->flush();

        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);

        return $this->redirectToRoute('homepage');

    }

    /**
     * Finds and displays a sheetDev entity.
     *
     */
    public function showAction(SheetDev $sheetDev)
    {
        $deleteForm = $this->createDeleteForm($sheetDev);

        return $this->render('sheetdev/show.html.twig', array(
            'sheetDev' => $sheetDev,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing sheetDev entity.
     *
     */
    public function editAction(Request $request, SheetDev $sheetDev)
    {
        $deleteForm = $this->createDeleteForm($sheetDev);
        $editForm = $this->createForm('AppBundle\Form\SheetDevType', $sheetDev);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sheetdev_edit', array('id' => $sheetDev->getId()));
        }

        return $this->render('sheetdev/edit.html.twig', array(
            'sheetDev' => $sheetDev,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sheetDev entity.
     *
     */
    public function deleteAction(Request $request, SheetDev $sheetDev)
    {
        $form = $this->createDeleteForm($sheetDev);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sheetDev);
            $em->flush();
        }

        return $this->redirectToRoute('sheetdev_index');
    }

    /**
     * Creates a form to delete a sheetDev entity.
     *
     * @param SheetDev $sheetDev The sheetDev entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SheetDev $sheetDev)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sheetdev_delete', array('id' => $sheetDev->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
