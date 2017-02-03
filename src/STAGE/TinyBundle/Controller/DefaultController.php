<?php

namespace STAGE\TinyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('STAGETinyBundle:Default:index.html.twig');
    }

public function newAction(Request $request){
    $gets = $request->request->all();
}



}
