<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $userId = $this->getUser();
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/", name="password")
     */
    public function loginAction()
    {
        return $this->render('@FOSUser/Security/login.html.twig');
    }
}
