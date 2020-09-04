<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Link;
use AppBundle\Entity\SheetDev;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Cache\Simple\FilesystemCache;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet;

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

// Call to Entities and count entries
        $em = $this->getDoctrine()->getManager();
        $countSheetDevId = $em->getRepository('AppBundle:SheetDev')->countByDev();
        $hightId = $em->getRepository('AppBundle:SheetDev')->hightId();

        if ($form->isSubmitted() && $form->isValid()) {
//            TESTING $newSheetDevID IF is NULL OR NOT
//            IF IT'S DIFFERENT OF NULL
            $newsheetDevId = $request->request->get('count');
            if(isset($newsheetDevId) != null and $sheetDev->getSociety() == null) {
//                TESTING IF COUNT OF ENTRIES IS LESS THAN THE NEW ENTRY
//                MAKE A LOOP WHILE LESS THAN NEW ENTRY
                while ($countSheetDevId < $newsheetDevId){
                    $sheetDev = new SheetDev();
                    $sheetDev->setYears('90');
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($sheetDev);
                    $countSheetDevId++;
                }
                $em->flush();
//              FORCED DATA FOR AUTOMATIC REMOVE
                for($i = 0; $i <= $countSheetDevId; $i++){
                    $sheetDevs = $em->getRepository('AppBundle:SheetDev')->findBy(array('id' => $i));
                    foreach ($sheetDevs as $sheetDev){
                        $em = $this->getDoctrine()->getManager();
                        $em->remove($sheetDev);
                    }
                 }
                $em->flush();
//                    LOOP IS FINISHED RETURN TO NEW PAGE
                return $this->render('sheetdev/new.html.twig', array(
                    'sheetDev' => $sheetDev,
                    'count' => $countSheetDevId,
                    'hight' => $hightId,
                    'form' => $form->createView(),
                ));
            }
//            ENTRY $newSheetDevId IS NULL SO GENERATE A NEW SHEET
            else{
                if ($society = $sheetDev->getSociety() != null){
                    $pages = $request->request->get('pages');

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($sheetDev);
                    $em->flush();

                    return $this->redirectToRoute('sheetdev_spread', array('id' => $sheetDev->getId(), 'pages' => $pages));
                }
                return $this->render('sheetdev/new.html.twig', array(
                    'sheetDev' => $sheetDev,
                    'count' => $countSheetDevId,
                    'hight' => $hightId,
                    'form' => $form->createView(),
                ));
            }

        }
        return $this->render('sheetdev/new.html.twig', array(
            'sheetDev' => $sheetDev,
            'count' => $countSheetDevId,
            'hight' => $hightId,
            'form' => $form->createView(),
        ));
    }

    public function spreadSheetDevAction(sheetDev $sheetDev, Request $request)
    {
//        $pages = $request->request->get('pages');
        $pages = $_GET['pages'];

        $sheetId = $sheetDev->getId();
        $sheetDate = $sheetDev->getDate();
        $sheetDateStr = $sheetDate->format('dmY');
        $sheetDateStrDev = $sheetDate->format('d-m-Y');

        $societyId = $sheetDev->getSociety()->getId();
        $societyName = $sheetDev->getSociety()->getSocietyName();
        $societyAddress = $sheetDev->getSociety()->getAddress();
        $societyZipCode = $sheetDev->getSociety()->getZipcode();
        $societyCity = $sheetDev->getSociety()->getCity();
        $societyZipCitie = $societyZipCode.'-'.$societyCity;
        $societyContact = $sheetDev->getSociety()->getContact();

        $imagePath = $this->get('kernel')->getProjectDir() . '/web/media/images/locals/Acces-templates.png';
        $years = $sheetDev->getYears();
        $userId = $this->getUser()->getEmail();
        $userName = $this->getUser()->getUserName();

        $sheetDevNumber = $years.'D000'.$sheetId;

        //            USE ON CACHE
        $cache = new FilesystemCache();
        \PhpOffice\PhpSpreadsheet\Settings::setCache($cache);

        for ($i = 0; $i <= $pages; $i++) {

            $sheetName = $societyName.$sheetDevNumber;
            $iUp = $i + 1;
            if ($pages != null){
                $pagesUp = $pages + 1;
            }
            else{
                $pagesUp = 1;
            }
            $autoIncrementPages = $iUp.'/'.$pagesUp;

            //            Loading template
            $templateDirectory = $this->get('kernel')->getProjectDir() . '/web/media/templates/dev-template.xlsx';
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templateDirectory);

            //            GENERATING XLSX FILE
//            PROPERTIES OF THE XLSX DOCUMENT
            $spreadsheet->getProperties()
                ->setCreator('A.C.C.E.S')
                ->setTitle($sheetName)
                ->setSubject($sheetName)
                ->setDescription('Génération de documents Excel Devis et Factures.')
                ->setKeywords($sheetName)
                ->setCategory('Excel 2013 XLSX');

//            TITLE OF PAGE AND BODY OF XLSX
            /* @var $sheet Worksheet */
            try {
                $worksheet = $spreadsheet->getActiveSheet();
                $worksheet->setCellValue('G4', $sheetDateStrDev);
                $worksheet->setCellValue('F13', $societyContact);
                $worksheet->setCellValue('E9', $societyName);
                $worksheet->setCellValue('E10', $societyAddress);
                $worksheet->setCellValue('E11', $societyZipCitie);
                $worksheet->setCellValue('B16', $sheetDevNumber);
                $worksheet->setCellValue('B13', $userId);
                $worksheet->setCellValue('H57', $autoIncrementPages);


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
            if ($pages != null){
                $sheetDevNumberLoop = $sheetDevNumber.'_'.$iUp;
                $fileName = $sheetDevNumberLoop.'.xls';
            }
            else{
//                $sheetDevNumberLoop = $sheetDevNumber.'_'.$iUp;
                $fileName = $sheetDevNumber.'.xls';
            }
//
            $publicDirectory = $this->get('kernel')->getProjectDir() . '/web/media/documents/devis';
//             e.g /var/www/project/public/my_first_excel_symfony4.xls
            $excelFilepath = $publicDirectory . '/' . $fileName;

                try {
                    $writer = IOFactory::createWriter($spreadsheet, 'Xls');
                } catch (Exception $e) {
                }
                try {
                    $writer->save($excelFilepath);
                } catch (Exception $e) {
                }
        }

            $spreadsheet->disconnectWorksheets();
            unset($spreadsheet);

            $sheetLink = 1;
            $sheetDatas = array($fileName, $sheetId, $sheetLink);
            return $this->redirectToRoute('link_new', array('sheetDatas' => $sheetDatas));

    }

    /**
     * Finds and displays a sheetDev entity.
     *
     */
    public function showAction(SheetDev $sheetDev)
    {
        $deleteForm = $this->createDeleteForm($sheetDev);

        $em = $this->getDoctrine()->getManager();
        $sheets = $em->getRepository('AppBundle:Sheet')->findBy(array('sheetdev' => $sheetDev));

        return $this->render('sheetdev/show.html.twig', array(
            'sheetDev' => $sheetDev,
            'sheets' => $sheets,
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
        $editForm = $this->createForm('AppBundle\Form\SheetDevEditType', $sheetDev);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sheetdev_show', array('id' => $sheetDev->getId()));
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
