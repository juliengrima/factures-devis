<?php


namespace AppBundle\Services;

use AppBundle\Entity\Link;
use AppBundle\Entity\Sheet;
use AppBundle\Entity\SheetDev;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;


class SpreadService extends Controller
{
    protected $container;

    public function __construct(Container $container) {
        $this->container = $container;

    }

    public function spreadSheetAction($sheetDev)
    {
        $sheetId = $sheetDev->getId();
        $sheetDate = $sheetDev->getDate();
        $sheetDateStr = $sheetDate->format('dmY');
        $sheetDateStrDev = $sheetDate->format('d-m-Y');

        $societyId = $sheetDev->getSociety()->getId();
        $societyName = $sheetDev->getSociety()->getSocietyName();
        $societyAddress = $sheetDev->getSociety()->getAddress();
        $societyZipCode = $sheetDev->getSociety()->getZipcode();
        $societyCity = $sheetDev->getSociety()->getCity();

        $providerId = $sheetDev->getProvider()->getId();
        $providerName = $sheetDev->getProvider()->getProvider();
        $providerContact = $sheetDev->getProvider()->getContact();
        $years = $sheetDev->getYears();

        $imagePath = $this->get('kernel')->getProjectDir() . '/web/media/images/locals/Acces.png';

        if(isset($societyId)){
            $sheetDevNumber = $years.'D00'.$sheetId;
            $sheetName = $societyName.$sheetDevNumber;
        }
        else{
            $sheetDevNumber = $years.'/00'.$sheetId;
            $sheetName = $providerName.$sheetDevNumber;
        }

        //            USE ON CACHE
        $cache = new FilesystemCache();
        \PhpOffice\PhpSpreadsheet\Settings::setCache($cache);

        //            Loading template
        $templateDirectory = $this->get('kernel')->getProjectDir() . '/web/media/templates/dev-template.xlsx';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templateDirectory);

        //            GENERATING XLSX FILE
//            PROPERTIES OF THE XLSX DOCUMENT
        $spreadsheet->getProperties()
            ->setCreator('A.C.C.E.S')
            ->setTitle($sheetName)
            ->setSubject($sheetName)
            ->setDescription('Génération de documents Excel Devis et Commandes.')
            ->setKeywords($sheetName)
            ->setCategory('Excel 2013 XLSX');

//            TITLE OF PAGE AND BODY OF XLSX
        /* @var $sheet Worksheet */
        try {
            $worksheet = $spreadsheet->getActiveSheet();
            $worksheet->setCellValue('A1', $imagePath);
            $worksheet->setCellValue('G2', $sheetDateStrDev);
            $worksheet->setCellValue('E7', $societyName);
            $worksheet->setCellValue('E8', $societyAddress);
            $worksheet->setCellValue('E9', $societyZipCode);
            $worksheet->setCellValue('F9', $societyCity);
            $worksheet->setCellValue('B14', $sheetDevNumber);

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
        $fileName = $sheetDevNumber.'.xlsx';
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

        $sheetLink = 0;

        $link = new Link();
        $link->setLinkname($fileName);
        $link->setLink('media/documents/devis/'.$fileName);
        $link->setSheetdev($sheetId);
        $link->setSheet($sheetLink);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($link);
        $entityManager->flush();

        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);

        if(isset($sheetDev)){
            return $sheetDev;
        }
        else{
            return $sheet;
        }

    }
}