<?php


namespace AppBundle\Services;

use AppBundle\Entity\Link;
use AppBundle\Entity\SheetDev;
use AppBundle\Entity\Sheet;
use AppBundle\Entity\Delivery;
use Symfony\Component\Cache\Simple\FilesystemCache;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;

class LinkService extends Controller
{

    protected $container;

    public function __construct(Container $container) {
        $this->container = $container;

    }

    /**
     * Taking information of the last generate document
     */
    public function newLink($sheetDatas){

        $fileName = $sheetDatas[0];
        $sheetId = $sheetDatas[1];
        $sheetLink = $sheetDatas[2];

        if ($sheetLink == 1){
            $link = new Link();
            $link->setLinkname($fileName);
            $link->setLink('media/documents/devis/'.$fileName);
            $link->setSheetdev1($sheetId);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($link);
            $entityManager->flush();

            return $this->redirectToRoute('sheetdev_index');
        }
        elseif ($sheetLink == 2){
            $link = new Link();
            $link->setLinkname($fileName);
            $link->setLink('media/documents/devis/'.$fileName);
            $link->setSheet1($sheetId);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($link);
            $entityManager->flush();
        }
        else{
            $link = new Link();
            $link->setLinkname($fileName);
            $link->setLink('media/documents/devis/'.$fileName);
            $link->setDelivery1($sheetId);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($link);
            $entityManager->flush();
        }

    }
}