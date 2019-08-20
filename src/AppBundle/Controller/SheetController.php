<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Link;
use AppBundle\Entity\Sheet;
use AppBundle\Entity\society;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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

        if ($form->isSubmitted() && $form->isValid()) {

//            $sheet->setDate(new \DateTime('now'));

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
        $sheetDateStr = $sheetDate->format('d-m-Y');
        $sheetFacture = $sheet->getFacture();
        $societyId = $sheet->getSociety()->getId();
        $societyName = $sheet->getSociety()->getSocietyName();
        $societyAddress = $sheet->getSociety()->getAddress();
        $societyZipCode = $sheet->getSociety()->getZipcode();
        $societyCity = $sheet->getSociety()->getCity();

        if($sheetFacture != 0){
            $sheetFacture = 'Fac';

            $inputFileName = $this->get('kernel')->getProjectDir() . '/web/media/templates/fac-template.xlsx';
            $spreadsheet = IOFactory::load($inputFileName);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        }
        else{
            $sheetFacture = 'Dev';
        }

        $sheetTitle = $sheetFacture.'-'.$societyName.'-'.$sheetId;
        $sheetName = $sheetFacture.'-'.$societyName.$sheetDateStr.'-'.$sheetId;

        //            GENERATING XLSX FILE
//            USE ON CACHE
        $cache = new FilesystemCache();
        \PhpOffice\PhpSpreadsheet\Settings::setCache($cache);

//            PROPERTIES OF THE XLSX DOCUMENT
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet($sheet);
        $spreadsheet->getProperties()
            ->setCreator("Unknow")
            ->setTitle($sheetTitle)
            ->setSubject($sheetName.'-'.$societyName.$sheetId)
            ->setDescription("Génération de documents Excel Devis et Factures.")
            ->setKeywords($sheetName)
            ->setCategory("Excel 2013 XLSX");

        $spreadsheet->getDefaultStyle()
            ->getFont()
            ->setName('Arial')
            ->setSize(12);

//            TITLE OF PAGE AND BODY OF XLSX
        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle($sheetTitle);
        $sheet->setCellValue('A1', $societyName);
        $sheet->setCellValue('A2', $societyAddress);
        $sheet->setCellValue('A3', $societyZipCode);
        $sheet->setCellValue('B1', $societyCity);
        $sheet->setCellValue('B2', $sheetId);
        $sheet->setCellValue('B3', $sheetDateStr);
        $sheet->setCellValue('B4', $sheetFacture);

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$sheetName);
        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
        header('Expires: '.$sheetDate); // Date in the past
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

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save($excelFilepath);

        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);

        $link = new Link();
        $link->setLinkname($fileName);
        $link->setLink('media/documents/'.$fileName);
        $link->setSheet($sheetId);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($link);
        $entityManager->flush();

        return $this->redirectToRoute('homepage', array(
            'id' => $sheetId,
            'excelFilepath' => $excelFilepath,
            'fileName' => $fileName,
            )
        );
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
