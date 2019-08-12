<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Link;
use AppBundle\Entity\Sheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
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

            $em = $this->getDoctrine()->getManager();
            $em->persist($sheet);
            $em->flush();

//            GENERATING XLSX FILE
//            USE ON CACHE
            $cache = new FilesystemCache();
            \PhpOffice\PhpSpreadsheet\Settings::setCache($cache);

//            PROPERTIES OF THE XLSX DOCUMENT
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $spreadsheet->getProperties()
                ->setCreator("Société xxxx")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");

//            TITLE OF PAGE AND BODY OF XLSX
            /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle("My First Worksheet");
            $sheet->setCellValue('A1', 'Hello World !');
            $sheet->setCellValue('A2', 'Hello World !');
            $sheet->setCellValue('A3', 'Hello World !');
            $sheet->setCellValue('B1', 'Hello World !');
            $sheet->setCellValue('B2', 'Hello World !');
            $sheet->setCellValue('B3', 'Hello World !');

//            Create your Office 2007 Excel (XLSX Format)
            $writer = new Xlsx($spreadsheet);

//            Create a Temporary file in the system USE THE $Society AND TESTING THE ID
            $fileName = 'Facture 1.xlsx';

            $publicDirectory = $this->get('kernel')->getProjectDir() . '/web/media/documents';
            // e.g /var/www/project/public/my_first_excel_symfony4.xlsx
            $excelFilepath = $publicDirectory . '/' . $fileName;

            $writer = IOFactory::createWriter($spreadsheet, 'Xls');
            $writer->save($excelFilepath);

            return $this->redirectToRoute('sheet_show', array('id' => $sheet->getId()));
        }

        return $this->render('sheet/new.html.twig', array(
            'sheet' => $sheet,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a sheet entity.
     *
     */
    public function showAction(Sheet $sheet)
    {
        $deleteForm = $this->createDeleteForm($sheet);

        return $this->render('sheet/show.html.twig', array(
            'sheet' => $sheet,
            'delete_form' => $deleteForm->createView(),
        ));
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
