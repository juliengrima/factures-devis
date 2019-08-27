<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Link;
use AppBundle\Entity\Sheet;
use AppBundle\Entity\society;
use AppBundle\Entity\Contact;
use AppBundle\Entity\SheetDev;
use AppBundle\Repository\LinkRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet;
use \PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Sheet controller.
 *
 */
class SheetController extends Controller
{
    /**
     * Lists all sheet entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sheets = $em->getRepository('AppBundle:Sheet')->findAll();
        $links = $em->getRepository('AppBundle:Link')->findAll();

//        foreach ($sheets as $key => $sheet){
//            $links = $em->getRepository('AppBundle:Link')->findBy(array('sheet' => $sheet));
//        }

        return $this->render('sheet/index.html.twig', array(
            'sheets' => $sheets,
            'links' => $links,
        ));
    }

    /**
     * Creates a new sheet entity.
     *
     */
    public function newAction(Request $request)
    {
        $sheet = new Sheet();
        $form = $this->createForm('AppBundle\Form\SheetType', $sheet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($sheet);
            $em->flush();

            return $this->redirectToRoute('sheet_spread', array('id' => $sheet->getId()));
        }

        return $this->render('sheet/new.html.twig', array(
            'sheet' => $sheet,
            'form' => $form->createView(),
        ));
    }

    public function spreadSheetAction(sheet $sheet){

        $sheetId = $sheet->getId();
        $sheetDate = $sheet->getDate();
        $sheetDateStr = $sheetDate->format('dmY');
        $sheetDateStrFac = $sheetDate->format('d-m-Y');
        $societyId = $sheet->getSociety()->getId();
        $societyName = $sheet->getSociety()->getSocietyName();
        $societyAddress = $sheet->getSociety()->getAddress();
        $societyZipCode = $sheet->getSociety()->getZipcode();
        $societyCity = $sheet->getSociety()->getCity();
        $imagePath = $this->get('kernel')->getProjectDir() . '/web/media/images/locals/Acces.png';

        $sheetFac = $sheetDateStr.$societyId.'-'.$sheetId;

        //            USE ON CACHE
        $cache = new FilesystemCache();
        \PhpOffice\PhpSpreadsheet\Settings::setCache($cache);

            $sheetFacture = 'Fac';
            $sheetTitle = $sheetFacture.'-'.$societyName.'-'.$sheetId;
            $sheetName = $sheetFacture.'-'.$societyName.$sheetDateStr.'-'.$sheetId;

//            Loading template
            $templateDirectory = $this->get('kernel')->getProjectDir() . '/web/media/templates/fac-template.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templateDirectory);

            //            GENERATING XLSX FILE
//            PROPERTIES OF THE XLSX DOCUMENT
            $spreadsheet->getProperties()
                ->setCreator('A.C.C.E.S')
                ->setTitle($sheetTitle)
                ->setSubject($sheetName.'-'.$societyName.$sheetId)
                ->setDescription('Génération de documents Excel Devis et Factures.')
                ->setKeywords($sheetName)
                ->setCategory('Excel 2013 XLSX');

//            TITLE OF PAGE AND BODY OF XLSX
            /* @var $sheet Worksheet */
            try
            {
                $worksheet = $spreadsheet->getActiveSheet();
                $worksheet->setCellValue('A1', $imagePath);
                $worksheet->setCellValue('E7', $societyName);
                $worksheet->setCellValue('E8', $societyAddress);
                $worksheet->setCellValue('E9', $societyZipCode);
                $worksheet->setCellValue('F9', $societyCity);
                $worksheet->setCellValue('A17',$sheetFac);
//                $worksheet->setCellValue('G11', $contact);
                $worksheet->setCellValue('B17', $sheetDateStrFac);
                $worksheet->setCellValue('B53', $sheetDateStrFac);

                $sheeti = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $sheeti->setName('acces');
                $sheeti->setDescription('logo');
                $sheeti->setPath($imagePath);
                $sheeti->setHeight(90);
                $sheeti->setCoordinates("A1");
                $sheeti->setOffsetX(0);
                $sheeti->setOffsetY(0);
                $sheeti->setWorksheet($worksheet);
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

            $publicDirectory = $this->get('kernel')->getProjectDir() . '/web/media/documents/factures';
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
            $link->setLink('media/documents/factures/'.$fileName);
            $link->setSheet($sheetId);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($link);
            $entityManager->flush();

        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);

        return $this->redirectToRoute('homepage');
    }

    /**
     * Displays a form to edit an existing sheet entity.
     *
     */
    public function editAction(Request $request, Sheet $sheet)
    {
        $deleteForm = $this->createDeleteForm($sheet);
        $editForm = $this->createForm('AppBundle\Form\SheetType', $sheet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sheet_edit', array('id' => $sheet->getId()));
        }

        return $this->render('sheet/edit.html.twig', array(
            'sheet' => $sheet,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a sheet entity.
     *
     */
    public function deleteAction(Request $request, Sheet $sheet)
    {
        $form = $this->createDeleteForm($sheet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($sheet);
            $em->flush();
        }

        return $this->redirectToRoute('sheet_index');
    }

    /**
     * Creates a form to delete a sheet entity.
     *
     * @param Sheet $sheet The sheet entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sheet $sheet)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sheet_delete', array('id' => $sheet->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
