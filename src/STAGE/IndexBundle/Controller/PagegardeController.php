<?php

namespace STAGE\IndexBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PagegardeController extends Controller
{
    public function indexAction()
    {
        return $this->render('STAGEIndexBundle:Pagegarde:index.html.twig');
    }
}
