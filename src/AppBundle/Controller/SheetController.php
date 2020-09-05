<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Link;
use AppBundle\Entity\Sheet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Cache\Simple\FilesystemCache;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet;

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

        return $this->render('sheet/index.html.twig', array(
            'sheets' => $sheets,
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

//      Call to Entities and count entries
        $em = $this->getDoctrine()->getManager();
        $countSheetId = $em->getRepository('AppBundle:Sheet')->countByDev();
        $hightId = $em->getRepository('AppBundle:Sheet')->hightId();

        if ($form->isSubmitted() && $form->isValid()) {
//            TESTING $newSheetDevID IF is NULL OR NOT
//            IF IT'S DIFFERENT OF NULL
            $newsheetId = $request->request->get('count');
            if(isset($newsheetId) != null and $sheet->getProvider() == null) {
//                TESTING IF COUNT OF ENTRIES IS LESS THAN THE NEW ENTRY
//                MAKE A LOOP WHILE LESS THAN NEW ENTRY
                while ($countSheetId < $newsheetId){
                    $sheet = new Sheet();
                    $sheet->setYears('90');
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($sheet);
                    $countSheetId++;
                }
                $em->flush();
//              FORCED DATA FOR AUTOMATIC REMOVE
                for($i = 0; $i <= $countSheetId; $i++){
                    $sheets = $em->getRepository('AppBundle:Sheet')->findBy(array('id' => $i));
                    foreach ($sheets as $sheet){
                        $em = $this->getDoctrine()->getManager();
                        $em->remove($sheet);
                    }
                }
                $em->flush();
//                    LOOP IS FINISHED RETURN TO NEW PAGE
                return $this->render('sheet/new.html.twig', array(
                    'sheetDev' => $sheet,
                    'count' => $countSheetId,
                    'hight' => $hightId,
                    'form' => $form->createView(),
                ));
            }
//            ENTRY $newSheetDevId IS NULL SO GENERATE A NEW SHEET
            else{
                if ($sheet->getProvider() != null) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($sheet);
                    $em->flush();

                    return $this->redirectToRoute('sheet_spread', array('id' => $sheet->getId()));
                }
                return $this->render('sheet/new.html.twig', array(
                    'sheetDev' => $sheet,
                    'count' => $countSheetId,
                    'hight' => $hightId,
                    'form' => $form->createView(),
                ));
            }
        }

        return $this->render('sheet/new.html.twig', array(
            'sheet' => $sheet,
            'count' => $countSheetId,
            'hight' => $hightId,
            'form' => $form->createView(),
        ));
    }

    public function spreadSheetAction(sheet $sheet){

        $sheetId = $sheet->getId();
        $sheetDate = $sheet->getDate();
        $sheetDevId = $sheet->getSheetdev()->getId();
        $sheetDevYears = $sheet->getSheetdev()->getYears();
        $sheetDateStr = $sheetDate->format('dmY');
        $sheetDateStrDev = $sheetDate->format('d-m-Y');

        $providerId = $sheet->getProvider()->getId();
        $providerName = $sheet->getProvider()->getProvider();
        $providerContact = $sheet->getProvider()->getContact();
        $imagePath = $this->get('kernel')->getProjectDir() . '/web/media/images/locals/Acces2020.png';
        $sheetYears = $sheet->getYears();
        $userId = $this->getUser()->getEmail();

        $sheetNumber = $sheetYears.'/00'.$sheetId;
        $sheetDevNumber = $sheetDevYears.'D00'.$sheetDevId;
        $sheetFileName = $sheetYears.'-00'.$sheetId;

        //            USE ON CACHE
        $cache = new FilesystemCache();
        \PhpOffice\PhpSpreadsheet\Settings::setCache($cache);

        $sheetName = $providerName.$sheetFileName;

        //            Loading template
        $templateDirectory = $this->get('kernel')->getProjectDir() . '/web/media/templates/fac-template.xlsx';
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
            $worksheet->setCellValue('G2', $sheetDateStrDev);
            $worksheet->setCellValue('B11', $userId);
            $worksheet->setCellValue('C14', $providerName);
            $worksheet->setCellValue('H14', $providerContact);
            $worksheet->setCellValue('C15', $sheetNumber);
            $worksheet->setCellValue('D16', $sheetDevNumber);

            $sheeti = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $sheeti->setName('acces');
            $sheeti->setDescription('logo');
            $sheeti->setPath($imagePath);
            $sheeti->setHeight(80);
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
        $fileName = $sheetFileName.'.xls';

        var_dump($fileName);
//
        $publicDirectory = $this->get('kernel')->getProjectDir() . '/web/media/documents/commandes';
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

        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);

        $sheetLink = 2;
        $sheetDatas = array($fileName, $sheetId, $sheetLink);
        return $this->redirectToRoute('link_new', array('sheetDatas' => $sheetDatas));

    }

    /**
     * Displays a form to edit an existing sheet entity.
     *
     */
    public function editAction(Request $request, Sheet $sheet)
    {
        $deleteForm = $this->createDeleteForm($sheet);
        $editForm = $this->createForm('AppBundle\Form\SheetTypeEdit', $sheet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sheet_index', array('id' => $sheet->getId()));
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
