<?php

namespace AppBundle\Controller;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SpreadSheetController extends Controller
{
    public function SpreadAction(){

        $cache = new FilesystemCache();
        \PhpOffice\PhpSpreadsheet\Settings::setCache($cache);

        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()
                    ->setCreator("Société xxxx")
                    ->setTitle("Office 2007 XLSX Test Document")
                    ->setSubject("Office 2007 XLSX Test Document")
                    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                    ->setKeywords("office 2007 openxml php")
                    ->setCategory("Test result file");

        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("My First Worksheet");
        $sheet->setCellValue('A1', 'Hello World !');


        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);

        // Create a Temporary file in the system
        $fileName = 'Facture 1.xlsx';

        $publicDirectory = $this->get('kernel')->getProjectDir() . '/web/media/documents';
        // e.g /var/www/project/public/my_first_excel_symfony4.xlsx
        $excelFilepath =  $publicDirectory . '/'. $fileName;

        // Redirect output to a client’s web browser (Xls)
        header('Content-Type: application/vnd.ms-excel');
//        header('Content-Disposition: attachment;filename='.$fileName);
//        header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
//        header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
//        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
//        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
//        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
//        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xls');
        $writer->save($excelFilepath);

        // Return the excel file as an attachment
        return $this->file($excelFilepath, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);

    }
}