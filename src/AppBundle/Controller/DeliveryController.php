<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Delivery;
use AppBundle\Entity\Link;
use AppBundle\Entity\SheetDev;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\HttpFoundation\Request;

/**
 * Delivery controller.
 *
 */
class DeliveryController extends Controller
{
    /**
     * Lists all delivery entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $deliveries = $em->getRepository('AppBundle:Delivery')->findAll();

        return $this->render('delivery/index.html.twig', array(
            'deliveries' => $deliveries,
        ));
    }

    /**
     * Creates a new delivery entity.
     *
     */
    public function newAction(Request $request)
    {
        $delivery = new Delivery();
        $form = $this->createForm('AppBundle\Form\DeliveryType', $delivery);
        $form->handleRequest($request);

        //      Call to Entities and count entries
        $em = $this->getDoctrine()->getManager();
        $countDelivery = $em->getRepository('AppBundle:Delivery')->countByDev();
        $hightId = $em->getRepository('AppBundle:Delivery')->hightId();

        if ($form->isSubmitted() && $form->isValid()) {
//            TESTING $newSheetDevID IF is NULL OR NOT
//            IF IT'S DIFFERENT OF NULL
            $newDelivery = $request->request->get('count');
            $check = $request->request->get('check');
            if($check == null and $newDelivery == null){
                if ($sheetDev = $delivery->getSheetdev() != null || $sheet = $delivery->getSheet() != null) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($delivery);
                    $em->flush();

                    return $this->redirectToRoute('sheetdel_spread', array('id' => $delivery->getId()));
                }
                return $this->render('delivery/new.html.twig', array(
                    'sheetDev' => $sheetDev,
                    'count' => $countDelivery,
                    'hight' => $hightId,
                    'form' => $form->createView(),
                ));
            }
            else{
//                TESTING IF COUNT OF ENTRIES IS LESS THAN THE NEW ENTRY
//                MAKE A LOOP WHILE LESS THAN NEW ENTRY
                while ($countDelivery < $newDelivery){
                    $delivery = new Delivery();
                    $delivery->setYears('90');
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($delivery);
                    $countDelivery++;
                }
                $em->flush();
//              FORCED DATA FOR AUTOMATIC REMOVE
                for($i = 0; $i <= $countDelivery; $i++){
                    $deliveries = $em->getRepository('AppBundle:Delivery')->findBy(array('id' => $i));
                    foreach ($deliveries as $delivery){
                        $em = $this->getDoctrine()->getManager();
                        $em->remove($delivery);
                    }
                }
                $em->flush();
//                    LOOP IS FINISHED RETURN TO NEW PAGE
                return $this->redirectToRoute('delivery_index', array(
                    'sheetDev' => $delivery,
                    'count' => $countDelivery,
                    'hight' => $hightId,
                    'form' => $form->createView(),
                ));
            }
        }

        return $this->render('delivery/new.html.twig', array(
            'delivery' => $delivery,
            'count' => $countDelivery,
            'hight' => $hightId,
            'form' => $form->createView(),
        ));
    }

    public function spreadSheetDelAction(Delivery $delivery)
    {
        $deliveryId = $delivery->getId();
        $deliveryDate = $delivery->getDate();
        $deliveryDateStr = $deliveryDate->format('dmY');
        $deliveryDateStrDev = $deliveryDate->format('d-m-Y');

        $sheetYears = $delivery->getSheet()->getYears();
        $sheetId = $delivery->getSheet()->getId();
        $sheetDevYears = $delivery->getSheet()->getSheetdev()->getYears();
        $sheetDevId = $delivery->getSheet()->getSheetdev()->getId();

        $societyId = $delivery->getSheet()->getSheetdev()->getSociety()->getId();
        $societyName = $delivery->getSheet()->getSheetdev()->getSociety()->getSocietyName();
        $societyAddress = $delivery->getSheet()->getSheetdev()->getSociety()->getAddress();
        $societyZipCode = $delivery->getSheet()->getSheetdev()->getSociety()->getZipcode();
        $societyCity = $delivery->getSheet()->getSheetdev()->getSociety()->getCity();

        $imagePath = $this->get('kernel')->getProjectDir() . '/web/media/images/locals/Acces2020.png';
        $years = $delivery->getYears();
        $userId = $this->getUser()->getEmail();

        $deliveryNumber = $years.'BL00'.$deliveryId;
        $sheet = $sheetYears.'/00'.$sheetId;
        $sheetDev = $sheetDevYears.'D00'.$sheetDevId;

        //            USE ON CACHE
        $cache = new FilesystemCache();
        \PhpOffice\PhpSpreadsheet\Settings::setCache($cache);

        $sheetName = $societyName.$deliveryNumber;

        //            Loading template
        $templateDirectory = $this->get('kernel')->getProjectDir() . '/web/media/templates/bl-template.xls';
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
            $worksheet->setCellValue('E5', $deliveryDateStrDev);
            $worksheet->setCellValue('H4', $userId);
            $worksheet->setCellValue('H7', $sheetDev);
            $worksheet->setCellValue('H8', $sheet);
            $worksheet->setCellValue('C7', $deliveryNumber);
            $worksheet->setCellValue('B18', $societyName);
            $worksheet->setCellValue('B19', $societyAddress);
            $worksheet->setCellValue('B20', $societyZipCode);
            $worksheet->setCellValue('B21', $societyCity);
            $worksheet->setCellValue('G18', $societyName);
            $worksheet->setCellValue('G19', $societyAddress);
            $worksheet->setCellValue('G20', $societyZipCode);
            $worksheet->setCellValue('G21', $societyCity);

            $sheeti = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $sheeti->setName('acces');
            $sheeti->setDescription('logo');
            $sheeti->setPath($imagePath);
            $sheeti->setHeight(90);
            $sheeti->setCoordinates("B1");
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
        header('Expires: '.$deliveryDateStr); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

//            Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);

//            Create a Temporary file in the system USE THE $Society AND TESTING THE ID
        $fileName = $deliveryNumber.'.xls';
//
        $publicDirectory = $this->get('kernel')->getProjectDir() . '/web/media/documents/livraisons';
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

        $sheetLink = 3;
        $sheetDatas = array($fileName, $deliveryId, $sheetLink);
        return $this->redirectToRoute('link_new', array('sheetDatas' => $sheetDatas));

    }

    /**
     * Finds and displays a delivery entity.
     *
     */
    public function showAction(Delivery $delivery)
    {
        $deleteForm = $this->createDeleteForm($delivery);

        return $this->render('delivery/show.html.twig', array(
            'delivery' => $delivery,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing delivery entity.
     *
     */
    public function editAction(Request $request, Delivery $delivery)
    {
        $deleteForm = $this->createDeleteForm($delivery);
        $editForm = $this->createForm('AppBundle\Form\DeliveryEditType', $delivery);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('delivery_index', array('id' => $delivery->getId()));
        }

        return $this->render('delivery/edit.html.twig', array(
            'delivery' => $delivery,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a delivery entity.
     *
     */
    public function deleteAction(Request $request, Delivery $delivery)
    {
        $form = $this->createDeleteForm($delivery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($delivery);
            $em->flush();
        }

        return $this->redirectToRoute('delivery_index');
    }

    /**
     * Creates a form to delete a delivery entity.
     *
     * @param Delivery $delivery The delivery entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Delivery $delivery)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('delivery_delete', array('id' => $delivery->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
